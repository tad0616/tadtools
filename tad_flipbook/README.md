# AccessiblePdfFlipbook

無障礙 PDF 翻頁書套件 — **PDF.js** 渲染 + **StPageFlip** 翻頁效果。
純前端、無框架、無後端,以 **WCAG 2.2 AAA** 為對齊目標。

---

## ✨ 特色

- 📖 PDF 自動渲染為翻頁書,支援滑鼠、觸控、鍵盤
- ♿ 完整鍵盤操作、ARIA 語意、NVDA 即時報讀
- 🎬 尊重 `prefers-reduced-motion`(自動停用翻頁動畫)
- 🔗 永遠提供原始 PDF 連結作為等效替代內容
- 🌐 內建 `zh-Hant` / `en`,訊息可完全覆寫

---

## 📦 安裝

無建置工具,直接以 `<script>` 引入三個相依:

```html
<link rel="stylesheet" href="/src/accessible-pdf-flipbook.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/page-flip@2.0.7/dist/js/page-flip.browser.js"></script>
<script src="/src/AccessiblePdfFlipbook.js"></script>

<script>
  pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>
```

---

## 🚀 快速開始

```html
<div id="pdfFlipbook"></div>

<script>
  const flipbook = new AccessiblePdfFlipbook({
    container: '#pdfFlipbook',
    pdfUrl: '/files/sample.pdf',
    language: 'zh-Hant',
    enableKeyboard: true,
    enableScreenReaderAnnouncements: true
  });
  await flipbook.init();
</script>
```

> ⚠️ PDF 必須與頁面**同源**,或伺服器設定正確的 CORS 標頭。
> 本機測試請使用靜態伺服器(如 `npx serve`),勿直接以 `file://` 開啟。

---

## ⚙️ 選項

| 選項 | 型別 | 預設 | 說明 |
|------|------|------|------|
| `container` | string \| Element | (必填) | 容器選擇器或元素 |
| `pdfUrl` | string | (必填) | PDF 檔案 URL |
| `language` | string | `'zh-Hant'` | `'zh-Hant'` 或 `'en'` |
| `enableKeyboard` | boolean | `true` | 啟用鍵盤導覽 |
| `enableScreenReaderAnnouncements` | boolean | `true` | 啟用 aria-live 報讀 |
| `zoom` | number | `1.5` | PDF.js 渲染倍率(0.25–4) |
| `messages` | object | — | 覆寫任何 i18n 訊息 |

---

## 🧰 API

| 方法 | 回傳 | 說明 |
|------|------|------|
| `init()` | `Promise<this>` | 建構 DOM、掛事件、載入 PDF |
| `destroy()` | `void` | 完整清理,焦點不遺失 |
| `load(pdfUrl)` | `Promise<void>` | 載入新 PDF |
| `nextPage()` / `previousPage()` | `void` | 翻頁(邊界時報讀提示) |
| `goToPage(n)` | `void` | 跳至第 n 頁(1-based) |
| `getCurrentPage()` | `number` | 目前頁碼 |
| `getTotalPages()` | `number` | 總頁數 |
| `setZoom(scale)` | `Promise<void>` | 重新渲染並保留目前頁碼 |

---

## ⌨️ 鍵盤對照表

| 按鍵 | 動作 |
|------|------|
| `Tab` / `Shift+Tab` | 移動焦點 |
| `→` / `PageDown` | 下一頁 |
| `←` / `PageUp` | 上一頁 |
| `Home` / `End` | 第一頁 / 最後一頁 |
| `Enter` / `Space` | 焦點在內容區時:下一頁 |

---

## 📁 專案結構

```
/src/AccessiblePdfFlipbook.js     套件主體(UMD)
/src/accessible-pdf-flipbook.css  AAA 取向樣式
/examples/index.html              範例頁
/README.md                        本文件
/ACCESSIBILITY.md                 無障礙符合性說明
```

## 📄 授權

MIT
