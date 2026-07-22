<?php
namespace XoopsModules\Tadtools;

use InvalidArgumentException;
use RuntimeException;

/**
 * PDF 轉圖片工具類別（主要使用 poppler-utils 的 pdftoppm）
 *
 * 使用範例:
 *   $files = PdfToImages::convert('/path/doc.pdf', '/path/output');
 *   $files = PdfToImages::convert('/path/doc.pdf', '/path/output', [
 *       'format'    => 'jpeg',
 *       'dpi'       => 200,
 *       'firstPage' => 1,
 *       'lastPage'  => 5,
 *       'prefix'    => 'page',
 *   ]);
 */
class PdfToImages
{
    /** pdftoppm 執行檔路徑（可依環境覆寫） */
    private static string $pdftoppmBin = 'pdftoppm';

    /** pdfinfo 執行檔路徑（用來取頁數） */
    private static string $pdfinfoBin = 'pdfinfo';

    /** 預設選項 */
    private const DEFAULTS = [
        'format'      => 'png', // png | jpeg | tiff
        'dpi'         => 150,
        'firstPage'   => null, // null = 從第一頁
        'lastPage'    => null, // null = 到最後一頁
        'prefix'      => 'page',
        'jpegQuality' => 90, // 僅 format=jpeg 時生效
    ];

    /** 禁止實例化 */
    private function __construct()
    {}

    // ---------------------------------------------------------
    // 公開 API
    // ---------------------------------------------------------

    /**
     * 將 PDF 轉成圖片
     *
     * @param  string $pdfPath   PDF 來源路徑
     * @param  string $outputDir 輸出目錄（不存在會自動建立）
     * @param  array  $options   選項，見 DEFAULTS
     * @return string[]          產生的圖片檔案路徑（已排序）
     * @throws RuntimeException
     */
    public static function convert(string $pdfPath, string $outputDir, array $options = []): array
    {
        $opt = array_merge(self::DEFAULTS, $options);

        self::assertAvailable();
        self::assertReadable($pdfPath);
        self::ensureDir($outputDir);

        $formatFlag   = self::formatFlag($opt['format']);
        $outputPrefix = rtrim($outputDir, '/') . '/' . $opt['prefix'];

        $cmd = [
            self::$pdftoppmBin,
            $formatFlag,
            '-r', (string) (int) $opt['dpi'],
        ];

        if ($opt['firstPage'] !== null) {
            $cmd[] = '-f';
            $cmd[] = (string) (int) $opt['firstPage'];
        }
        if ($opt['lastPage'] !== null) {
            $cmd[] = '-l';
            $cmd[] = (string) (int) $opt['lastPage'];
        }
        if ($opt['format'] === 'jpeg') {
            $cmd[] = '-jpegopt';
            $cmd[] = 'quality=' . (int) $opt['jpegQuality'];
        }

        $cmd[] = $pdfPath;
        $cmd[] = $outputPrefix;

        self::run($cmd);

        return self::collectOutput($outputDir, $opt['prefix'], $opt['format']);
    }

    /**
     * 只轉單一頁（常用於產生封面縮圖）
     */
    public static function convertPage(string $pdfPath, string $outputDir, int $page, array $options = []): ?string
    {
        $files = self::convert($pdfPath, $outputDir, array_merge($options, [
            'firstPage' => $page,
            'lastPage'  => $page,
        ]));

        return $files[0] ?? null;
    }

    /**
     * 取得 PDF 總頁數（透過 pdfinfo）
     */
    public static function getPageCount(string $pdfPath): int
    {
        self::assertReadable($pdfPath);

        $output = self::run([self::$pdfinfoBin, $pdfPath]);

        if (preg_match('/^Pages:\s+(\d+)/m', $output, $m)) {
            return (int) $m[1];
        }

        throw new RuntimeException("無法從 pdfinfo 輸出解析頁數: {$pdfPath}");
    }

    /**
     * 檢查 pdftoppm 是否可用
     */
    public static function isAvailable(): bool
    {
        $which = stripos(PHP_OS_FAMILY, 'Windows') === 0 ? 'where' : 'which';
        exec($which . ' ' . escapeshellarg(self::$pdftoppmBin) . ' 2>/dev/null', $out, $code);
        return $code === 0;
    }

    /**
     * 自訂執行檔路徑（例如 /usr/local/bin/pdftoppm）
     */
    public static function setBinaryPath(string $pdftoppm, ?string $pdfinfo = null): void
    {
        self::$pdftoppmBin = $pdftoppm;
        if ($pdfinfo !== null) {
            self::$pdfinfoBin = $pdfinfo;
        }
    }

    // ---------------------------------------------------------
    // 內部工具
    // ---------------------------------------------------------

    private static function formatFlag(string $format): string
    {
        return match ($format) {
            'png'   => '-png',
            'jpeg', 'jpg' => '-jpeg',
            'tiff'  => '-tiff',
            default => throw new InvalidArgumentException("不支援的格式: {$format}"),
        };
    }

    private static function assertAvailable(): void
    {
        if (!self::isAvailable()) {
            throw new RuntimeException(
                'pdftoppm 不存在，請安裝 poppler-utils（apt install poppler-utils / brew install poppler）'
            );
        }
    }

    private static function assertReadable(string $path): void
    {
        if (!is_readable($path)) {
            throw new RuntimeException("無法讀取檔案: {$path}");
        }
    }

    private static function ensureDir(string $dir): void
    {
        if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
            throw new RuntimeException("無法建立輸出目錄: {$dir}");
        }
    }

    /**
     * 安全執行外部指令（陣列形式逐一 escape，避免注入）
     */
    private static function run(array $cmd): string
    {
        $escaped = implode(' ', array_map('escapeshellarg', $cmd));

        $proc = proc_open($escaped, [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ], $pipes);

        if (!is_resource($proc)) {
            throw new RuntimeException("無法啟動程序: {$escaped}");
        }

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        $exitCode = proc_close($proc);

        if ($exitCode !== 0) {
            throw new RuntimeException("pdftoppm 執行失敗 (code {$exitCode}): {$stderr}");
        }

        return $stdout;
    }

    /**
     * 收集輸出檔案並依頁碼排序
     */
    private static function collectOutput(string $dir, string $prefix, string $format): array
    {
        $ext   = $format === 'jpeg' ? 'jpg' : $format;
        $files = glob(rtrim($dir, '/') . "/{$prefix}-*.{$ext}") ?: [];

        natsort($files); // pdftoppm 會自動補零，natsort 保險處理頁碼順序
        return array_values($files);
    }
    /**
     * 轉檔後產生 manifest.json
     */
    public static function writeManifest(string $outputDir, array $imageFiles, string $pdfPath): string
    {
        $manifest = [
            'version'   => 1,
            'source'    => basename($pdfPath),
            'pageCount' => count($imageFiles),
            'generated' => date('c'),
            // 只存檔名，URL 由前端組
            'pages'     => array_map('basename', $imageFiles),
        ];

        $path = rtrim($outputDir, '/') . '/manifest.json';
        file_put_contents($path, json_encode($manifest, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        return $path;
    }

}
