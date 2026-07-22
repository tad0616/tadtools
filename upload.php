<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;

//此檔案是給 CkEditor.php 用的，勿刪
require_once dirname(dirname(__DIR__)) . '/mainfile.php';
if (!$xoopsUser) {
    exit;
}
if (empty($_SERVER['HTTP_REFERER']) || !tadtools_is_same_site_url($_SERVER['HTTP_REFERER'], XOOPS_URL)) {
    die("非法調用");
}

require_once __DIR__ . '/upload/class.upload.php';

$data = ['uploaded' => 0];

function tadtools_upload_fail($message = '')
{
    Utility::dd([
        'uploaded' => 0,
        'error'    => ['message' => $message],
    ]);
    exit;
}

function tadtools_is_same_site_url($url, $siteUrl)
{
    $urlParts  = parse_url($url);
    $siteParts = parse_url($siteUrl);

    if (empty($urlParts['scheme']) || empty($urlParts['host']) || empty($siteParts['scheme']) || empty($siteParts['host'])) {
        return false;
    }

    $urlScheme  = strtolower($urlParts['scheme']);
    $siteScheme = strtolower($siteParts['scheme']);
    $urlPort    = isset($urlParts['port']) ? (int) $urlParts['port'] : ($urlScheme === 'https' ? 443 : 80);
    $sitePort   = isset($siteParts['port']) ? (int) $siteParts['port'] : ($siteScheme === 'https' ? 443 : 80);

    return $urlScheme === $siteScheme && strtolower($urlParts['host']) === strtolower($siteParts['host']) && $urlPort === $sitePort;
}

function tadtools_clean_path_segment($value, $allowSlash = false)
{
    $value   = trim(str_replace('\\', '/', $value), '/');
    $pattern = $allowSlash ? '/^[a-zA-Z0-9_\-\/]*$/' : '/^[a-zA-Z0-9_\-]+$/';

    if ($value === '' || !preg_match($pattern, $value) || strpos($value, '..') !== false) {
        return '';
    }

    return $value;
}

function tadtools_is_private_host($host)
{
    $host = strtolower(trim($host, '[]'));

    if ($host === 'localhost' || $host === '') {
        return true;
    }

    $ips = [];
    if (filter_var($host, FILTER_VALIDATE_IP)) {
        $ips[] = $host;
    } else {
        $records = @dns_get_record($host, DNS_A + DNS_AAAA);
        if (empty($records)) {
            return true;
        }
        foreach ($records as $record) {
            if (!empty($record['ip'])) {
                $ips[] = $record['ip'];
            } elseif (!empty($record['ipv6'])) {
                $ips[] = $record['ipv6'];
            }
        }
    }

    foreach ($ips as $ip) {
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return true;
        }
    }

    return false;
}

