# AccessibilityFixer 使用說明

> WCAG 2.1 AAA 無障礙 HTML 內容自動修正類別  
> PHP 8.1+ ｜ ext-dom ｜ ext-mbstring

---

## 目錄

1. [安裝需求](#1-安裝需求)
2. [快速開始](#2-快速開始)
3. [修正規則說明](#3-修正規則說明)
4. [設定選項](#4-設定選項)
5. [取得修正日誌](#5-取得修正日誌)
6. [方法鏈式呼叫](#6-方法鏈式呼叫)
7. [整合 CMS / 框架](#7-整合-cms--框架)
8. [規則常數總覽](#8-規則常數總覽)

---

## 1. 安裝需求

| 項目 | 版本需求 |
|------|---------|
| PHP | 8.1 以上 |
| ext-dom | 隨 PHP 標準安裝 |
| ext-mbstring | 需手動確認已啟用 |

### 確認 PHP 擴充套件

```bash
php -m | grep -E "dom|mbstring"
```

### 引入類別

直接複製 `AccessibilityFixer.php` 到專案目錄，再 `require` 即可，或使用 Composer autoload：

```php
require_once 'AccessibilityFixer.php';
```

---

## 2. 快速開始

```php
<?php
require_once 'AccessibilityFixer.php';

$fixer   = new AccessibilityFixer();
$content = '<a href="https://abc.com" target="_blank">abc網站</a>';
$fixed   = $fixer->fix($content);

echo $fixed;
// <a href="https://abc.com" target="_blank"
//    title="另開新視窗"
//    rel="noopener noreferrer">abc網站</a>
```

---

## 3. 修正規則說明

### 規則 1｜[WCAG 2.4.4] 連結文字等於 URL → 移除超連結語法

連結文字本身就是 URL，對螢幕閱讀器使用者毫無語意，改為純文字。

```php
// 輸入
'<p>參考 <a href="https://abc.com">https://abc.com</a></p>'

// 輸出
'<p>參考 https://abc.com</p>'
```

---

### 規則 2｜[WCAG 2.4.4] 另開新視窗連結加上 title 說明

`target` 屬性非 `_self` 時，在 `title` 加上「另開新視窗」提示。

```php
// 輸入
'<a href="https://abc.com" target="_blank">abc網站</a>'

// 輸出
'<a href="https://abc.com" target="_blank"
    title="另開新視窗"
    rel="noopener noreferrer">abc網站</a>'
```

> **注意**：若連結已有 `title`，會在尾端附加「（另開新視窗）」，而非覆蓋。

```php
// 輸入（已有 title）
'<a href="https://abc.com" target="_blank" title="政府入口網">政府官網</a>'

// 輸出
'<a href="https://abc.com" target="_blank"
    title="政府入口網（另開新視窗）"
    rel="noopener noreferrer">政府官網</a>'
```

---

### 規則 3｜[WCAG 1.4.4] CSS 絕對單位 → 相對單位（rem）

**影響的 CSS 屬性**：`font-size`、`line-height`、`max-width`、`min-width`、`max-height`、`min-height`

**支援的絕對單位**：`px`、`pt`、`pc`、`in`、`cm`、`mm`

```php
// 輸入
'<p style="font-size: 16px; line-height: 24px; max-width: 960px;">內文</p>'

// 輸出（基準：16px = 1rem）
'<p style="font-size: 1rem; line-height: 1.5rem; max-width: 60rem;">內文</p>'
```

換算公式（以預設 `baseFontSize = 16px` 為例）：

| 單位 | 換算方式 | 例：16px/16 |
|------|---------|------------|
| px | ÷ 16 | 1rem |
| pt | × (4/3) ÷ 16 | 12pt → 1rem |
| pc | × 16 ÷ 16 | 1pc → 1rem |
| in | × 96 ÷ 16 | 0.1667in → 1rem |
| cm | × (96/2.54) ÷ 16 | 0.4233cm → 1rem |
| mm | × (96/25.4) ÷ 16 | 4.233mm → 1rem |

---

### 規則 4｜[WCAG 2.4.9 AAA] 含糊連結文字 → 加上 aria-label 提示

「點此」「更多」「click here」等無意義文字無法讓使用者了解連結目的，自動加上 `aria-label` 提示開發者補充說明。

```php
// 輸入
'<a href="/news/123">點此</a>'

// 輸出
'<a href="/news/123" aria-label="點此（請補充連結說明，符合 WCAG 2.4.9）">點此</a>'
```

---

### 規則 5｜[WCAG 1.1.1] 圖片 alt 屬性補全

```php
// 輸入（缺少 alt）
'<img src="banner.jpg">'

// 輸出（裝飾圖加 role="presentation"）
'<img src="banner.jpg" alt="" role="presentation">'
```

---

### 規則 6｜[WCAG 1.3.1] 語意 HTML 修正

```php
// <b> → <strong>
'<p>這是<b>重點</b></p>'  →  '<p>這是<strong>重點</strong></p>'

// <i>（無 class）→ <em>
'<p>請<i>注意</i></p>'    →  '<p>請<em>注意</em></p>'

// 有 class 的 <i>（圖示字型）→ 不動
'<i class="icon-home"></i>'  →  不改變
```

---

### 規則 7｜[WCAG 1.3.1] 表格語意補全

```php
// 輸入
'<table>
   <thead><tr><th>姓名</th><th>年齡</th></tr></thead>
   <tbody><tr><th>王小明</th><td>30</td></tr></tbody>
</table>'

// 輸出
'<table aria-label="資料表格（請補充表格說明，符合 WCAG 1.3.1）">
   <thead><tr>
     <th scope="col">姓名</th>
     <th scope="col">年齡</th>
   </tr></thead>
   <tbody><tr>
     <th scope="row">王小明</th>
     <td>30</td>
   </tr></tbody>
</table>'
```

---

### 規則 8｜[WCAG 3.1.4 AAA] 縮寫語意補全

```php
// 輸入
'<abbr>WCAG</abbr>'

// 輸出
'<abbr title="（請補充縮寫全名，符合 WCAG 3.1.4）">WCAG</abbr>'
```

---

## 4. 設定選項

### 4-1. 建構子傳入規則開關

```php
// 停用含糊連結檢查 & 縮寫補全
$fixer = new AccessibilityFixer([
    AccessibilityFixer::RULE_AMBIGUOUS => false,
    AccessibilityFixer::RULE_ABBR      => false,
]);
```

### 4-2. 動態設定規則

```php
$fixer = new AccessibilityFixer();
$fixer->setRule(AccessibilityFixer::RULE_CSS_INLINE, false);   // 停用 inline CSS 修正
$fixer->setRule(AccessibilityFixer::RULE_CSS_STYLE_TAG, false); // 停用 <style> 標籤修正
```

### 4-3. 自訂 rem 換算基準

若網站根元素設定了非 16px 的字型大小：

```php
// 網站根元素為 18px
$fixer = new AccessibilityFixer();
$fixer->setBaseFontSize(18);
```

### 4-4. 多語系「另開新視窗」提示

```php
// 英文介面
$fixer->setNewWindowLabel('Opens in new window');

// 日文介面
$fixer->setNewWindowLabel('新しいウィンドウで開く');
```

### 4-5. 新增含糊連結文字

```php
// 增加自訂含糊文字
$fixer->addAmbiguousTexts(['看看', '按下', 'see more', 'tap here']);
```

### 4-6. 新增 CSS 屬性轉換清單

```php
// 額外轉換 letter-spacing 與 word-spacing
$fixer->addCssTargetProps(['letter-spacing', 'word-spacing']);
```

---

## 5. 取得修正日誌

每次呼叫 `fix()` 後，可透過 `getLogs()` 取得本次所有修正的詳細記錄：

```php
$fixer   = new AccessibilityFixer();
$content = '<b>重要</b><img src="photo.jpg"><a href="https://abc.com" target="_blank">前往</a>';
$fixed   = $fixer->fix($content);

foreach ($fixer->getLogs() as $entry) {
    echo "[{$entry['rule']}] {$entry['message']}\n";
}
```

輸出範例：

```
[semantic_html] <b> 替換為 <strong>
[images] 圖片補全 alt=""：photo.jpg
[images] 裝飾性圖片加上 role="presentation"：photo.jpg
[links] 連結加上「另開新視窗」提示：https://abc.com
[links] target="_blank" 補上 rel=noopener,noreferrer
[ambiguous_links] 含糊連結文字「前往」加上 aria-label 提示
```

---

## 6. 方法鏈式呼叫

所有設定方法均支援 Method Chaining，可一行完成設定：

```php
$fixed = (new AccessibilityFixer())
    ->setBaseFontSize(18)
    ->setNewWindowLabel('Opens in new window')
    ->setRule(AccessibilityFixer::RULE_ABBR, false)
    ->addAmbiguousTexts(['see more', 'tap here'])
    ->addCssTargetProps(['letter-spacing'])
    ->fix($content);
```

---

## 7. 整合 CMS / 框架

### WordPress（functions.php）

```php
require_once get_template_directory() . '/lib/AccessibilityFixer.php';

add_filter('the_content', function (string $content): string {
    return (new AccessibilityFixer())->fix($content);
});
```

### Laravel（Service Provider）

```php
// app/Providers/AppServiceProvider.php
use App\Services\AccessibilityFixer;

public function boot(): void
{
    $this->app->singleton(AccessibilityFixer::class, function () {
        return (new AccessibilityFixer())
            ->setBaseFontSize(16)
            ->setNewWindowLabel('另開新視窗');
    });
}
```

```php
// 在 Controller 或 View Composer 中使用
public function show(AccessibilityFixer $fixer, Post $post): View
{
    return view('post.show', [
        'content' => $fixer->fix($post->content),
    ]);
}
```

---

## 8. 規則常數總覽

| 常數 | 值 | 對應 WCAG | 說明 |
|------|----|-----------|------|
| `RULE_LINKS` | `links` | 2.4.4 AA | 連結文字=URL移除；另開視窗加 title；補 rel |
| `RULE_AMBIGUOUS` | `ambiguous_links` | 2.4.9 AAA | 含糊連結文字加 aria-label 提示 |
| `RULE_IMAGES` | `images` | 1.1.1 A | 圖片補 alt；裝飾圖加 role |
| `RULE_TABLES` | `tables` | 1.3.1 A | 表格補 scope / aria-label |
| `RULE_SEMANTIC` | `semantic_html` | 1.3.1 A | `<b>`→`<strong>`；`<i>`→`<em>` |
| `RULE_ABBR` | `abbr` | 3.1.4 AAA | 縮寫補 title |
| `RULE_CSS_INLINE` | `css_inline` | 1.4.4 AA | inline style 絕對單位→rem |
| `RULE_CSS_STYLE_TAG` | `css_style_tag` | 1.4.4 AA | `<style>` 標籤絕對單位→rem |
