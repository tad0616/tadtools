ACCESSIBILITY.md# 無障礙符合性說明(ACCESSIBILITY.md)

本套件以 **WCAG 2.2 AAA** 為對齊目標。
本文件說明已實作的措施、對應的成功準則,以及**已知限制**。

---

## ✅ 已實作措施

### 1. 鍵盤操作(2.1.1 鍵盤、2.1.2 無鍵盤陷阱 — A)
- 所有功能皆可純鍵盤完成:翻頁、跳頁、縮放、下載原始 PDF。
- 支援 `Tab`、`Enter`、`Space`、`←`、`→`、`Home`、`End`、`PageUp`、`PageDown`。
- 無鍵盤陷阱:Tab 可自由進出元件。

### 2. 焦點管理(2.4.3 焦點順序、2.4.7 / 2.4.13 焦點可見 — A/AA/AAA)
- 焦點順序遵循 DOM:替代連結 → 工具列 → 內容區。
- 焦點環為 3px 高對比 outline,搭配 `:focus-visible`。
- **焦點不遺失**:
  - 邊界按鈕使用 `aria-disabled="true"` 而非 `disabled`,保持可聚焦;
  - `destroy()` 前若焦點在元件內,先將焦點移轉至父層。

### 3. 螢幕閱讀器報讀(4.1.3 狀態訊息 — AA)
- `aria-live="polite"` + `role="status"`:
  - 載入:「正在載入 PDF」
  - 渲染進度:「正在渲染第 X 頁,共 Y 頁」
  - 翻頁:「已前往第 X 頁,共 Y 頁」
  - 邊界:「已在第一頁 / 最後一頁」
- `aria-live="assertive"` + `role="alert"`:載入失敗、無效頁碼。
- 訊息先清空再寫入,確保 NVDA 對重複訊息也會重讀。

### 4. 語意化結構(1.3.1 資訊與關係、4.1.2 — A)
- 元件根節點:`role="region"` + `aria-label`。
- 控制列:`role="toolbar"` + `aria-label`。
- 內容區:`aria-roledescription="翻頁書"`、動態 `aria-label` 含頁碼狀態、載入時 `aria-busy="true"`。
- 頁碼輸入框具關聯 `<label>`(視覺隱藏)。

### 5. 動態效果(2.3.3 來自互動的動畫 — AAA)
- 偵測 `prefers-reduced-motion: reduce`:
  - JS 層改用 `turnToPage()`(無動畫)取代 `flip()`;
  - 翻頁陰影透明度設為 0;
  - CSS 層以 media query 將所有 animation/transition 縮至 0.01ms。
- 偏好變更時即時生效(監聽 `matchMedia` change)。

### 6. 顏色對比(1.4.6 對比加強 — AAA)

| 元素 | 前景 / 背景 | 對比 |
|------|------------|------|
| 按鈕文字 | #ffffff / #123a63 | ≈ 10.4:1 ✅ |
| 內文 | #1a1a1a / #ffffff | ≈ 17.4:1 ✅ |
| 提示文字 | #3d3d3d / #ffffff | ≈ 10.9:1 ✅ |
| 焦點環(非文字) | #b35900 / #ffffff | ≈ 5.2:1 ✅(1.4.11 ≥ 3:1) |

另支援 Windows 高對比模式(`forced-colors: active`)。

### 7. 目標尺寸(2.5.5 — AAA)
- 所有按鈕與輸入框最小 **44×44 px**。

### 8. 替代內容(1.1.1 非文字內容 — A)
- 元件頂部永遠提供**原始 PDF 下載連結**,並附說明文字。
- 翻頁書視覺層(圖片)設 `aria-hidden="true"`,避免螢幕閱讀器讀到無意義的圖片節點;等效資訊由內容區 label、live region 與原始 PDF 連結提供。

---

## ⚠️ 已知限制(請務必閱讀)

### Canvas / 圖片無法保證 PDF 內文可被逐字讀取

本套件的渲染流程為:

```
PDF → PDF.js 渲染至 Canvas → 轉為 PNG 圖片 → StPageFlip 翻頁
```

**這表示 PDF 的文字層在轉換過程中消失**。螢幕閱讀器(NVDA、JAWS、VoiceOver)
只能得知「目前在第幾頁」,**無法逐字讀取頁面內文**。

這是所有「Canvas 翻頁書」方案的本質限制,而非實作缺陷。本套件的因應策略:

1. **永遠提供原始 PDF 連結** — 使用者可下載後以 Adobe Reader + NVDA 等
   工具完整閱讀(前提:該 PDF 本身是有文字層的 tagged PDF,而非掃描影像)。
2. **明確告知** — 元件內建提示文字,說明此限制與替代途徑。
3. **建議內容提供者**:
   - 確保來源 PDF 為 tagged PDF(符合 PDF/UA 更佳);
   - 若 PDF 為掃描檔,請先 OCR 並加上文字層;
   - 重要內容可同時提供 HTML 版本,作為最佳的無障礙等效。

### 其他注意事項
- 報讀訊息依賴使用者的螢幕閱讀器與瀏覽器組合;本套件以
  **NVDA + Chrome / Firefox(Windows)** 為主要驗證環境。
- 大型 PDF(> 100 頁)建議調低 `zoom` 以控制記憶體用量。

---

## 🧪 建議驗證清單

- [ ] 純鍵盤(拔掉滑鼠)完成:翻頁、跳頁、縮放、下載
- [ ] NVDA:確認載入、進度、翻頁、邊界、錯誤五類訊息皆被報讀
- [ ] 系統開啟「減少動態效果」後,翻頁無動畫
- [ ] axe DevTools / Lighthouse 無違規
- [ ] Windows 高對比模式下控制項仍清晰可辨
- [ ] `destroy()` 後焦點仍在可見位置
