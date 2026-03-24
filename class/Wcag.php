<?php

namespace XoopsModules\Tadtools;

/**
 * WCAG 無障礙自動修正工具
 *
 * 依據 WCAG 2.1 標準，自動修正 HTML 內容中常見的無障礙問題。
 *
 * @package XoopsModules\Tadtools
 */
class Wcag
{
    // -------------------------------------------------------------------------
    // 初始化旗標，避免重複建立設定
    // -------------------------------------------------------------------------
    private static bool $initialized = false;

    private static array $checkItems  = [];
    private static array $checkTitles = [];
    private static array $rules       = [];

    /**
     * 已知安全的 handler 白名單，對應 $rules 中的 func 鍵。
     * 避免動態字串呼叫任意方法（安全漏洞修正）。
     * 注意：不可在屬性預設值使用 self::class（非編譯期常數），改在 init() 中建立。
     */
    private static array $handlerMap = [];

    // -------------------------------------------------------------------------
    // 語系設定
    // -------------------------------------------------------------------------

    /**
     * 當 <blockquote> 缺少 xml:lang 時，預設填入的語言代碼
     */
    private static string $defaultLang = 'zh-TW';

    /**
     * 空連結補充文字的語言
     */
    private static string $emptyAnchorLabel = '連至';

    // -------------------------------------------------------------------------
    // 公開 API
    // -------------------------------------------------------------------------

    /**
     * 取得內部設定陣列
     *
     * @param  string $var 'checkItems' | 'checkTitles' | 'rules'
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function getVar(string $var): array
    {
        self::init();

        return match ($var) {
            'checkItems'  => self::$checkItems,
            'checkTitles' => self::$checkTitles,
            'rules'       => self::$rules,
            default       => throw new \InvalidArgumentException("未知的變數名稱：{$var}"),
        };
    }

    /**
     * 對 HTML 內容執行全部無障礙自動修正，並回傳修正後的字串
     *
     * @param  string $content 原始 HTML
     * @return string          修正後的 HTML
     */
    public static function amend(?string $content): string
    {
        if (is_null($content) || empty($content)) {
            return '';
        }

        self::init();

        foreach (self::$rules as $kindRules) {
            foreach ($kindRules as $funcKey => $pattern) {
                // 確認 handler 存在於白名單
                if (!isset(self::$handlerMap[$funcKey])) {
                    continue;
                }

                $matches = [];
                $result  = preg_match_all($pattern, $content, $matches);

                // preg_match_all 失敗（pattern 有誤）或完全無比對結果時跳過
                if ($result === false || empty($matches[0])) {
                    continue;
                }

                // 確保正確使用回調
                $handler = self::$handlerMap[$funcKey];
                if (is_array($handler) && count($handler) == 2 && is_callable($handler)) {
                    $content = call_user_func($handler, $content, $matches);
                } else {
                    // 直接使用類別和方法名稱
                    $className  = $handler[0];
                    $methodName = $handler[1];
                    $content    = $className::$methodName($content, $matches);
                }
            }
        }

        return $content;
    }

    // -------------------------------------------------------------------------
    // 私有初始化
    // -------------------------------------------------------------------------