function tadtools_remote_image_url($url, $save_to, $img_url, $maxBytes)
{
    // ── 1. 嚴格白名單 scheme，明確拒絕 file:// dict:// gopher:// 等 ──
    //    先對 URL 做 decode，避免 %66%69%6c%65 繞過
    $decodedUrl = urldecode($url);
    $urlParts   = parse_url($decodedUrl);

    if (
        empty($urlParts['scheme']) ||
        empty($urlParts['host']) ||
        !in_array(strtolower($urlParts['scheme']), ['http', 'https'], true)
    ) {
        tadtools_upload_fail('Invalid image URL');
    }

    // ── 2. same-site 捷徑：只允許回傳站內已存在的 uploads 路徑，不可讀任意檔 ──
    if (tadtools_is_same_site_url($decodedUrl, XOOPS_URL)) {
        $path = (string) parse_url($decodedUrl, PHP_URL_PATH);

        // 只允許指向 /uploads/ 子目錄的站內圖片，防止讀取任意站內檔案
        $uploadsPath = (string) parse_url(XOOPS_URL . '/uploads/', PHP_URL_PATH);
        if (strpos($path, $uploadsPath) !== 0) {
            tadtools_upload_fail('Same-site URL must point to uploads directory');
        }

        // 確保路徑不含路徑穿越
        $realBase = realpath(XOOPS_ROOT_PATH . '/uploads');
        $realFile = realpath(XOOPS_ROOT_PATH . str_replace(
            (string) parse_url(XOOPS_URL, PHP_URL_PATH),
            '',
            $path
        ));
        if ($realBase === false || $realFile === false || strpos($realFile, $realBase) !== 0) {
            tadtools_upload_fail('Invalid same-site image path');
        }

        return [
            'filename' => basename($path),
            'url'      => $decodedUrl,
            'uploaded' => 1,
        ];
    }

    // ── 3. 私有網路 / localhost 封鎖（SSRF 防護） ──
    if (tadtools_is_private_host($urlParts['host'])) {
        tadtools_upload_fail('Local or private network images are not allowed');
    }

    if (!function_exists('curl_init')) {
        tadtools_upload_fail('cURL is not available');
    }

    $buffer = fopen('php://temp/maxmemory:' . $maxBytes, 'w+b');
    $ch     = curl_init($decodedUrl); // 使用 decoded URL
    curl_setopt_array($ch, [
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_RETURNTRANSFER => false,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_USERAGENT      => 'XOOPS Tadtools image fetcher',
        CURLOPT_WRITEFUNCTION  => function ($ch, $chunk) use ($buffer, $maxBytes) {
            static $downloaded = 0;
            $downloaded += strlen($chunk);
            if ($downloaded > $maxBytes) {
                return 0;
            }
            return fwrite($buffer, $chunk);
        },
    ]);

    // ── 4. cURL 層也明確只允許 HTTP/HTTPS protocol（縱深防禦） ──
    if (defined('CURLPROTO_HTTP') && defined('CURLPROTO_HTTPS')) {
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
        curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
    }

    $ok          = curl_exec($ch);
    $httpCode    = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    $contentType = (string) curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $error       = curl_error($ch);
    curl_close($ch);

    if ($ok === false || $httpCode < 200 || $httpCode >= 300) {
        fclose($buffer);
        tadtools_upload_fail($error ?: 'Remote image download failed');
    }

    rewind($buffer);
    $imageData = stream_get_contents($buffer);
    fclose($buffer);

    if ($imageData === false || $imageData === '') {
        tadtools_upload_fail('Remote image is empty');
    }

    $imageInfo = @getimagesizefromstring($imageData);
    if ($imageInfo === false || empty($imageInfo['mime']) || strpos($imageInfo['mime'], 'image/') !== 0) {
        tadtools_upload_fail('Remote file is not a valid image');
    }

    $mimeToExt = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    $mime = strtolower($imageInfo['mime']);
    if (!isset($mimeToExt[$mime])) {
        tadtools_upload_fail('Unsupported image type');
    }

    if ($contentType !== '' && stripos($contentType, 'image/') === false) {
        tadtools_upload_fail('Remote response is not an image');
    }

    $filename = date('YmdHis_') . Utility::randStr(6) . '.' . $mimeToExt[$mime];
    $filePath = $save_to . $filename;
    if (file_put_contents($filePath, $imageData, LOCK_EX) === false) {
        tadtools_upload_fail('Image save failed');
    }

    $result = Utility::generateThumbnail($filePath);
    if ($result !== true) {
        @unlink($filePath);
        tadtools_upload_fail($result);
    }

    chmod($filePath, 0644);

    return [
        'filename' => $filename,
        'url'      => $img_url . $filename,
        'uploaded' => 1,
    ];
}

$type_arr = ['image', 'file'];
$type     = Request::getString('type');
if (!in_array($type, $type_arr)) {
    die("不支援 {$type} 類型 ");
}
$mod_dir = tadtools_clean_path_segment(Request::getString('mod_dir'));
$subDir  = tadtools_clean_path_segment(Request::getString('subDir'), true);

if ($mod_dir === '') {
    tadtools_upload_fail('Invalid module directory');
}

$save_to = XOOPS_ROOT_PATH . "/uploads/{$mod_dir}/{$type}/";
$img_url = XOOPS_URL . "/uploads/{$mod_dir}/{$type}/";
Utility::mk_dir($save_to);
if (!empty($subDir)) {
    $save_to .= "{$subDir}/";
    $img_url .= "{$subDir}/";
    Utility::mk_dir($save_to);
}
$image_max_width  = $xoopsModuleConfig['image_max_width'] ? (int) $xoopsModuleConfig['image_max_width'] : 640;
$image_max_height = $xoopsModuleConfig['image_max_height'] ? (int) $xoopsModuleConfig['image_max_height'] : 640;

if (isset($_FILES['upload'])) {
    $foo = new \Verot\Upload\Upload($_FILES['upload'], 'zh_TW');
    if ($foo->uploaded) {
        $filename   = date('YmdHis_') . Utility::randStr(4);
        $path_parts = pathinfo($_FILES['upload']['name']);
        $extension  = strtolower($path_parts['extension'] ?? '');
        if ($extension === '') {
            tadtools_upload_fail('Missing file extension');
        }
        if ($type === 'image') {
            $foo->allowed = ['image/*'];
        }
        $foo->file_new_name_body = $filename;
        $foo->image_resize       = false;
        $foo->image_ratio        = true;
        $foo->image_x            = $image_max_width;
        $foo->image_y            = $image_max_height;

        // save uploaded image with no changes
        $foo->process($save_to);

        $data['filename'] = "{$filename}.$extension";
        $data['url']      = $img_url . $filename . '.' . $extension;

        if ($foo->processed) {
            chmod($save_to . $filename . '.' . $extension, 0644);
            $data['uploaded'] = 1;
        } else {
            $data['uploaded'] = 0;
        }
    }
} elseif (isset($_GET['url'])) {
    if ($type !== 'image') {
        tadtools_upload_fail('URL upload only supports images');
    }
    $image_url = Request::getString('url');
    $data      = tadtools_remote_image_url($image_url, $save_to, $img_url, 10 * 1024 * 1024);
}
Utility::dd($data);
