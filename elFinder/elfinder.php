<?php
use Xmf\Request;

require_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';

// 避免包含使用者檔案資訊的頁面被快取。
header('Cache-Control: no-store, private, max-age=0');
header('Pragma: no-cache');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');

// 允許同源頁面嵌入，但禁止其他網站嵌入。
header('X-Frame-Options: SAMEORIGIN');
header("Content-Security-Policy: frame-ancestors 'self'; base-uri 'self'");

if (!$xoopsUser) {
    header('Location: ' . XOOPS_URL, true, 302);
    exit;
}

header('Content-Type: text/html; charset=UTF-8');

$badRequest = static function () {
    http_response_code(400);
    header('Content-Type: text/plain; charset=UTF-8');
    echo '請求參數不合法。';
    exit;
};

// 本頁只從 GET 取得這三個參數，避免陣列參數及 POST/Cookie 混入。
$getParameter = static function ($name) use ($badRequest) {
    if (!isset($_GET[$name])) {
        return '';
    }

    if (!is_string($_GET[$name])) {
        $badRequest();
    }

    return Request::getString($name, '', 'GET');
};

$type   = $getParameter('type');
$modDir = $getParameter('mod_dir');
$subDir = $getParameter('subDir');

if ($type === '') {
    $type = 'file';
}

if (!in_array($type, ['image', 'file'], true)) {
    $badRequest();
}

// 模組名稱不得包含路徑分隔符號。
// 空值是否可存取預設根目錄，必須由 connector 決定。
if (
    $modDir !== ''
    && !preg_match('/\A[A-Za-z0-9_][A-Za-z0-9_-]{0,63}\z/', $modDir)
) {
    $badRequest();
}

// 僅允許相對子目錄，例如 images/2026。
// 拒絕絕對路徑、空路徑段、.、..、反斜線及 URL 編碼殘留。
if (strlen($subDir) > 1024) {
    $badRequest();
}

// elFinder 的目錄路徑可能以斜線開頭；只移除一個開頭斜線，
// 讓 /1/22/54 可正常使用，同時讓 //1 仍會因為含有空路徑段而被拒絕。
if (substr($subDir, 0, 1) === '/') {
    $subDir = substr($subDir, 1);
}

if ($subDir !== '') {
    foreach (explode('/', $subDir) as $segment) {
        if (
            $segment === ''
            || $segment === '.'
            || $segment === '..'
            || $segment !== trim($segment)
            || substr($segment, -1) === '.'
            || !preg_match('/\A[\p{L}\p{N}_. -]+\z/u', $segment)
        ) {
            $badRequest();
        }
    }
}

// CKEditor 回呼編號必須是合理範圍內的整數。
$callbackNumber = null;

if (isset($_GET['CKEditorFuncNum'])) {
    $rawCallback = $_GET['CKEditorFuncNum'];

    if (
        !is_string($rawCallback)
        || !preg_match('/\A[0-9]{1,10}\z/', $rawCallback)
        || (float) $rawCallback > 2147483647
    ) {
        $badRequest();
    }

    $callbackNumber = (int) $rawCallback;
}

$langCode = str_replace('-', '_', _LANGCODE);

$connectorUrl = XOOPS_URL
    . '/modules/tadtools/elFinder/php/connector.minimal.php?'
    . http_build_query(
        [
            'type'    => $type,
            'mod_dir' => $modDir,
            'subDir'  => $subDir,
        ],
        '',
        '&',
        PHP_QUERY_RFC3986
    );

$mainUrl    = XOOPS_URL . '/modules/tadtools/elFinder/main.js';
$requireUrl = XOOPS_URL . '/modules/tadtools/elFinder/require.min.js';

$jsonFlags = JSON_HEX_TAG
    | JSON_HEX_AMP
    | JSON_HEX_APOS
    | JSON_HEX_QUOT;

