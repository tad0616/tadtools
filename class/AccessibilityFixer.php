<?php
declare (strict_types = 1);

namespace XoopsModules\Tadtools;

// 明確引入所有用到的 PHP 內建類別
use DOMDocument;
use DOMElement;
use DOMNode;
use DOMNodeList;
use DOMXPath;
use InvalidArgumentException;

/**
 * ============================================================
 *  AccessibilityFixer — WCAG 2.1 AAA 無障礙內容自動修正類別
 * ============================================================
 *
 * 針對 WYSIWYG 所見即所得編輯器輸出的 HTML 片段，
 * 依據 WCAG 2.1 規範（涵蓋 A / AA / AAA）進行自動化修正。
 *
 * @author     Your Team
 * @version    1.0.0
 * @license    MIT
 * @requires   PHP 7.3+、ext-dom、ext-mbstring
 *
 * ──────────────────────────────────────────────────────────
 *  涵蓋規範
 * ──────────────────────────────────────────────────────────
 *  [1.1.1  A  ] 圖片補全 alt；裝飾圖加 role="presentation"；圖片加 class="img-fluid"
 *  [1.3.1  A  ] <b>→<strong>、<i>→<em>；表格 scope / aria-label
 *  [1.4.4  AA ] CSS 絕對單位（px/pt…）→ 相對單位（rem）
 *  [2.4.4  AA ] 連結文字=URL → 移除超連結；另開視窗加 title；連結目的地為檔案時 title 加上 (xxx格式)
 *  [2.4.9  AAA] 含糊連結文字加 aria-label 警示
 *  [3.1.4  AAA] <abbr> 補全 title 屬性
 *  [安全性    ] target="_blank" 補上 rel="noopener noreferrer"
 * ──────────────────────────────────────────────────────────
 */
class AccessibilityFixer
{
                                                         // ──────────────────────────────────────────────────────────
                                                         //  規則識別碼常數（用於 enable/disable 及 log 標記）
                                                         // ──────────────────────────────────────────────────────────
    public const RULE_LINKS         = 'links';           // WCAG 2.4.4
    public const RULE_AMBIGUOUS     = 'ambiguous_links'; // WCAG 2.4.9
    public const RULE_IMAGES        = 'images';          // WCAG 1.1.1
    public const RULE_TABLES        = 'tables';          // WCAG 1.3.1
    public const RULE_SEMANTIC      = 'semantic_html';   // WCAG 1.3.1
    public const RULE_ABBR          = 'abbr';            // WCAG 3.1.4
    public const RULE_CSS_INLINE    = 'css_inline';      // WCAG 1.4.4
    public const RULE_CSS_STYLE_TAG = 'css_style_tag';   // WCAG 1.4.4

    // ──────────────────────────────────────────────────────────
    //  預設設定
    // ──────────────────────────────────────────────────────────

    /** @var array  各規則開關（true = 啟用）*/
    private $rules = [
        self::RULE_LINKS         => true,
        self::RULE_AMBIGUOUS     => true,
        self::RULE_IMAGES        => true,
        self::RULE_TABLES        => true,
        self::RULE_SEMANTIC      => true,
        self::RULE_ABBR          => true,
        self::RULE_CSS_INLINE    => true,
        self::RULE_CSS_STYLE_TAG => true,
    ];

    /** @var int  rem 換算基準（預設瀏覽器 16px = 1rem）*/
    private $baseFontSizePx = 16;

    /** @var string  另開新視窗的提示文字 */
    private $newWindowLabel = '另開新視窗';

    /** @var array  含糊連結文字清單（中英文）*/
    private $ambiguousLinkTexts = [
        // 中文
        '點此', '按此', '點我', '這裡', '此處', '點擊', '按這裡',
        '更多', '更多資訊', '詳細', '了解更多', '查看更多', '繼續閱讀', '閱讀更多',
        '連結', '下載', '前往',
        // English
        'click here', 'here', 'read more', 'more', 'learn more',
        'details', 'link', 'click', 'download', 'go', 'info', 'continue',
    ];

    /** @var array  CSS 中需轉換單位的屬性名稱清單 */
    private $cssTargetProps = [
        'font-size',
        'line-height',
        'max-width',
        'min-width',
        'max-height',
        'min-height',
    ];