    /**
     * 只初始化一次，避免每次 getVar() 都重建陣列
     */
    private static function init(): void
    {
        if (self::$initialized) {
            return;
        }

        // handler 白名單在此初始化，避免 self::class 用於屬性預設值的限制
        self::$handlerMap = [
            'fontsize'         => [self::class, 'fixFontsize'],
            'font_size_adjust' => [self::class, 'fixFontSizeAdjust'],
            'size'             => [self::class, 'fixSize'],
            'iframe'           => [self::class, 'fixIframe'],
            'object'           => [self::class, 'fixObject'],
            'applet'           => [self::class, 'fixApplet'],
            'embed'            => [self::class, 'fixEmbed'],
            'input'            => [self::class, 'fixInput'],
            'select'           => [self::class, 'fixSelect'],
            'textarea'         => [self::class, 'fixTextarea'],
            'img'              => [self::class, 'fixImg'],
            'blockquote'       => [self::class, 'fixBlockquote'],
            'empty_font'       => [self::class, 'fixEmptyFont'],
            'font'             => [self::class, 'fixFont'],
            'center'           => [self::class, 'fixCenter'],
            'big'              => [self::class, 'fixBig'],
            'a_empty'          => [self::class, 'fixAEmpty'],
            'same_alt'         => [self::class, 'fixSameAlt'],
            'head_empty'       => [self::class, 'fixHeadEmpty'],
            'lang_zh_tw'       => [self::class, 'fixLangZhTw'],
            'h1_to_p'          => [self::class, 'fixH1'],
        ];

        // --- CSS font-size 單位轉換 ---
        self::$checkItems['fontsize']  = ['font-size:'];
        self::$checkTitles['fontsize'] = TADTOOLS_CHK_FONTSIZE;
        self::$rules['fontsize']       = [
            'fontsize' => "/font-size:\s*([+-]?\d+|\d*\.\d+)(px|pt|)\s*;/Ui",
        ];

        // --- 移除 font-size-adjust（瀏覽器支援度極低，實質無效） ---
        self::$checkItems['no_need']  = ['font-size-adjust:'];
        self::$checkTitles['no_need'] = TADTOOLS_CHK_NO_NEED;
        self::$rules['no_need']       = [
            'font_size_adjust' => "/font-size-adjust:.*?;/Uim",
        ];

        // --- font shorthand 中的 px/pt 大小 ---
        self::$checkItems['size']  = ['font:'];
        self::$checkTitles['size'] = TADTOOLS_CHK_FONTSIZE2;
        self::$rules['size']       = [
            'size' => "/font:\s*(\d+|\d*\.\d+)(px|pt)/Ui",
        ];

        // --- 需要 title 屬性的嵌入元素 ---
        self::$checkItems['need_title']  = ['<iframe ', '<object ', '<applet ', '<embed ', '<input ', '<select ', '<textarea '];
        self::$checkTitles['need_title'] = TADTOOLS_CHK_NEED_TITLE;
        self::$rules['need_title']       = [
            'iframe'   => "/<iframe\b[^>]*>.*?<\/iframe>/ims",
            'object'   => "/<object\b[^>]*>.*?<\/object>/ims",
            'applet'   => "/<applet\b[^>]*>.*?<\/applet>/ims",
            'embed'    => "/<embed\b[^>]*>.*?<\/embed>/ims",
            'input'    => "/<input\b[^>]*>/im",
            'select'   => "/<select\b[^>]*>/im",
            'textarea' => "/<textarea\b[^>]*>/im",
        ];

        // --- img alt ---
        self::$checkItems['img']  = ['<img '];
        self::$checkTitles['img'] = TADTOOLS_CHK_IMG;
        self::$rules['img']       = [
            'img' => "/<img\b([^>]*)\/?\s*>/i",
        ];

        // --- blockquote lang ---
        self::$checkItems['blockquote']  = ['<blockquote'];
        self::$checkTitles['blockquote'] = TADTOOLS_CHK_BLOCKQUOTE;
        self::$rules['blockquote']       = [
            'blockquote' => "/<blockquote\b[^>]*>.*?<\/blockquote>/Uis",
        ];

        // --- 已廢棄的表現標籤 ---
        self::$checkItems['unable_tag']  = ['<font', '<center>', '<big>'];
        self::$checkTitles['unable_tag'] = TADTOOLS_CHK_UNABLE_TAG;
        self::$rules['unable_tag']       = [
            'empty_font' => "/(<font\b[^>]*><\/font>)/im",
            'font'       => "/(<font\b[^>]*>)|(<\/font>)/im",
            'center'     => "/<center>/Ui",
            'big'        => "/<big>/Ui",
        ];

        // --- 空連結 & alt 與連結文字重複 ---
        self::$checkItems['a_empty']  = ['<a '];
        self::$checkTitles['a_empty'] = TADTOOLS_CHK_A_EMPTY;
        self::$rules['a_empty']       = [
            'a_empty'  => "/<a\b([^>]*)>(.*?)<\/a>/Uis",
            'same_alt' => "/<a\b[^>]*>(.*?)<\/a>/Uis",
        ];

        // --- 空標題 ---
        self::$checkItems['head_empty']  = ['<h'];
        self::$checkTitles['head_empty'] = TADTOOLS_CHK_HEAD_EMPTY;
        self::$rules['head_empty']       = [
            'head_empty' => "/<(h[1-6])\b[^>]*>(.*?)<\/h[1-6]>/Ui",
        ];

                                                             // --- 移除多餘的 lang="zh-TW"（應交由 <html lang> 處理） ---
                                                             // 注意：此處只移除「重複標注在子元素」的情況，不影響 <html> 本身
                                                             // 修正：避免單引號導致 SQL 查詢語法錯誤
        self::$checkItems['lang_zh_tw']  = ['lang="zh-TW"']; // 移除單引號版本，只保留雙引號版本
        self::$checkTitles['lang_zh_tw'] = TADTOOLS_CHK_LANG_ZH_TW;
        self::$rules['lang_zh_tw']       = [
            'lang_zh_tw' => "/ lang=[\"']zh-TW[\"']/im",
        ];

        // --- 將 <h1> 轉換為 <p class="h1">（避免文章內容破壞頁面標題階層） ---
        // 頁面通常已有一個 <h1>（網站名稱或頁面主標），
        // 文章內若再出現 <h1> 將造成標題階層混亂，改以視覺等效的 <p class="h1"> 替代。
        self::$checkItems['h1_to_p']  = ['<h1'];
        self::$checkTitles['h1_to_p'] = TADTOOLS_CHK_H1_TO_P;
        self::$rules['h1_to_p']       = [
            'h1_to_p' => "/<h1(\b[^>]*)>(.*?)<\/h1>/Uis",
        ];

        self::$initialized = true;
    }

