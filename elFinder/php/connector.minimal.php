<?php
use XoopsModules\Tadtools\Utility;

require_once dirname(__DIR__, 4) . '/mainfile.php';

// 錯誤只寫入紀錄，不輸出到畫面，避免破壞 elFinder 的 JSON 回應或洩漏路徑。
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

header('X-Content-Type-Options: nosniff');

/**
 * 以 elFinder 可顯示的格式回傳錯誤並結束。
 */
function tadtools_elfinder_deny($status, $message)
{
    http_response_code($status);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['error' => [$message]], JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * 取得 URL 的 origin（scheme://host[:port]），無法解析時回傳空字串。
 */
function tadtools_elfinder_origin($url)
{
    $p = parse_url((string) $url);
    if (empty($p['scheme']) || empty($p['host'])) {
        return '';
    }
    return strtolower($p['scheme'] . '://' . $p['host'] . (isset($p['port']) ? ':' . $p['port'] : ''));
}

/**
 * 判斷請求是否來自本站頁面（CSRF 防護）。
 */
function tadtools_elfinder_is_same_origin()
{
    $siteOrigin = tadtools_elfinder_origin(XOOPS_URL);
    if ($siteOrigin === '') {
        return false;
    }

    // 瀏覽器有提供 Fetch Metadata 時，必須是同源請求。
    if (isset($_SERVER['HTTP_SEC_FETCH_SITE']) && $_SERVER['HTTP_SEC_FETCH_SITE'] !== 'same-origin') {
        return false;
    }

    if (!empty($_SERVER['HTTP_ORIGIN'])) {
        return tadtools_elfinder_origin($_SERVER['HTTP_ORIGIN']) === $siteOrigin;
    }

    if (!empty($_SERVER['HTTP_REFERER'])) {
        return tadtools_elfinder_origin($_SERVER['HTTP_REFERER']) === $siteOrigin;
    }

    return false;
}

/**
 * 判斷 $child 是否等於或位於 $parent 之內（皆須為 realpath 結果）。
 */
function tadtools_elfinder_is_inside($child, $parent)
{
    $child  = rtrim(str_replace('\\', '/', (string) $child), '/');
    $parent = rtrim(str_replace('\\', '/', (string) $parent), '/');
    if ($child === '' || $parent === '') {
        return false;
    }
    if (DIRECTORY_SEPARATOR === '\\') {
        $child  = strtolower($child);
        $parent = strtolower($parent);
    }
    return $child === $parent || strpos($child . '/', $parent . '/') === 0;
}

/**
 * elFinder 檔案存取控制：隱藏並禁止存取以 "." 開頭的檔案或資料夾。
 */
function tadtools_elfinder_access($attr, $path, $data, $volume, $isDir, $relpath)
{
    $basename = basename($path);
    return substr($basename, 0, 1) === '.'
    && strlen($relpath) !== 1
    ? !($attr === 'read' || $attr === 'write')
    : null;
}

// =============================================
// 1. 必須登入
// =============================================
global $xoopsUser;
if (!isset($xoopsUser) || !is_object($xoopsUser)) {
    tadtools_elfinder_deny(403, '請先登入。');
}

// =============================================
// 2. CSRF：非唯讀指令必須來自本站頁面
// =============================================
$cmdRaw = $_POST['cmd'] ?? ($_GET['cmd'] ?? '');
if (!is_string($cmdRaw)) {
    tadtools_elfinder_deny(400, '請求參數不合法。');
}

$readOnlyCommands = ['', 'open', 'ls', 'tree', 'parents', 'tmb', 'file', 'size', 'info', 'search', 'dim', 'get', 'ping', 'subdirs', 'zipdl', 'url', 'netmount'];
// netmount 在此列表是為了讓它被後續 disabled 設定處理；實際上已停用。

if (!in_array($cmdRaw, $readOnlyCommands, true) && !tadtools_elfinder_is_same_origin()) {
    tadtools_elfinder_deny(403, '請求來源不合法，請重新整理頁面後再操作。');
}

// =============================================
// 3. 參數驗證（不合法就拒絕，不做清洗）
// =============================================
foreach (['type', 'mod_dir', 'subDir'] as $name) {
    if (isset($_GET[$name]) && !is_string($_GET[$name])) {
        tadtools_elfinder_deny(400, '請求參數不合法。');
    }
}

$type   = $_GET['type'] ?? '';
$mdir   = $_GET['mod_dir'] ?? '';
$subDir = $_GET['subDir'] ?? '';

if ($mdir === '') {
    $mdir = $_SESSION['xoops_mod_name'] ?? '';
}

if (!is_string($mdir) || $mdir === '') {
    tadtools_elfinder_deny(400, '畫面靜止操作過久，已無法讀取檔案，請關閉視窗，並重新整理畫面再繼續操作。');
}

if (!in_array($type, ['image', 'file'], true)) {
    tadtools_elfinder_deny(400, '請求參數不合法。');
}

if (!preg_match('/\A[A-Za-z0-9_][A-Za-z0-9_-]{0,63}\z/', $mdir)) {
    tadtools_elfinder_deny(400, '請求參數不合法。');
}

$subDir      = trim($subDir, '/');
$subSegments = [];
if ($subDir !== '') {
    $subSegments = explode('/', $subDir);
    if (count($subSegments) > 10 || strlen($subDir) > 512) {
        tadtools_elfinder_deny(400, '請求參數不合法。');
    }
    foreach ($subSegments as $segment) {
        if (!preg_match('/\A[A-Za-z0-9_-]{1,64}\z/', $segment)) {
            tadtools_elfinder_deny(400, '請求參數不合法。');
        }
    }
}

// =============================================
// 4. 模組授權：模組須存在、已啟用，且使用者有該模組的存取權限
// =============================================
$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname($mdir);
if (!is_object($module) || !$module->getVar('isactive')) {
    tadtools_elfinder_deny(403, '無權限使用此模組的檔案管理功能。');
}

$groupPermHandler = xoops_getHandler('groupperm');
if (!$groupPermHandler->checkRight('module_read', $module->getVar('mid'), $xoopsUser->getGroups())) {
    tadtools_elfinder_deny(403, '無權限使用此模組的檔案管理功能。');
}

// =============================================
// 5. 建立並驗證目錄，確保不會跳出授權根目錄
// =============================================
$uploadsRoot = realpath(XOOPS_ROOT_PATH . '/uploads');
if ($uploadsRoot === false) {
    tadtools_elfinder_deny(500, '上傳目錄不存在。');
}

$basePath = XOOPS_ROOT_PATH . '/uploads/' . $mdir . '/' . $type;
if (!is_dir($basePath) && !mkdir($basePath, 0755, true) && !is_dir($basePath)) {
    tadtools_elfinder_deny(500, '無法建立上傳目錄。');
}

$baseReal = realpath($basePath);
if ($baseReal === false || !tadtools_elfinder_is_inside($baseReal, $uploadsRoot)) {
    tadtools_elfinder_deny(403, '目錄不合法。');
}

$currentPath = $baseReal;
$URL         = XOOPS_URL . '/uploads/' . $mdir . '/' . $type . '/';

foreach ($subSegments as $segment) {
    $currentPath .= DIRECTORY_SEPARATOR . $segment;

    if (!is_dir($currentPath) && !mkdir($currentPath, 0755) && !is_dir($currentPath)) {
        tadtools_elfinder_deny(500, '無法建立子目錄。');
    }

    $real = realpath($currentPath);
    if ($real === false || !tadtools_elfinder_is_inside($real, $baseReal)) {
        tadtools_elfinder_deny(403, '目錄不合法。');
    }

    $currentPath = $real;
    $URL .= $segment . '/';
}

$path = $currentPath . DIRECTORY_SEPARATOR;

// =============================================
// 6. 上傳設定
// =============================================
$TadToolsModuleConfig = Utility::getXoopsModuleConfig('tadtools');

$image_max_width  = !empty($TadToolsModuleConfig['image_max_width']) ? (int) $TadToolsModuleConfig['image_max_width'] : 640;
$image_max_height = !empty($TadToolsModuleConfig['image_max_height']) ? (int) $TadToolsModuleConfig['image_max_height'] : 640;

$imageMimes = [
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',
    'image/bmp',
    'image/x-ms-bmp',
];

// 檔案模式允許的類型；請依實際需求增減。
$fileMimes = array_merge($imageMimes, [
    'application/pdf',
    'text/plain',
    'text/csv',
    'application/zip',
    'application/x-zip-compressed',
    'application/msword',
    'application/vnd.ms-excel',
    'application/vnd.ms-powerpoint',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'application/vnd.oasis.opendocument.text',
    'application/vnd.oasis.opendocument.spreadsheet',
    'application/vnd.oasis.opendocument.presentation',
    'audio/mpeg',
    'video/mp4',
]);

$allowedMimes = $type === 'image' ? $imageMimes : $fileMimes;

// 檔名規則：不得以 "." 開頭，且（含複合副檔名）不得含可執行或主動內容的副檔名。
$acceptedName = '/^(?!\.)(?!.*\.(?:php\d?|phtml|pht|phps|phar|shtml?|cgi|pl|py|rb|asp|aspx|jsp|sh|bat|cmd|exe|dll|htaccess|htpasswd|html?|xhtml|svg|js|mjs)(?:\.|$)).+$/i';

// =============================================
// 7. elFinder 載入（使用絕對路徑）
// =============================================
$composerAutoload = __DIR__ . '/vendor/autoload.php';
if (is_readable($composerAutoload)) {
    require_once $composerAutoload;
}
require_once __DIR__ . '/autoload.php';

// 不提供遠端網路磁碟掛載（FTP 等）。
elFinder::$netDrivers = [];

$opts = [
    'bind'    => [
        'upload.presave' => [
            'Plugin.AutoResize.onUpLoadPreSave',
        ],
    ],
    'session' => null, // 禁用自訂 session handler
    'plugin'  => [
        'AutoResize' => [
            'enable'    => true,
            'maxWidth'  => $image_max_width,
            'maxHeight' => $image_max_height,
            'quality'   => 95,
        ],
    ],
    'locale'  => 'zh_TW.UTF-8',
    'roots'   => [
        [
            'driver'         => 'LocalFileSystem',
            'path'           => $path,
            'URL'            => $URL,
            'plugin'         => [
                'AutoResize' => [
                    'enable'    => true,
                    'maxWidth'  => $image_max_width,
                    'maxHeight' => $image_max_height,
                ],
            ],
            'winHashFix'     => DIRECTORY_SEPARATOR !== '/',
            'followSymLinks' => false,
            'disabled'       => ['netmount', 'extract'],
            'acceptedName'   => $acceptedName,
            'uploadMaxSize'  => '20M',
            'uploadDeny'     => ['all'],
            'uploadAllow'    => $allowedMimes,
            'uploadOrder'    => ['deny', 'allow'],
            'accessControl'  => 'tadtools_elfinder_access',
        ],
    ],
];

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();