    // ──────────────────────────────────────────────────────────
    //  修正日誌（每次呼叫 fix() 後可透過 getLogs() 讀取）
    // ──────────────────────────────────────────────────────────

    /** @var array  修正項目日誌 */
    private $logs = [];

    // ════════════════════════════════════════════════════════════
    //  靜態呼叫介面
    // ════════════════════════════════════════════════════════════

    /**
     * 靜態工廠：建立實例，支援後續鏈式設定
     *
     * @param  array $options  選擇性規則開關
     * @return static
     *
     * @example
     *   // 取得實例後再設定
     *   $fixed = AccessibilityFixer::make()
     *       ->setBaseFontSize(18)
     *       ->setNewWindowLabel('Opens in new window')
     *       ->fix($content);
     *
     *   // 建立時傳入規則開關
     *   $fixed = AccessibilityFixer::make([AccessibilityFixer::RULE_ABBR => false])
     *       ->fix($content);
     */
    public static function make(array $options = [])
    {
        return new static($options);
    }

    /**
     * 靜態快捷修正：以預設設定直接修正並回傳結果
     *
     * 等同於 (new AccessibilityFixer())->fix($content)
     * 適合不需要客製設定的簡單場景。
     *
     * @param  string $content  WYSIWYG 輸出的 HTML 片段
     * @return string           修正後的 HTML 片段
     *
     * @example
     *   $fixed = AccessibilityFixer::of($content);
     */
    public static function of(string $content)
    {
        return (new static())->fix($content);
    }

    // ════════════════════════════════════════════════════════════
    //  建構子 & 設定介面
    // ════════════════════════════════════════════════════════════

    /**
     * 建構子
     *
     * @param array $options  選擇性覆蓋規則開關，格式同 self::$rules
     *
     * @example
     *   // 停用含糊連結檢查
     *   $fixer = new AccessibilityFixer([AccessibilityFixer::RULE_AMBIGUOUS => false]);
     */
    public function __construct(array $options = [])
    {
        foreach ($options as $rule => $enabled) {
            $this->setRule($rule, $enabled);
        }
    }

    /**
     * 啟用或停用指定規則
     *
     * @param  string $rule     規則識別碼（使用 self::RULE_* 常數）
     * @param  bool   $enabled  true = 啟用；false = 停用
     * @return $this           支援鏈式呼叫（Method Chaining）
     * @throws InvalidArgumentException  當規則識別碼不存在時
     */
    public function setRule(string $rule, bool $enabled)
    {
        if (!array_key_exists($rule, $this->rules)) {
            throw new InvalidArgumentException(
                "未知的規則識別碼：「{$rule}」。請使用 AccessibilityFixer::RULE_* 常數。"
            );
        }
        $this->rules[$rule] = $enabled;
        return $this;
    }

    /**
     * 設定 rem 換算基準（瀏覽器根元素字型大小）
     *
     * @param  int    $px  根元素字型大小（px），預設 16
     * @return $this
     */
    public function setBaseFontSize(int $px)
    {
        if ($px <= 0) {
            throw new InvalidArgumentException('baseFontSize 必須為正整數。');
        }
        $this->baseFontSizePx = $px;
        return $this;
    }

    /**
     * 設定「另開新視窗」提示文字（支援多語系）
     *
     * @param  string $label  提示文字，例如 'Opens in new window'
     * @return $this
     */
    public function setNewWindowLabel(string $label)
    {
        $this->newWindowLabel = $label;
        return $this;
    }

    /**
     * 新增含糊連結文字到清單
     *
     * @param  string[] $words  額外的含糊文字（不區分大小寫）
     * @return $this
     */
    public function addAmbiguousTexts(array $words)
    {
        foreach ($words as $word) {
            $lower = mb_strtolower(trim($word), 'UTF-8');
            if ($lower !== '' && !in_array($lower, $this->ambiguousLinkTexts, true)) {
                $this->ambiguousLinkTexts[] = $lower;
            }
        }
        return $this;
    }

    /**
     * 新增需轉換單位的 CSS 屬性名稱
     *
     * @param  string[] $props  屬性名稱，如 ['letter-spacing', 'word-spacing']
     * @return $this
     */
    public function addCssTargetProps(array $props)
    {
        foreach ($props as $prop) {
            $prop = strtolower(trim($prop));
            if ($prop !== '' && !in_array($prop, $this->cssTargetProps, true)) {
                $this->cssTargetProps[] = $prop;
            }
        }
        return $this;
    }