    // -------------------------------------------------------------------------
    // 修正函式（Handler methods）
    // 命名由舊的 fontsize() 改為 fixFontsize()，清楚表示用途
    // -------------------------------------------------------------------------

    /**
     * 將 font-size 的 px / pt / 無單位 值轉換為 rem
     */
    public static function fixFontsize(string $v, array $matches): string
    {
        foreach ($matches[0] as $sk => $s) {
            $value = (float) $matches[1][$sk];
            $unit  = strtolower($matches[2][$sk]);

            $new_val = match ($unit) {
                'pt'    => round($value / 12, 2),
                'px'    => round($value / 16, 2),
                default => self::convertFontNumber($matches[1][$sk]),
            };

            $v = str_ireplace($s, "font-size: {$new_val}rem;", $v);
        }

        return $v;
    }

    /**
     * 移除 font-size-adjust 屬性（無瀏覽器支援）
     */
    public static function fixFontSizeAdjust(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_str) {
            $v = str_ireplace($old_str, '', $v);
        }

        return $v;
    }

    /**
     * 將 font shorthand 中的 px/pt 大小轉換為 rem
     */
    public static function fixSize(string $v, array $matches): string
    {
        foreach ($matches[0] as $sk => $s) {
            $value = (float) $matches[1][$sk];
            $unit  = strtolower($matches[2][$sk]);

            $new_val = match ($unit) {
                'pt'    => round($value / 12, 2),
                'px'    => round($value / 16, 2),
                default => 1.0,
            };

            $v = str_ireplace($s, "font: {$new_val}rem", $v);
        }

        return $v;
    }

    /**
     * 為缺少 title 的 <iframe> 補上 title 屬性
     */
    public static function fixIframe(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_str) {
            if (stripos($old_str, ' title=') === false) {
                $new_str = str_ireplace('<iframe ', '<iframe title="iframe" ', $old_str);
                $v       = str_ireplace($old_str, $new_str, $v);
            }
        }

        return $v;
    }

    /**
     * 為缺少 title 的 <object> 補上 title 屬性與後備文字
     */
    public static function fixObject(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_str) {
            $new_str = $old_str;

            if (stripos($old_str, ' title=') === false) {
                $new_str = str_ireplace('<object ', '<object title="object" ', $new_str);
            }

            // 補上 visually-hidden 後備文字（若尚未存在）
            if (stripos($new_str, 'visually-hidden') === false) {
                $new_str = str_ireplace('</object>', '<span class="sr-only visually-hidden">some object</span></object>', $new_str);
            }

            $v = str_ireplace($old_str, $new_str, $v);
        }

        return $v;
    }

    /**
     * 為缺少 title 的 <applet> 補上 title 屬性與後備文字
     */
    public static function fixApplet(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_str) {
            $new_str = $old_str;

            if (stripos($old_str, ' title=') === false) {
                $new_str = str_ireplace('<applet ', '<applet title="applet" ', $new_str);
            }

            if (stripos($new_str, 'visually-hidden') === false) {
                $new_str = str_ireplace('</applet>', '<span class="sr-only visually-hidden">some applet</span></applet>', $new_str);
            }

            $v = str_ireplace($old_str, $new_str, $v);
        }

        return $v;
    }

    /**
     * 為缺少 title 的 <embed> 補上 title 屬性、後備文字及 <noembed>
     */
    public static function fixEmbed(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_str) {
            $new_str = $old_str;

            if (stripos($old_str, ' title=') === false) {
                $new_str = str_ireplace('<embed ', '<embed title="embed" ', $new_str);
            }

            if (stripos($new_str, 'visually-hidden') === false) {
                $new_str = str_ireplace('</embed>', '<span class="sr-only visually-hidden">some embed</span></embed>', $new_str);
            }

            if (stripos($new_str, '<noembed') === false) {
                $new_str = str_ireplace('</embed>', '<noembed>No way to embed content</noembed></embed>', $new_str);
            }

            $v = str_ireplace($old_str, $new_str, $v);
        }

        return $v;
    }

    /**
     * 為缺少 title 的 <input> 補上 title 屬性
     */
    public static function fixInput(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_str) {
            if (stripos($old_str, ' title=') === false) {
                $new_str = str_ireplace('<input ', '<input title="input" ', $old_str);
                $v       = str_ireplace($old_str, $new_str, $v);
            }
        }

        return $v;
    }

    /**
     * 為缺少 title 的 <select> 補上 title 屬性
     */
    public static function fixSelect(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_str) {
            if (stripos($old_str, ' title=') === false) {
                $new_str = str_ireplace('<select ', '<select title="select" ', $old_str);
                $v       = str_ireplace($old_str, $new_str, $v);
            }
        }

        return $v;
    }

    /**
     * 為缺少 title 的 <textarea> 補上 title 屬性
     */
    public static function fixTextarea(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_str) {
            if (stripos($old_str, ' title=') === false) {
                $new_str = str_ireplace('<textarea ', '<textarea title="textarea" ', $old_str);
                $v       = str_ireplace($old_str, $new_str, $v);
            }
        }

        return $v;
    }

    /**
     * 為缺少 alt 或 alt 為純空白的 <img> 補上 alt=""
     * 並移除與 alt 相同或極度相似的 title 屬性（避免重複朗讀）
     * 若 alt 為空但 title 有值，則將 title 值複製到 alt
     *
     * 注意：裝飾性圖片的 alt="" 是正確的 WCAG 做法，
     * 此處保留空字串，不做額外猜測。
     */
    public static function fixImg(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_img) {
            // 過濾樣板引擎佔位符（如 Smarty、XOOPS token）
            if (self::isTemplateToken($old_img)) {
                continue;
            }

            $old_img_normalized = str_ireplace(["\r\n", "\n", "\r"], ' ', $old_img);
            $new_img            = $old_img_normalized;

            // 0. 檢查是否有 title 但無 alt 值的情況，將 title 複製到 alt
            $has_alt   = (stripos($new_img, 'alt=') !== false);
            $alt_empty = false;

            if ($has_alt) {
                preg_match('/alt=(["\'])(.*?)\1/i', $new_img, $alt_match);
                $alt_empty = (isset($alt_match[2]) && trim($alt_match[2]) === '');
            }

            if ((!$has_alt || $alt_empty) && stripos($new_img, 'title=') !== false) {
                preg_match('/title=(["\'])(.*?)\1/i', $new_img, $title_match);
                if (isset($title_match[2]) && trim($title_match[2]) !== '') {
                    // 如果 title 有值但 alt 為空或不存在，則複製 title 到 alt
                    $title_value = htmlspecialchars($title_match[2], ENT_QUOTES);
                    if (!$has_alt) {
                        // alt 不存在，添加新的 alt
                        $new_img = str_ireplace('<img ', '<img alt="' . $title_value . '" ', $new_img);
                    } else {
                        // alt 存在但為空，用 title 替換它
                        $new_img = preg_replace('/alt=(["\']).*?\1/i', 'alt="' . $title_value . '"', $new_img);
                    }
                    $has_alt   = true;
                    $alt_empty = false;
                }
            }

            // 1. 處理缺少 alt 的情況（如果前面沒有從 title 複製）
            if (!$has_alt) {
                // 完全缺少 alt
                $new_img = str_ireplace('<img ', '<img alt="" ', $new_img);
            } else if ($alt_empty) {
                // alt 存在但值為空白（前面未處理過）
                $new_img = preg_replace('/alt=(["\']).*?\1/i', 'alt=""', $new_img);
            }

            // 2. 檢查同時存在 alt 與 title，且值相同或相似時移除 title
            if (stripos($new_img, 'alt=') !== false && stripos($new_img, 'title=') !== false) {
                preg_match('/alt=(["\'])(.*?)\1/i', $new_img, $alt_match);
                preg_match('/title=(["\'])(.*?)\1/i', $new_img, $title_match);

                if (!empty($alt_match[2]) && !empty($title_match[2])) {
                    $alt   = trim(html_entity_decode($alt_match[2], ENT_QUOTES));
                    $title = trim(html_entity_decode($title_match[2], ENT_QUOTES));

                    // 完全相同或極度相似（忽略大小寫、前後空白）
                    if (strcasecmp($alt, $title) === 0 ||
                        // 如果移除所有標點符號和空白後相同
                        preg_replace('/[\s\p{P}]+/u', '', strtolower($alt)) ===
                        preg_replace('/[\s\p{P}]+/u', '', strtolower($title))) {

                        $new_img = preg_replace('/\s+title=(["\']).*?\1/i', '', $new_img);
                    }
                }
            }

            if ($new_img !== $old_img) {
                $v = str_ireplace($old_img, $new_img, $v);
            }
        }

        return $v;
    }

    /**
     * 為缺少 xml:lang 的 <blockquote> 補上語言屬性
     */
    public static function fixBlockquote(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_str) {
            if (stripos($old_str, ' xml:lang') === false) {
                $new_str = str_ireplace(
                    '<blockquote',
                    '<blockquote xml:lang="' . self::$defaultLang . '"',
                    $old_str
                );
                $v = str_ireplace($old_str, $new_str, $v);
            }
        }

        return $v;
    }

    /**
     * 移除空的 <font></font>
     */
    public static function fixEmptyFont(string $v, array $matches): string
    {
        foreach ($matches[0] as $empty_str) {
            $v = str_ireplace($empty_str, '', $v);
        }

        return $v;
    }

    /**
     * 將 <font> 標籤轉換為具有等效 style 的 <span>
     */
    public static function fixFont(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_str) {
            // 統一引號為雙引號
            $new_str = str_replace("'", '"', $old_str);

            if (stripos($new_str, '<font ') !== false) {
                $styles = [];

                if (preg_match('/face="([^"]*)"/i', $new_str, $face)) {
                    $styles[] = 'font-family: ' . htmlspecialchars($face[1], ENT_QUOTES) . ';';
                }

                if (preg_match('/color="([^"]*)"/i', $new_str, $color)) {
                    $styles[] = 'color: ' . htmlspecialchars($color[1], ENT_QUOTES) . ';';
                }

                if (preg_match('/size="([^"]*)"/i', $new_str, $size)) {
                    $new_size = self::convertFontNumber($size[1]);
                    $styles[] = "font-size: {$new_size}rem;";
                }

                $styleAttr = !empty($styles) ? ' style="' . implode(' ', $styles) . '"' : '';
                $new_str   = "<span{$styleAttr}>";

            } elseif (strtolower(trim($new_str)) === '<font>') {
                $new_str = '<span>';
            } else {
                $new_str = '</span>';
            }

            $v = str_ireplace($old_str, $new_str, $v);
        }

        return $v;
    }

    /**
     * 將 <center> 轉換為具有 text-align 的 <div>
     */
    public static function fixCenter(string $v, array $matches): string
    {
        $v = str_ireplace('<center>', '<div style="text-align: center;">', $v);
        $v = str_ireplace('</center>', '</div>', $v);

        return $v;
    }

    /**
     * 將 <big> 轉換為具有放大字型的 <span>
     */
    public static function fixBig(string $v, array $matches): string
    {
        $v = str_ireplace('<big>', '<span style="font-size: 1.2rem;">', $v);
        $v = str_ireplace('</big>', '</span>', $v);

        return $v;
    }

    /**
     * 為空連結（href 存在但內容為空）補上 visually-hidden 說明文字
     */
    public static function fixAEmpty(string $v, array $matches): string
    {
        foreach ($matches[2] as $key => $contentInTag) {
            // 跳過樣板引擎佔位符
            if (self::isTemplateToken($contentInTag)) {
                continue;
            }

            $hasHref      = stripos($matches[1][$key], 'href') !== false;
            $isEmptyInner = empty(trim(strip_tags($contentInTag)));

            if (!$hasHref || !$isEmptyInner) {
                continue;
            }

            // 從 href 值提取連結目標做為輔助說明
            preg_match('/href=["\']([^"\']*)["\']/', $matches[1][$key], $hrefMatch);
            $linkTo = htmlspecialchars($hrefMatch[1] ?? '', ENT_QUOTES);
            $label  = self::$emptyAnchorLabel . ' ' . $linkTo;

            $old = $matches[0][$key];
            $new = str_ireplace(
                '</a>',
                '<span class="sr-only visually-hidden">' . $label . '</span></a>',
                $old
            );
            $v = str_ireplace($old, $new, $v);
        }

        return $v;
    }

    /**
     * 當圖片的 alt 文字與周圍連結文字完全相同時，
     * 加上 "image of " 前綴以區別，避免重複朗讀
     */
    public static function fixSameAlt(string $v, array $matches): string
    {
        foreach ($matches[1] as $key => $contentInTag) {
            if (self::isTemplateToken($contentInTag)) {
                continue;
            }

            preg_match('/(.*?)<img\b[^>]*alt=(["\'])(.*?)\2[^>]*>(.*)/is', $contentInTag, $match);

            if (empty($match)) {
                continue;
            }

            $alt  = strip_tags(str_ireplace('&nbsp;', '', $match[3]));
            $txt1 = strip_tags(str_ireplace('&nbsp;', '', $match[1]));
            $txt2 = strip_tags(str_ireplace('&nbsp;', '', $match[4]));

            if (empty($alt)) {
                continue;
            }

            if ($alt === trim($txt1) || $alt === trim($txt2)) {
                $old = $matches[0][$key];
                $new = preg_replace(
                    '/alt=(["\'])' . preg_quote($alt, '/') . '\1/',
                    'alt="image of ' . htmlspecialchars($alt, ENT_QUOTES) . '"',
                    $old
                );
                $v = str_ireplace($old, $new, $v);
            }
        }

        return $v;
    }

    /**
     * 為空的 heading 標籤（h1~h6）補上 visually-hidden 提示文字
     */
    public static function fixHeadEmpty(string $v, array $matches): string
    {
        // $matches[1] = 標籤名稱（h1~h6），$matches[2] = 標籤內容
        foreach ($matches[2] as $key => $contentInTag) {
            if (self::isTemplateToken($contentInTag)) {
                continue;
            }

            if (!empty(trim(strip_tags($contentInTag)))) {
                continue;
            }

            $old = $matches[0][$key];
            $tag = $matches[1][$key]; // e.g. "h2"
            $new = str_ireplace(
                "</{$tag}>",
                '<span class="sr-only visually-hidden">empty heading</span></' . $tag . '>',
                $old
            );
            $v = str_ireplace($old, $new, $v);
        }

        return $v;
    }

    /**
     * 移除子元素上重複標注的 lang="zh-TW"
     *
     * 說明：當 <html lang="zh-TW"> 已正確設定時，
     * 子元素上的 lang="zh-TW" 為冗餘屬性，可安全移除。
     * 但若子元素刻意標注不同語言（如夾雜英文段落），
     * 請在呼叫前先過濾，不應由此方法處理。
     */
    public static function fixLangZhTw(string $v, array $matches): string
    {
        foreach ($matches[0] as $old_str) {
            $v = str_ireplace($old_str, '', $v);
        }

        return $v;
    }

    /**
     * 將文章內的 <h1> 轉換為 <p class="h1">，</h1> 轉換為 </p>
     *
     * 說明：每個頁面應只有一個 <h1>（通常由佈景主題或系統輸出為網站/頁面主標），
     * 文章編輯器中出現的 <h1> 會破壞頁面標題階層（WCAG 1.3.1），
     * 因此轉換為外觀相同但語意正確的 <p class="h1">。
     *
     * 若原本 <h1> 已有其他 class，例如 <h1 class="title">，
     * 轉換後會合併為 <p class="h1 title">。
     */
    public static function fixH1(string $v, array $matches): string
    {
        foreach ($matches[0] as $key => $old_str) {
            if (self::isTemplateToken($old_str)) {
                continue;
            }

            $attrs = $matches[1][$key]; // <h1 之後、> 之前的所有屬性

            // 將既有的 class 屬性合併加入 h1，其餘屬性保留
            if (preg_match('/class=(["\'])([^"\']*)\1/i', $attrs, $classMatch)) {
                $existingClasses = trim($classMatch[2]);
                $newClass        = 'h1' . ($existingClasses !== '' ? ' ' . $existingClasses : '');
                $newAttrs        = preg_replace(
                    '/class=(["\'])[^"\']*\1/i',
                    'class="' . htmlspecialchars($newClass, ENT_QUOTES) . '"',
                    $attrs
                );
            } else {
                // 原本沒有 class，直接補上
                $newAttrs = ' class="h1"' . $attrs;
            }

            $new_str = '<p' . $newAttrs . '>' . $matches[2][$key] . '</p>';
            $v       = str_replace($old_str, $new_str, $v);
        }

        return $v;
    }

    // -------------------------------------------------------------------------
    // 私有輔助方法
    // -------------------------------------------------------------------------

    /**
     * 將 <font size="..."> 的數字值（含 +/- 符號）轉換為 rem 倍率
     *
     * HTML font size 1~7 對應規則：
     *   基準 = 3，每差 1 個單位 = 0.2rem
     *   +N / -N 表示相對偏移
     */
    private static function convertFontNumber(string | int | float $raw): float
    {
        $raw = (string) $raw;

        if (str_contains($raw, '+')) {
            $num = (float) ltrim($raw, '+');
            return round(1 + 0.2 * $num, 2);
        }

        if (str_contains($raw, '-')) {
            $num = (float) ltrim($raw, '-');
            return round(max(0.1, 1 - 0.2 * $num), 2); // 不低於 0.1rem
        }

        $num = (float) $raw - 3;
        return round(1 + 0.2 * $num, 2);
    }

    /**
     * 判斷字串是否包含樣板引擎佔位符（Smarty、XOOPS token 等），
     * 若是則跳過修正以避免破壞樣板語法
     *
     * @param  string $str 待檢查字串
     * @return bool
     */
    private static function isTemplateToken(string $str): bool
    {
        // Smarty: {$var}、{block}、{if}…
        // XOOPS token: {X_...}
        return (bool) preg_match('/\{[\$#%a-zA-Z_\/]/', $str);
    }
}

/*
使用範例：

use XoopsModules\Tadtools\Wcag;

// 取得設定（可用於前端顯示檢查項目清單）
$checkItems  = Wcag::getVar('checkItems');
$checkTitles = Wcag::getVar('checkTitles');
$rules       = Wcag::getVar('rules');

// 執行自動修正
$content = Wcag::amend($content);
 */