$clientConfig = json_encode(
    [
        'connectorUrl'   => $connectorUrl,
        'lang'           => $langCode,
        'callbackNumber' => $callbackNumber,
    ],
    $jsonFlags
);

if ($clientConfig === false) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    echo '無法建立檔案管理器設定。';
    exit;
}

$escapeHtml = static function ($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
};
?>
<!DOCTYPE html>
<html lang="<?php echo $escapeHtml(str_replace('_', '-', $langCode)); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
        <title>檔案管理器</title>

        <!-- 使用本機 RequireJS；請先部署 require.min.js -->
        <script
            data-main="<?php echo $escapeHtml($mainUrl); ?>"
            src="<?php echo $escapeHtml($requireUrl); ?>"
        ></script>

        <script>
            (function () {
                'use strict';

                var config = <?php echo $clientConfig; ?>;

                // 預設只允許本站檔案網址。
                // 若檔案使用獨立 CDN，應明確列出可信任的 origin，
                // 不要改成接受任意網域。
                var allowedFileOrigins = [window.location.origin];

                var managerOptions = {
                    height: '100%',
                    resizable: false
                };

                // 沒有 CKEditor 回呼參數時，使用一般檔案管理模式。
                if (config.callbackNumber !== null) {
                    managerOptions.getFileCallback = function (file, fm) {
                        try {
                            var opener = window.opener;

                            // 跨來源 opener 的屬性存取會拋出例外，
                            // 由下方 catch 處理。
                            if (
                                !opener
                                || opener.closed
                                || opener.location.origin !== window.location.origin
                                || !opener.CKEDITOR
                                || !opener.CKEDITOR.tools
                                || typeof opener.CKEDITOR.tools.callFunction !== 'function'
                            ) {
                                throw new Error('Invalid editor window');
                            }

                            if (!file || typeof file.url !== 'string') {
                                throw new Error('Invalid file URL');
                            }

                            var absoluteUrl = fm.convAbsUrl(file.url);
                            var parsedUrl = new URL(
                                absoluteUrl,
                                window.location.href
                            );

                            if (
                                (
                                    parsedUrl.protocol !== 'https:'
                                    && parsedUrl.protocol !== 'http:'
                                )
                                || parsedUrl.username
                                || parsedUrl.password
                                || allowedFileOrigins.indexOf(parsedUrl.origin) === -1
                            ) {
                                throw new Error('Untrusted file URL');
                            }

                            opener.CKEDITOR.tools.callFunction(
                                config.callbackNumber,
                                parsedUrl.href
                            );
                        } catch (error) {
                            window.alert(
                                '無法將檔案回傳至編輯器：請確認編輯器視窗及檔案網址均來自可信任的網站。'
                            );
                            return;
                        }

                        fm.destroy();
                        window.close();
                    };
                }

                define('elFinderConfig', {
                    defaultOpts: {
                        url: config.connectorUrl,
                        lang: config.lang,
                        commandsOptions: {
                            edit: {
                                extraOptions: {
                                    creativeCloudApiKey: '',
                                    managerUrl: ''
                                }
                            },
                            quicklook: {
                                // 停用這三種第三方預覽服務，
                                // 避免將檔案網址傳送給外部服務。
                                sharecadMimes: [],
                                googleDocsMimes: [],
                                officeOnlineMimes: []
                            }
                        },
                        bootCallback: function (fm, extraObj) {
                            var title = document.title;

                            fm.bind('open', function () {
                                var cwd = fm.cwd();
                                var path = cwd ? fm.path(cwd.hash) : '';

                                // document.title 不會將路徑解析成 HTML。
                                document.title = path
                                    ? path + ':' + title
                                    : title;
                            }).bind('destroy', function () {
                                document.title = title;
                            });
                        }
                    },
                    managers: {
                        'elfinder': managerOptions
                    }
                });
            }());
        </script>
    </head>
    <body>
        <div id="elfinder"></div>
    </body>
</html>