    // ════════════════════════════════════════════════════════════
    //  主要公開方法
    // ════════════════════════════════════════════════════════════

    /**
     * 對 HTML 內容執行無障礙修正
     *
     * @param  string $content  WYSIWYG 輸出的 HTML 片段
     * @return string           修正後的 HTML 片段
     */
    public function fix(string $content)
    {
        // 重置本次執行的日誌
        $this->logs = [];

        if (empty(trim($content))) {
            return $content;
        }

        $result = $this->buildDom($content);
        $dom    = $result[0];
        $xpath  = $result[1];

        // 依序執行已啟用的修正規則
        if ($this->rules[self::RULE_LINKS]) {
            $this->fixLinks($dom, $xpath);
        }

        if ($this->rules[self::RULE_AMBIGUOUS]) {
            $this->fixAmbiguousLinks($xpath);
        }

        if ($this->rules[self::RULE_IMAGES]) {
            $this->fixImages($xpath);
        }

        if ($this->rules[self::RULE_TABLES]) {
            $this->fixTables($xpath);
        }

        if ($this->rules[self::RULE_SEMANTIC]) {
            $this->fixSemantic($dom, $xpath);
        }

        if ($this->rules[self::RULE_ABBR]) {
            $this->fixAbbr($xpath);
        }

        if ($this->rules[self::RULE_CSS_INLINE]) {
            $this->fixInlineStyles($xpath);
        }

        if ($this->rules[self::RULE_CSS_STYLE_TAG]) {
            $this->fixStyleTags($xpath);
        }

        return $this->extractHtml($dom);
    }

    /**
     * 取得最後一次 fix() 執行的修正日誌
     *
     * @return array
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * 取得目前所有規則的啟用狀態
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    // ════════════════════════════════════════════════════════════
    //  私有修正方法
    // ════════════════════════════════════════════════════════════

    /**
     * [WCAG 2.4.4] 連結修正
     *   Rule 1：連結文字 = URL → 移除 <a>，只保留純文字
     *   Rule 2：target 非 _self → title 加上「另開新視窗」
     *   Rule 3：連結目的地為檔案 → title 加上「(xxx格式)」
     *   Rule +：target="_blank" → 補 rel="noopener noreferrer"
     */
    private function fixLinks(DOMDocument $dom, DOMXPath $xpath)
    {
        $links = $xpath->query('//a[@href]');
        if (!$links) {
            return;
        }

        $replaceWithText = [];

        foreach ($links as $link) {
            /** @var DOMElement $link */
            $href   = $link->getAttribute('href');
            $text   = trim($link->textContent);
            $target = $link->getAttribute('target');

            // Rule 1：連結文字等於 URL 本身
            if ($text === $href) {
                $replaceWithText[] = $link;
                $this->log(self::RULE_LINKS, "移除純 URL 超連結語法：{$href}");
                continue;
            }

            // Rule 3：判斷連結目的地是否為已知檔案格式
            // Utility::fileExtensions() 回傳副檔名字串（如 'pdf'）或 false
            $fileExt = Utility::fileExtensions($href);

            // Rule 2：target 非 _self（會另開視窗）
            if (!empty($target) && $target !== '_self') {
                $title = $link->getAttribute('title');

                if (mb_strpos($title, $this->newWindowLabel, 0, 'UTF-8') === false) {
                    // 組合基礎 title（先加「另開新視窗」）
                    $newTitle = empty(trim($title))
                    ? $this->newWindowLabel
                    : trim($title) . '（' . $this->newWindowLabel . '）';

                    // Rule 3 延伸：若同時也是檔案，附加「(xxx格式)」
                    if ($fileExt !== false) {
                        $newTitle .= '（' . mb_strtoupper($fileExt, 'UTF-8') . '格式）';
                        $this->log(self::RULE_LINKS, "連結目的地為 {$fileExt} 格式，title 補上格式說明：{$href}");
                    }

                    $link->setAttribute('title', $newTitle);
                    $this->log(self::RULE_LINKS, "連結加上「{$this->newWindowLabel}」提示：{$href}");
                }

                // Rule +：target="_blank" 補上安全性 rel
                if ($target === '_blank') {
                    $rel    = $link->getAttribute('rel');
                    $relArr = array_values(array_filter(preg_split('/\s+/', $rel) ?: []));
                    $added  = [];
                    foreach (['noopener', 'noreferrer'] as $r) {
                        if (!in_array($r, $relArr, true)) {
                            $relArr[] = $r;
                            $added[]  = $r;
                        }
                    }
                    if ($added) {
                        $link->setAttribute('rel', implode(' ', $relArr));
                        $this->log(self::RULE_LINKS, 'target="_blank" 補上 rel=' . implode(',', $added));
                    }
                }
            } elseif ($fileExt !== false) {
                // Rule 3（單獨）：非另開視窗、但目的地是檔案 → title 加上格式說明
                $title       = $link->getAttribute('title');
                $formatLabel = mb_strtoupper($fileExt, 'UTF-8') . '格式';

                // 若 title 尚未含格式說明才補上
                if (mb_strpos($title, $formatLabel, 0, 'UTF-8') === false) {
                    $newTitle = empty(trim($title))
                    ? '（' . $formatLabel . '）'
                    : trim($title) . '（' . $formatLabel . '）';

                    $link->setAttribute('title', $newTitle);
                    $this->log(self::RULE_LINKS, "連結目的地為 {$fileExt} 格式，title 補上格式說明：{$href}");
                }
            }
        }

        // 執行 Rule 1 的節點替換
        foreach ($replaceWithText as $link) {
            $textNode = $dom->createTextNode($link->getAttribute('href'));
            $link->parentNode ? $link->parentNode->replaceChild($textNode, $link) : null;
        }
    }

    /**
     * [WCAG 2.4.9 AAA] 含糊連結文字修正
     *   連結文字本身無法說明目的地時，加上 aria-label 提示。
     */
    private function fixAmbiguousLinks(DOMXPath $xpath)
    {
        $links = $xpath->query('//a[@href]');
        if (!$links) {
            return;
        }

        foreach ($links as $link) {
            /** @var DOMElement $link */
            $text = mb_strtolower(trim($link->textContent), 'UTF-8');

            if (!in_array($text, $this->ambiguousLinkTexts, true)) {
                continue;
            }

            // 已有 aria-label 或 title，不覆蓋
            if ($link->hasAttribute('aria-label') || $link->hasAttribute('title')) {
                continue;
            }

            $link->setAttribute(
                'aria-label',
                trim($link->textContent) . '（請補充連結說明，符合 WCAG 2.4.9）'
            );
            $this->log(self::RULE_AMBIGUOUS, "含糊連結文字「{$text}」加上 aria-label 提示");
        }
    }

    /**
     * [WCAG 1.1.1] 圖片無障礙修正
     *   - 補全缺少的 alt 屬性
     *   - 裝飾性圖片（alt=""）補 role="presentation"
     *   - 移除與 alt 完全相同的 title（避免重複朗讀）
     *   - 圖片一律加上 class="img-fluid"（Bootstrap 響應式縮放）
     */
    private function fixImages(DOMXPath $xpath)
    {
        $images = $xpath->query('//img');
        if (!$images) {
            return;
        }

        foreach ($images as $img) {
            /** @var DOMElement $img */
            $src = $img->getAttribute('src');

            // 補全缺少的 alt 屬性
            if (!$img->hasAttribute('alt')) {
                $img->setAttribute('alt', '');
                $this->log(self::RULE_IMAGES, "圖片補全 alt=\"\"：{$src}");
            }

            $alt = $img->getAttribute('alt');

            // 裝飾性圖片（alt=""）補 role="presentation"
            if ($alt === '' && !$img->hasAttribute('role')) {
                $img->setAttribute('role', 'presentation');
                $this->log(self::RULE_IMAGES, "裝飾性圖片加上 role=\"presentation\"：{$src}");
            }

            // 移除與 alt 完全相同的 title（避免螢幕閱讀器重複朗讀）
            if (!empty($alt) && $img->getAttribute('title') === $alt) {
                $img->removeAttribute('title');
                $this->log(self::RULE_IMAGES, "移除與 alt 重複的 title：{$src}");
            }

            // 圖片一律補上 class="img-fluid"（Bootstrap 響應式縮放）
            // 若已有 class 屬性則附加，已含 img-fluid 則跳過
            $existingClass = $img->getAttribute('class');
            $classArr      = array_values(array_filter(preg_split('/\s+/', $existingClass) ?: []));
            if (!in_array('img-fluid', $classArr, true)) {
                $classArr[] = 'img-fluid';
                $img->setAttribute('class', implode(' ', $classArr));
                $this->log(self::RULE_IMAGES, "圖片加上 class=\"img-fluid\"：{$src}");
            }
        }
    }

    /**
     * [WCAG 1.3.1] 表格語意修正
     *   - <thead><th> 補 scope="col"
     *   - <tbody> 列首 <th> 補 scope="row"
     *   - 無標籤的表格補 aria-label
     */
    private function fixTables(DOMXPath $xpath)
    {
        $tables = $xpath->query('//table');
        if (!$tables) {
            return;
        }

        foreach ($tables as $table) {
            /** @var DOMElement $table */
            $hasCaption      = ($xpath->query('.//caption', $table)->length ?? 0) > 0;
            $hasAriaLabel    = $table->hasAttribute('aria-label');
            $hasAriaLabelled = $table->hasAttribute('aria-labelledby');

            // if (!$hasCaption && !$hasAriaLabel && !$hasAriaLabelled) {
            //     $table->setAttribute('aria-label', '資料表格（請補充表格說明，符合 WCAG 1.3.1）');
            //     $this->log(self::RULE_TABLES, '表格缺少標題，補上 aria-label 提示');
            // }

            foreach ($xpath->query('.//thead//th', $table) ?: [] as $th) {
                /** @var DOMElement $th */
                if (!$th->hasAttribute('scope')) {
                    $th->setAttribute('scope', 'col');
                    $this->log(self::RULE_TABLES, 'thead > th 補上 scope="col"');
                }
            }

            foreach ($xpath->query('.//tbody//tr/th[1]', $table) ?: [] as $th) {
                /** @var DOMElement $th */
                if (!$th->hasAttribute('scope')) {
                    $th->setAttribute('scope', 'row');
                    $this->log(self::RULE_TABLES, 'tbody 列首 th 補上 scope="row"');
                }
            }
        }
    }

    /**
     * [WCAG 1.3.1] 語意 HTML 修正
     *   - <b> → <strong>
     *   - 無 class 且無 aria-hidden 的 <i> → <em>
     */
    private function fixSemantic(DOMDocument $dom, DOMXPath $xpath)
    {
        $bNodes = iterator_to_array($xpath->query('//b') ?: new DOMNodeList());
        foreach ($bNodes as $node) {
            $this->replaceElement($dom, $node, 'strong');
            $this->log(self::RULE_SEMANTIC, '<b> 替換為 <strong>');
        }

        $iNodes = iterator_to_array(
            $xpath->query('//i[not(@class) and not(@aria-hidden)]') ?: new DOMNodeList()
        );
        foreach ($iNodes as $node) {
            $this->replaceElement($dom, $node, 'em');
            $this->log(self::RULE_SEMANTIC, '<i> 替換為 <em>');
        }
    }

    /**
     * [WCAG 3.1.4 AAA] 縮寫語意修正
     *   <abbr> 若缺 title，加上提示提醒補充
     */
    private function fixAbbr(DOMXPath $xpath)
    {
        $abbrs = $xpath->query('//abbr[not(@title)]');
        if (!$abbrs) {
            return;
        }

        foreach ($abbrs as $abbr) {
            /** @var DOMElement $abbr */
            $text = $abbr->textContent;
            $abbr->setAttribute('title', '（請補充縮寫全名，符合 WCAG 3.1.4）');
            $this->log(self::RULE_ABBR, "<abbr> 缺少 title：{$text}");
        }
    }

    /**
     * [WCAG 1.4.4] Inline Style CSS 單位相對化
     */
    private function fixInlineStyles(DOMXPath $xpath)
    {
        $nodes = $xpath->query('//*[@style]');
        if (!$nodes) {
            return;
        }

        foreach ($nodes as $node) {
            /** @var DOMElement $node */
            $original = $node->getAttribute('style');
            $fixed    = $this->convertCssUnits($original);
            if ($fixed !== $original) {
                $node->setAttribute('style', $fixed);
                $this->log(self::RULE_CSS_INLINE, "inline style 單位轉換：{$original} → {$fixed}");
            }
        }
    }

    /**
     * [WCAG 1.4.4] <style> 標籤 CSS 單位相對化
     */
    private function fixStyleTags(DOMXPath $xpath)
    {
        $styleTags = $xpath->query('//style');
        if (!$styleTags) {
            return;
        }

        foreach ($styleTags as $styleTag) {
            /** @var DOMElement $styleTag */
            $original = $styleTag->textContent;
            $fixed    = $this->convertCssUnits($original);

            if ($fixed !== $original) {
                while ($styleTag->firstChild) {
                    $styleTag->removeChild($styleTag->firstChild);
                }
                $styleTag->appendChild(
                    $styleTag->ownerDocument->createTextNode($fixed)
                );
                $this->log(self::RULE_CSS_STYLE_TAG, '<style> 標籤 CSS 單位已轉換');
            }
        }
    }

    // ════════════════════════════════════════════════════════════
    //  私有輔助方法
    // ════════════════════════════════════════════════════════════

    /**
     * 載入 HTML 片段並回傳 [DOMDocument, DOMXPath]
     *
     * @return array
     */
    private function buildDom(string $html)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML(
            '<?xml encoding="utf-8" ?><div id="a11y-root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        return [$dom, new DOMXPath($dom)];
    }

    /**
     * 從 DOM 取出修正結果 HTML
     */
    private function extractHtml(DOMDocument $dom)
    {
        $root = $dom->getElementById('a11y-root');
        if (!$root) {
            return '';
        }

        $html = '';
        foreach ($root->childNodes as $child) {
            $html .= $dom->saveHTML($child);
        }

        return $html;
    }

    /**
     * CSS 絕對單位 → rem 相對單位
     *
     * 換算基準（$this->baseFontSizePx = 16）：
     *   px → ÷ base
     *   pt → pt × (4/3) ÷ base  （1pt = 4/3 px）
     *   pc → pc × 16 ÷ base      （1pc = 12pt = 16px）
     *   in → in × 96 ÷ base      （1in = 96px）
     *   cm → cm × (96/2.54) ÷ base
     *   mm → mm × (96/25.4) ÷ base
     */
    private function convertCssUnits(string $css)
    {
        $propsPattern = implode('|', array_map('preg_quote', $this->cssTargetProps));
        $base         = $this->baseFontSizePx;

        $self = $this; // 用於閉包中訪問 $this

        return preg_replace_callback(
            '/(' . $propsPattern . ')\s*:\s*([^;}\'"]+)/i',
            function (array $matches) use ($base, $self) {
                $prop  = $matches[1];
                $value = $matches[2];

                $converted = preg_replace_callback(
                    '/([\d]*\.?[\d]+)\s*(px|pt|pc|in|cm|mm)\b/i',
                    function (array $m) use ($base) {
                        $val  = (float) $m[1];
                        $unit = strtolower($m[2]);

                        $px = 0;
                        switch ($unit) {
                            case 'px':
                                $px = $val;
                                break;
                            case 'pt':
                                $px = $val * (4 / 3);
                                break;
                            case 'pc':
                                $px = $val * 16;
                                break;
                            case 'in':
                                $px = $val * 96;
                                break;
                            case 'cm':
                                $px = $val * (96 / 2.54);
                                break;
                            case 'mm':
                                $px = $val * (96 / 25.4);
                                break;
                        }

                        $rem       = $px / $base;
                        $formatted = rtrim(rtrim(number_format($rem, 4, '.', ''), '0'), '.');

                        return $formatted . 'rem';
                    },
                    $value
                ) ?? $value;

                return $prop . ': ' . $converted;
            },
            $css
        ) ?? $css;
    }

    /**
     * 替換 DOM 元素標籤，保留所有屬性與子節點
     */
    private function replaceElement(DOMDocument $dom, DOMNode $node, string $newTag)
    {
        if (!$node->parentNode) {
            return;
        }

        $newNode = $dom->createElement($newTag);

        if ($node->hasAttributes()) {
            foreach ($node->attributes as $attr) {
                $newNode->setAttribute($attr->name, $attr->value);
            }
        }

        while ($node->firstChild) {
            $newNode->appendChild($node->firstChild);
        }

        $node->parentNode->replaceChild($newNode, $node);
    }

    /**
     * 記錄修正項目到 logs
     */
    private function log(string $rule, string $message)
    {
        $this->logs[] = ['rule' => $rule, 'message' => $message];
    }
}
