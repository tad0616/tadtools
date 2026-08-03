/*!
 * AccessiblePdfFlipbook v1.0.0
 * 無障礙 PDF 翻頁書套件(PDF.js + StPageFlip)
 * 目標:WCAG 2.2 AAA。純前端、無框架、無後端。
 * License: MIT
 */
(function (global, factory) {
  if (typeof module === 'object' && typeof module.exports === 'object') {
    module.exports = factory();
  } else {
    global.AccessiblePdfFlipbook = factory();
  }
})(typeof window !== 'undefined' ? window : this, function () {
  'use strict';

  /* ------------------------------------------------------------------ *
   * i18n 訊息字典(可由 options.messages 覆寫)
   * ------------------------------------------------------------------ */
  const I18N = {
    'zh-Hant': {
      regionLabel: 'PDF 翻頁書',
      toolbarLabel: '翻頁書控制列',
      stageLabel: (x, y) => `翻頁書內容區,目前在第 ${x} 頁,共 ${y} 頁。使用左右方向鍵翻頁。`,
      stageRoleDescription: '翻頁書',
      loading: '正在載入 PDF',
      rendering: (x, y) => `正在渲染第 ${x} 頁,共 ${y} 頁`,
      loaded: (y) => `PDF 載入完成,共 ${y} 頁`,
      pageChanged: (x, y) => `已前往第 ${x} 頁,共 ${y} 頁`,
      alreadyFirst: '已在第一頁',
      alreadyLast: '已在最後一頁',
      loadError: '錯誤:PDF 載入失敗,請改用下方的原始 PDF 連結',
      renderError: '錯誤:頁面渲染失敗',
      invalidPage: (y) => `無效的頁碼,請輸入 1 到 ${y} 之間的數字`,
      prevButton: '上一頁',
      nextButton: '下一頁',
      firstButton: '第一頁',
      lastButton: '最後一頁',
      zoomIn: '放大',
      zoomOut: '縮小',
      zoomChanged: (p) => `縮放比例 ${p}%`,
      pageInputLabel: '頁碼',
      goButton: '前往',
      pageStatus: (x, y) => `第 ${x} 頁,共 ${y} 頁`,
      downloadLink: '下載原始 PDF(完整文字版,供螢幕閱讀器逐字閱讀)',
      canvasNotice: '注意:此翻頁書以圖片呈現,螢幕閱讀器無法逐字讀取內文,請使用上方原始 PDF 連結。',
      fullscreenEnter: '進入全螢幕',
      fullscreenExit: '離開全螢幕',
      fullscreenOn: '已進入全螢幕,按 Esc 鍵可離開',
      fullscreenOff: '已離開全螢幕',
      fullscreenUnsupported: '此瀏覽器不支援全螢幕功能',
      zoomReset: '重設縮放為剛好顯示',
    },
    'en': {
      regionLabel: 'PDF flipbook',
      toolbarLabel: 'Flipbook controls',
      stageLabel: (x, y) => `Flipbook content, page ${x} of ${y}. Use arrow keys to flip pages.`,
      stageRoleDescription: 'flipbook',
      loading: 'Loading PDF',
      rendering: (x, y) => `Rendering page ${x} of ${y}`,
      loaded: (y) => `PDF loaded, ${y} pages total`,
      pageChanged: (x, y) => `Moved to page ${x} of ${y}`,
      alreadyFirst: 'Already on the first page',
      alreadyLast: 'Already on the last page',
      loadError: 'Error: failed to load PDF. Please use the original PDF link below.',
      renderError: 'Error: failed to render page',
      invalidPage: (y) => `Invalid page number. Enter a number between 1 and ${y}.`,
      prevButton: 'Previous page',
      nextButton: 'Next page',
      firstButton: 'First page',
      lastButton: 'Last page',
      zoomIn: 'Zoom in',
      zoomOut: 'Zoom out',
      zoomChanged: (p) => `Zoom ${p}%`,
      pageInputLabel: 'Page number',
      goButton: 'Go',
      pageStatus: (x, y) => `Page ${x} of ${y}`,
      downloadLink: 'Download original PDF (full text, screen-reader readable)',
      canvasNotice: 'Note: this flipbook renders pages as images; screen readers cannot read the text verbatim. Use the original PDF link above.',
      fullscreenEnter: 'Enter full-screen mode',
      fullscreenExit: 'Exit full-screen mode',
      fullscreenOn: 'You are now in full-screen mode. Press the Esc key to exit.',
      fullscreenOff: 'Exited full-screen mode',
      fullscreenUnsupported: 'This browser does not support full-screen mode.',
      zoomReset: 'Reset zoom to fit the screen',

    }
  };

  /* ------------------------------------------------------------------ */

  class AccessiblePdfFlipbook {
    /**
     * @param {Object} options
     * @param {string|HTMLElement} options.container - CSS 選擇器或元素
     * @param {string} options.pdfUrl - PDF 檔案 URL
     * @param {string} [options.language='zh-Hant']
     * @param {boolean} [options.enableKeyboard=true]
     * @param {boolean} [options.enableScreenReaderAnnouncements=true]
     * @param {number} [options.zoom=1.5] - PDF.js 渲染倍率
     * @param {Object} [options.messages] - 覆寫 i18n 訊息
     * @param {Object} [options.pdfjsLib] - 預設 window.pdfjsLib
     * @param {Function} [options.PageFlip] - 預設 window.St.PageFlip
     */
    constructor(options = {}) {
      if (!options.container) throw new Error('AccessiblePdfFlipbook: 缺少 container');
      if (!options.pdfUrl) throw new Error('AccessiblePdfFlipbook: 缺少 pdfUrl');

      this._containerRef = options.container;
      this._pdfUrl = options.pdfUrl;
      this._downloadFileName = options.downloadFileName || options.filename || options.downloadName || options.attachmentTitle || options.attachmentName || options.fileName || options.title || options.pdfFileName || null;
      this._language = options.language || 'zh-Hant';
      this._enableKeyboard = options.enableKeyboard !== false;
      this._enableSR = options.enableScreenReaderAnnouncements !== false;
      // 顯示縮放（純 CSS,1 = 100%）
      this._zoom = typeof options.zoom === 'number' ? options.zoom : 1;
      // PDF.js 渲染品質(固定,不隨縮放鈕改變)
      this._renderScale = typeof options.renderScale === 'number' ? options.renderScale : 1.5;

      // 雙模式
      this._imagesBaseUrl = options.imagesBaseUrl || null; // 有給才嘗試 manifest
      this._mode = null;       // 'images' | 'pdfjs'
      this._manifest = null;

      const base = I18N[this._language] || I18N['zh-Hant'];
      this._msg = Object.assign({}, base, options.messages || {});

      this._pdfjsLib = options.pdfjsLib ||
        (typeof window !== 'undefined' ? window.pdfjsLib : null);
      this._PageFlip = options.PageFlip ||
        (typeof window !== 'undefined' && window.St ? window.St.PageFlip : null);

      // 內部狀態
      this._container = null;
      this._pageFlip = null;
      this._pdfDoc = null;
      this._totalPages = 0;
      this._currentPage = 1;
      this._lastAnnouncedPage = 0;
      this._destroyed = false;
      this._initialized = false;
      this._loadToken = 0;          // 防止競態條件
      this._announceTimer = null;
      this._pageSize = { width: 0, height: 0 };

      // 減少動態效果偏好
      this._motionQuery = (typeof window !== 'undefined' && window.matchMedia)
        ? window.matchMedia('(prefers-reduced-motion: reduce)')
        : null;
      // this._reducedMotion = this._motionQuery ? this._motionQuery.matches : false;
      this._reducedMotion = false;

      // 綁定 handler(供 removeEventListener 使用)
      this._onKeydown = this._onKeydown.bind(this);
      this._onMotionChange = this._onMotionChange.bind(this);

      this._onFullscreenChange = this._onFullscreenChange.bind(this);
    }

    /* ================================================================ *
     * 公開 API
     * ================================================================ */

    /** 初始化:建構 DOM、掛事件、載入 PDF */
    async init() {
      if (this._initialized) return this;
      // if (!this._pdfjsLib) throw new Error('找不到 pdfjsLib,請先載入 PDF.js');
      if (!this._PageFlip) throw new Error('找不到 St.PageFlip,請先載入 StPageFlip');

      this._container = typeof this._containerRef === 'string'
        ? document.querySelector(this._containerRef)
        : this._containerRef;
      if (!this._container) throw new Error('找不到容器元素:' + this._containerRef);

      this._buildDom();

      if (this._enableKeyboard) {
        this._container.addEventListener('keydown', this._onKeydown);
      }
      if (this._motionQuery && this._motionQuery.addEventListener) {
        this._motionQuery.addEventListener('change', this._onMotionChange);
      }

      this._initialized = true;
      await this.load(this._pdfUrl);

      this._resizeObserver = new ResizeObserver(() => {
        if (this._destroyed) return;

        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            if (!this._destroyed) {
              this._applyZoom();
            }
          });
        });
      });
      this._resizeObserver.observe(this._stage);

      document.addEventListener('fullscreenchange', this._onFullscreenChange);
      return this;
    }

    /** 載入(或更換)PDF:先試 manifest 圖片模式,失敗退回 PDF.js */
    async load(pdfUrl) {
      this._assertReady();
      this._pdfUrl = pdfUrl;
      const token = ++this._loadToken;

      this._setBusy(true);
      this._announce(this._msg.loading);
      this._setDownloadLink(pdfUrl);
      this._pageSize = { width: 0, height: 0 };

      try {
        const manifest = this._imagesBaseUrl ? await this._tryLoadManifest() : null;
        if (token !== this._loadToken || this._destroyed) return;

        if (manifest) {
          this._mode = 'images';
          this._manifest = manifest;
          await this._loadFromManifest(manifest, token);
        } else {
          this._mode = 'pdfjs';
          await this._loadFromPdfJs(pdfUrl, token);
        }
        if (token !== this._loadToken || this._destroyed) return;

        // ✅ 雙 rAF：等 Chrome layout 穩定後再算尺寸
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            if (token !== this._loadToken || this._destroyed) return;
            this._applyZoom();
            this._updateUiState();
            this._setBusy(false);
            this._announce(this._msg.loaded(this._totalPages));
          });
        });

      } catch (err) {
        if (token !== this._loadToken || this._destroyed) return;
        this._announceError(this._msg.loadError);
        this._setBusy(false);                          // ✅ 錯誤時立即解除 busy
        console.error('[AccessiblePdfFlipbook]', err);
      }
      // finally 移除，改為上面各自處理 setBusy
    }

    /** 銷毀元件、移除事件、還原 DOM,並確保焦點不遺失 */
    destroy() {
      if (this._destroyed) return;
      this._destroyed = true;
      this._loadToken++; // 取消進行中的載入

      // 焦點保護:若焦點在元件內,先移出
      if (this._container && this._container.contains(document.activeElement)) {
        const fallback = this._container.parentElement || document.body;
        if (fallback.tabIndex < 0 && !fallback.hasAttribute('tabindex')) {
          fallback.setAttribute('tabindex', '-1');
        }
        fallback.focus();
      }

      if (this._enableKeyboard && this._container) {
        this._container.removeEventListener('keydown', this._onKeydown);
      }
      if (this._motionQuery && this._motionQuery.removeEventListener) {
        this._motionQuery.removeEventListener('change', this._onMotionChange);
      }
      if (this._announceTimer) clearTimeout(this._announceTimer);

      this._destroyPageFlip();

      if (this._pdfDoc && this._pdfDoc.destroy) {
        this._pdfDoc.destroy().catch(() => { });
      }
      this._pdfDoc = null;

      if (this._container) {
        this._container.innerHTML = '';
        this._container.classList.remove('apf-root');
        this._container.removeAttribute('role');
        this._container.removeAttribute('aria-label');
      }

      document.removeEventListener('fullscreenchange', this._onFullscreenChange);
      if (document.fullscreenElement === this._container) {
        document.exitFullscreen().catch(() => { });
      }

      if (this._resizeObserver) {
        this._resizeObserver.disconnect();
        this._resizeObserver = null;
      }
      this._initialized = false;
    }

    /** 下一頁 */
    nextPage() {
      this._assertReady();
      if (this._currentPage >= this._totalPages) {
        this._announce(this._msg.alreadyLast);
        return;
      }

      this._navigate(() => {
        this._pageFlip.flipNext();
      });
    }

    /** 上一頁 */
    previousPage() {
      this._assertReady();
      if (this._currentPage <= 1) {
        this._announce(this._msg.alreadyFirst);
        return;
      }

      this._navigate(() => {
        this._pageFlip.flipPrev();
      });
    }

    /** 跳至指定頁(1-based) */
    goToPage(pageNumber) {
      this._assertReady();
      const n = parseInt(pageNumber, 10);
      if (!Number.isInteger(n) || n < 1 || n > this._totalPages) {
        this._announceError(this._msg.invalidPage(this._totalPages));
        return;
      }
      this._navigate(() => {
        if (this._reducedMotion) this._pageFlip.turnToPage(n - 1);
        else this._pageFlip.flip(n - 1);
      });
    }

    /** 取得目前頁碼(1-based) */
    getCurrentPage() { return this._currentPage; }

    /** 取得總頁數 */
    getTotalPages() { return this._totalPages; }

    /** 設定顯示縮放(0.5 ~ 3,純 CSS,瞬間生效,兩種模式通用) */
    setZoom(scale) {
      this._assertReady();

      let s = Number(scale);
      if (!Number.isFinite(s)) return;

      s = Math.max(0.5, Math.min(3, s));
      s = Math.round(s * 100) / 100;

      this._zoom = s;
      this._applyZoom();

      if (this._zoomStatusEl) {
        this._zoomStatusEl.textContent = Math.round(s * 100) + '%';
      }

      this._announce(this._msg.zoomChanged(Math.round(s * 100)));
    }

    resetZoom() {
      this._assertReady();

      this._zoom = 1;
      this._applyZoom();

      if (this._zoomStatusEl) {
        this._zoomStatusEl.textContent = '100%';
      }

      this._announce(this._msg.zoomChanged(100));
    }

    _applyZoom() {
      if (!this._pageSize.width || !this._pageSize.height || !this._flipMount) return;

      const stage = this._stage;
      if (!stage) return;

      const pageRatio = this._pageSize.height / this._pageSize.width;

      /*
        雙頁攤開比例：
        bookW = 單頁寬 * 2
        bookH = 單頁高
        所以：
        bookH = bookW * pageRatio / 2
      */
      const bookRatio = pageRatio / 2; // bookH / bookW

      const isFs = document.fullscreenElement === this._container;

      let availW;
      let availH;

      if (isFs) {
        // 全螢幕保留安全邊界，避免陰影、翻頁 transform 被裁切
        availW = Math.max(0, stage.clientWidth - 40);
        availH = Math.max(0, stage.clientHeight - 40);
      } else {
        // 一般模式依容器寬度為主
        availW = Math.max(0, stage.clientWidth - 32);

        /*
          一般模式通常不需要用高度限制，因為舞台可以往下撐開。
          但仍給一個合理可用高度，避免 stage 尚未 layout 時出現異常。
        */
        availH = Math.max(0, stage.clientHeight - 32);
      }

      if (availW <= 0) return;

      let baseW;
      let baseH;

      if (isFs) {
        /*
          全螢幕：基準尺寸 = 完整放入可用寬高。
          先以寬度計算；若高度超出，改以高度反推。
        */
        baseW = Math.round(availW);
        baseH = Math.round(baseW * bookRatio);

        if (availH > 0 && baseH > availH) {
          baseH = Math.round(availH);
          baseW = Math.round(baseH / bookRatio);
        }
      } else {
        /*
          一般模式：基準尺寸 = 剛好吃滿容器可用寬度。
          這就是「剛載入時 100% 顯示雙頁」的狀態。
        */
        baseW = Math.round(availW);
        baseH = Math.round(baseW * bookRatio);
      }

      /*
        zoom 的意義：
        1.0 = fit，也就是剛好完整顯示雙頁
        1.1 = 比 fit 大 10%
        0.9 = 比 fit 小 10%
      */
      let bookW = Math.round(baseW * this._zoom);
      let bookH = Math.round(baseH * this._zoom);

      // 避免 Chrome 初始化瞬間算出過小尺寸
      bookW = Math.max(bookW, 320);
      bookH = Math.max(bookH, 240);

      this._flipMount.style.width = bookW + 'px';
      this._flipMount.style.height = bookH + 'px';
      this._flipMount.style.margin = '0 auto';
      this._flipMount.style.transform = '';

      if (this._pageFlipMountInner) {
        this._pageFlipMountInner.style.width = '100%';
        this._pageFlipMountInner.style.height = '100%';
      }

      if (this._pageFlip) {
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            try {
              this._pageFlip.update();
            } catch (_) { }
          });
        });
      }
    }

    /* ================================================================ *
     * DOM 建構
     * ================================================================ */

    _setDownloadLink(pdfUrl) {
      if (!this._downloadLink) return;
      this._downloadLink.href = pdfUrl;
      const fileName = this._getDownloadFileName(pdfUrl);
      this._downloadLink.setAttribute('download', fileName);
      this._downloadLink.setAttribute('data-download-name', fileName);
    }

    _getDownloadFileName(pdfUrl) {
      const explicit = this._downloadFileName
        || this._container?.dataset?.downloadName
        || this._container?.dataset?.fileName
        || this._container?.dataset?.attachmentName
        || this._container?.dataset?.attachmentTitle
        || this._container?.getAttribute?.('data-download-name')
        || this._container?.getAttribute?.('data-file-name')
        || this._container?.getAttribute?.('data-attachment-name')
        || this._container?.getAttribute?.('data-attachment-title');
      if (explicit) {
        return this._sanitizeDownloadFileName(explicit);
      }

      const titleCandidate = (typeof document !== 'undefined' && document.title)
        ? document.title.trim()
        : '';
      const attachmentCandidate = this._container?.dataset?.title
        || this._container?.getAttribute?.('data-title')
        || this._container?.dataset?.name
        || this._container?.getAttribute?.('data-name')
        || '';
      const urlCandidate = this._getUrlBaseName(pdfUrl);
      const source = attachmentCandidate || titleCandidate || urlCandidate || 'document';
      const baseName = source.replace(/\.(pdf)$/i, '').trim();
      return this._sanitizeDownloadFileName(baseName || 'document');
    }

    _getUrlBaseName(url) {
      if (!url) return '';
      try {
        const parsed = new URL(url, window.location.href);
        const pathname = parsed.pathname || '';
        const parts = pathname.split('/').filter(Boolean);
        return parts.length ? parts[parts.length - 1] : '';
      } catch (_) {
        return String(url).split('/').filter(Boolean).pop() || '';
      }
    }

    _sanitizeDownloadFileName(name) {
      const clean = String(name || 'document')
        .replace(/[\\/]+/g, '-')
        .replace(/[\s]+/g, '-')
        .replace(/[^\w\u4e00-\u9fff\-\.]+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '')
        .trim();

      const base = clean || 'document';
      return /\.pdf$/i.test(base) ? base : `${base}.pdf`;
    }

    _buildDom() {
      const c = this._container;
      const msg = this._msg;
      c.classList.add('apf-root');
      c.setAttribute('role', 'region');
      c.setAttribute('aria-label', msg.regionLabel);
      c.innerHTML = '';

      /* --- live regions(視覺隱藏但可被報讀)--- */
      this._liveStatus = el('div', {
        class: 'apf-sr-only', 'aria-live': 'polite', 'aria-atomic': 'true', role: 'status'
      });
      this._liveAlert = el('div', {
        class: 'apf-sr-only', 'aria-live': 'assertive', 'aria-atomic': 'true', role: 'alert'
      });

      /* --- 替代內容:原始 PDF 連結 --- */
      const altBar = el('div', { class: 'apf-altbar' });
      this._downloadLink = el('a', {
        class: 'apf-download', href: this._pdfUrl, download: this._getDownloadFileName(this._pdfUrl)
      }, msg.downloadLink);
      const notice = el('p', { class: 'apf-notice' }, msg.canvasNotice);
      altBar.append(this._downloadLink, notice);

      /* --- 工具列 --- */
      const toolbar = el('div', {
        class: 'apf-toolbar', role: 'toolbar', 'aria-label': msg.toolbarLabel
      });

      this._btnFirst = this._mkBtn('⏮', msg.firstButton, () => this.goToPage(1));
      this._btnPrev = this._mkBtn('◀', msg.prevButton, () => this.previousPage());
      this._btnNext = this._mkBtn('▶', msg.nextButton, () => this.nextPage());
      this._btnLast = this._mkBtn('⏭', msg.lastButton, () => this.goToPage(this._totalPages));

      // 頁碼輸入
      const inputWrap = el('div', { class: 'apf-pagejump' });
      const inputId = 'apf-page-input-' + Math.random().toString(36).slice(2, 8);
      const label = el('label', { for: inputId, class: 'apf-sr-only' }, msg.pageInputLabel);
      this._pageInput = el('input', {
        id: inputId, type: 'number', class: 'apf-input',
        min: '1', value: '1', inputmode: 'numeric'
      });
      const goBtn = this._mkBtn(msg.goButton, msg.goButton, () => {
        this.goToPage(this._pageInput.value);
      });
      goBtn.classList.add('apf-btn-text');
      this._pageInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') { e.preventDefault(); this.goToPage(this._pageInput.value); }
        e.stopPropagation(); // 避免方向鍵被翻頁攔截
      });

      // 視覺頁碼狀態(live region 已負責報讀,此處 aria-hidden 避免重複)
      this._pageStatusEl = el('span', { class: 'apf-status', 'aria-hidden': 'true' }, '—');

      inputWrap.append(label, this._pageInput, goBtn, this._pageStatusEl);

      this._btnZoomOut = this._mkBtn('－', msg.zoomOut, () => this.setZoom(this._zoom - 0.1));
      this._btnZoomReset = this._mkBtn('100%', msg.zoomReset, () => this.resetZoom());
      this._btnZoomIn = this._mkBtn('＋', msg.zoomIn, () => this.setZoom(this._zoom + 0.1));
      this._zoomStatusEl = el('span', {
        class: 'apf-zoom-status',
        'aria-hidden': 'true'
      }, '100%');

      toolbar.append(
        this._btnFirst, this._btnPrev, inputWrap,
        this._btnNext, this._btnLast,
        this._btnZoomOut, this._btnZoomReset, this._btnZoomIn,
        this._zoomStatusEl
      );

      this._btnFullscreen = this._mkBtn('⛶', this._msg.fullscreenEnter,
        () => this.toggleFullscreen());
      toolbar.append(this._btnFullscreen);

      /* --- 舞台 --- */
      this._stage = el('div', {
        class: 'apf-stage', tabindex: '0',
        'aria-roledescription': msg.stageRoleDescription,
        'aria-label': msg.stageLabel(1, 0)
      });
      this._flipMount = el('div', { class: 'apf-flip-mount' });
      this._stage.append(this._flipMount);

      c.append(altBar, toolbar, this._stage, this._liveStatus, this._liveAlert);
    }

    _mkBtn(text, label, onClick) {
      const b = el('button', { type: 'button', class: 'apf-btn', 'aria-label': label, title: label }, text);
      b.addEventListener('click', (e) => {
        if (b.getAttribute('aria-disabled') === 'true') { e.preventDefault(); return; }
        onClick();
      });
      return b;
    }

    /* ================================================================ *
   * IndexedDB 渲染快取
   * ================================================================ */

    // _cacheKey():zoom 改成 renderScale,顯示縮放不再炸快取
    _cacheKey(pageNum) {
      return `${this._pdfUrl}::z${this._renderScale}::p${pageNum}`;
    }

    _openCacheDb() {
      if (this._dbPromise) return this._dbPromise;
      this._dbPromise = new Promise((resolve) => {
        const req = indexedDB.open('apf-cache', 1);
        req.onupgradeneeded = () => req.result.createObjectStore('pages');
        req.onsuccess = () => resolve(req.result);
        req.onerror = () => resolve(null); // 快取失敗不影響主流程
      });
      return this._dbPromise;
    }

    async _cacheGet(key) {
      const db = await this._openCacheDb();
      if (!db) return null;
      return new Promise((resolve) => {
        const req = db.transaction('pages').objectStore('pages').get(key);
        req.onsuccess = () => resolve(req.result || null);
        req.onerror = () => resolve(null);
      });
    }

    async _cachePut(key, dataUrl) {
      const db = await this._openCacheDb();
      if (!db) return;
      try {
        db.transaction('pages', 'readwrite').objectStore('pages').put(dataUrl, key);
      } catch (_) { /* 容量滿等狀況,靜默忽略 */ }
    }

    /* ================================================================ *
 * 雙模式:manifest 偵測與圖片模式載入
 * ================================================================ */

    async _tryLoadManifest() {
      try {
        const base = this._imagesBaseUrl.replace(/\/?$/, '/');
        const res = await fetch(base + 'manifest.json', { cache: 'no-cache' });
        if (!res.ok) return null;                       // 404/403 → fallback

        const m = await res.json();
        if (!Array.isArray(m.pages) || m.pages.length === 0) {
          console.warn('[AccessiblePdfFlipbook] manifest 格式異常,退回 PDF.js');
          return null;
        }
        return m;
      } catch (_) {
        return null; // 網路錯誤、JSON 解析失敗 → 一律 fallback
      }
    }

    async _loadFromManifest(manifest, token) {
      const base = this._imagesBaseUrl.replace(/\/?$/, '/');
      const urls = manifest.pages.map((p) => base + p);

      const size = await this._measureImage(urls[0]);
      if (token !== this._loadToken || this._destroyed) return;

      this._pageSize = size;
      this._totalPages = urls.length;
      this._currentPage = 1;
      this._lastAnnouncedPage = 0;

      // 等 DOM / CSS layout 穩定，Chrome 很需要
      await this._nextFrame();
      await this._nextFrame();

      // 先設定外層書本尺寸
      this._applyZoom();

      await this._nextFrame();

      // 再建立 StPageFlip
      this._mountFlipbook(urls);

      await this._nextFrame();
      await this._nextFrame();

      // 建立後再同步一次
      this._applyZoom();
    }

    _measureImage(url) {
      return new Promise((resolve, reject) => {
        const img = new Image();

        img.onload = () => {
          const w = img.naturalWidth;
          const h = img.naturalHeight;

          const maxBase = 900;
          const scale = Math.min(1, maxBase / w);

          resolve({
            width: Math.round(w * scale),
            height: Math.round(h * scale),
          });
        };

        img.onerror = () => reject(new Error('無法載入首頁圖片: ' + url));
        img.src = url;
      });
    }

    async _loadFromPdfJs(pdfUrl, token) {
      if (!this._pdfjsLib) {
        throw new Error('找不到 pdfjsLib:無 manifest 時需要 PDF.js 作為 fallback');
      }
      const pdf = await this._pdfjsLib.getDocument(pdfUrl).promise;
      if (token !== this._loadToken || this._destroyed) return;

      this._pdfDoc = pdf;
      this._totalPages = pdf.numPages;
      this._currentPage = 1;
      this._lastAnnouncedPage = 0;

      const images = await this._renderAllPages(pdf, token);
      if (!images || token !== this._loadToken || this._destroyed) return;

      await this._nextFrame();
      await this._nextFrame();

      this._applyZoom();

      await this._nextFrame();

      this._mountFlipbook(images);

      await this._nextFrame();
      await this._nextFrame();

      this._applyZoom();

    }

    /* ================================================================ *
     * 渲染與翻頁書掛載
     * ================================================================ */

    async _renderAllPages(pdf, token) {
      const images = [];
      const dpr = Math.min(window.devicePixelRatio || 1, 2);

      for (let i = 1; i <= pdf.numPages; i++) {
        if (token !== this._loadToken || this._destroyed) return null;

        // ✨ 先查快取
        const key = this._cacheKey(i);
        const cached = await this._cacheGet(key);
        if (cached) {
          if (i === 1) await this._measurePageSize(pdf, dpr); // 仍需取得尺寸
          images.push(cached);
          continue;
        }

        this._announce(this._msg.rendering(i, pdf.numPages));

        const page = await pdf.getPage(i);
        // const viewport = page.getViewport({ scale: this._zoom * dpr });
        const viewport = page.getViewport({ scale: this._renderScale * dpr });

        const canvas = document.createElement('canvas');
        canvas.width = Math.floor(viewport.width);
        canvas.height = Math.floor(viewport.height);
        const ctx = canvas.getContext('2d', { alpha: false });

        await page.render({ canvasContext: ctx, viewport }).promise;

        if (i === 1) {
          this._pageSize = {
            width: Math.floor(viewport.width / dpr),
            height: Math.floor(viewport.height / dpr)
          };
        }

        const dataUrl = canvas.toDataURL('image/jpeg', 0.85); // ✨ 見對策 3
        canvas.width = canvas.height = 0;

        this._cachePut(key, dataUrl); // 不 await,背景寫入
        images.push(dataUrl);
      }
      return images;
    }

    async _measurePageSize(pdf, dpr) {
      if (this._pageSize.width > 0) return;
      const page = await pdf.getPage(1);
      // const vp = page.getViewport({ scale: this._zoom * dpr });
      const vp = page.getViewport({ scale: this._renderScale * dpr });
      this._pageSize = {
        width: Math.floor(vp.width / dpr),
        height: Math.floor(vp.height / dpr)
      };
    }

    _mountFlipbook(images, restorePageIndex = null) {
      this._destroyPageFlip();
      this._flipMount.innerHTML = '';

      // ✅ 保存圖片資料，供全螢幕切換時重建使用
      this._images = images;

      const mount = document.createElement('div');
      mount.style.width = '100%';
      mount.style.height = '100%';
      mount.style.position = 'relative';
      this._flipMount.append(mount);

      this._pageFlipMountInner = mount;

      this._pageFlip = new this._PageFlip(mount, {
        width: this._pageSize.width,
        height: this._pageSize.height,

        // 依外層容器伸縮
        size: 'stretch',

        minWidth: 100,
        maxWidth: 3000,
        minHeight: 100,
        maxHeight: 3000,

        // 一開始雙頁攤開
        showCover: false,
        usePortrait: false,

        mobileScrollSupport: true,

        // 翻頁效果
        maxShadowOpacity: this._reducedMotion ? 0 : 0.6,
        flippingTime: this._reducedMotion ? 1 : 900,

        useMouseEvents: true
      });

      this._pageFlip.loadFromImages(images);

      this._pageFlip.on('flip', (e) => {
        this._currentPage = (typeof e.data === 'number' ? e.data : 0) + 1;
        this._afterNavigate();
      });

      this._flipMount.setAttribute('aria-hidden', 'true');

      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          this._applyZoom();

          try {
            if (this._pageFlip) {
              this._pageFlip.update();

              if (restorePageIndex !== null) {
                this._pageFlip.turnToPage(restorePageIndex);
                this._currentPage = restorePageIndex + 1;
                this._updateUiState();
              }
            }
          } catch (_) { }
        });
      });
    }

    _destroyPageFlip() {
      if (this._pageFlip) {
        try {
          this._pageFlip.destroy();
        } catch (_) {
          /* noop */
        }

        this._pageFlip = null;
      }

      this._pageFlipMountInner = null;

      if (this._flipMount) {
        this._flipMount.innerHTML = '';
      }
    }

    async _remountFlipbook() {
      if (!this._images || !this._images.length || !this._flipMount) return;

      const restorePageIndex = Math.max(0, this._currentPage - 1);

      // 先等全螢幕 CSS / flex layout 套用完成
      await this._nextFrame();
      await this._nextFrame();

      this._applyZoom();

      // Chrome 有時候需要再等一點點，讓 fullscreen viewport 完全穩定
      await new Promise((resolve) => setTimeout(resolve, 80));

      this._applyZoom();

      // ✅ 關鍵：重新建立 StPageFlip，而不是只 update
      this._mountFlipbook(this._images, restorePageIndex);

      await this._nextFrame();
      await this._nextFrame();

      this._applyZoom();

      try {
        this._pageFlip && this._pageFlip.update();
      } catch (_) { }
    }

    /* ================================================================ *
     * 導覽、狀態與報讀
     * ================================================================ */

    _navigate(action) {
      if (!this._pageFlip) return;
      action();
      // reduced-motion 的 turnTo* 不一定觸發 flip 事件 → 主動同步
      requestAnimationFrame(() => {
        if (this._pageFlip) {
          this._currentPage = this._pageFlip.getCurrentPageIndex() + 1;
          this._afterNavigate();
        }
      });
    }

    _afterNavigate() {
      this._updateUiState();
      if (this._currentPage !== this._lastAnnouncedPage) {
        this._lastAnnouncedPage = this._currentPage;
        this._announce(this._msg.pageChanged(this._currentPage, this._totalPages));
      }
    }

    _updateUiState() {
      const x = this._currentPage, y = this._totalPages;
      this._pageStatusEl.textContent = this._msg.pageStatus(x, y);
      this._pageInput.value = String(x);
      this._pageInput.max = String(y);
      this._stage.setAttribute('aria-label', this._msg.stageLabel(x, y));

      // 使用 aria-disabled(保持可聚焦)→ 焦點不遺失
      const setDis = (btn, dis) => btn.setAttribute('aria-disabled', dis ? 'true' : 'false');
      setDis(this._btnFirst, x <= 1);
      setDis(this._btnPrev, x <= 1);
      setDis(this._btnNext, x >= y);
      setDis(this._btnLast, x >= y);
    }

    _setBusy(busy) {
      if (this._stage) this._stage.setAttribute('aria-busy', busy ? 'true' : 'false');
      if (this._container) this._container.classList.toggle('apf-busy', busy);
    }

    _announce(text) {
      if (!this._enableSR || !this._liveStatus) return;
      // 先清空再寫入,確保相同訊息也會被 NVDA 重讀
      this._liveStatus.textContent = '';
      if (this._announceTimer) clearTimeout(this._announceTimer);
      this._announceTimer = setTimeout(() => {
        if (!this._destroyed) this._liveStatus.textContent = text;
      }, 60);
    }

    _announceError(text) {
      if (!this._liveAlert) return;
      this._liveAlert.textContent = '';
      requestAnimationFrame(() => {
        if (!this._destroyed) this._liveAlert.textContent = text;
      });
    }

    /* ================================================================ *
     * 鍵盤
     * ================================================================ */

    _onKeydown(e) {
      // 在輸入框內不攔截(已 stopPropagation,此為雙保險)
      if (e.target === this._pageInput) return;

      switch (e.key) {
        case 'ArrowRight':
        case 'PageDown':
          e.preventDefault(); this.nextPage(); break;
        case 'ArrowLeft':
        case 'PageUp':
          e.preventDefault(); this.previousPage(); break;
        case 'Home':
          e.preventDefault(); this.goToPage(1); break;
        case 'End':
          e.preventDefault(); this.goToPage(this._totalPages); break;
        case 'Enter':
        case ' ':
          // 僅當焦點在舞台本身時,Enter/Space = 下一頁(按鈕保留原生行為)
          if (e.target === this._stage) { e.preventDefault(); this.nextPage(); }
          break;
        default: break;
      }
    }

    _onMotionChange(e) {
      this._reducedMotion = e.matches;
      if (this._pageFlip && this._pageFlip.getSettings) {
        // 重新掛載時才會套用新 flippingTime;此處立即生效的部分由 turnTo/flip 分流處理
      }
    }

    _assertReady() {
      if (this._destroyed) throw new Error('AccessiblePdfFlipbook 已被銷毀');
      if (!this._initialized) throw new Error('請先呼叫 init()');
    }
    _nextFrame() {
      return new Promise((resolve) => requestAnimationFrame(resolve));
    }

    /* ================================================================ *
    * 全螢幕
    * ================================================================ */

    /** 切換全螢幕(公開 API) */
    async toggleFullscreen() {
      this._assertReady();
      if (!document.fullscreenEnabled) {
        this._announceError(this._msg.fullscreenUnsupported);
        return;
      }
      try {
        if (document.fullscreenElement === this._container) {
          await document.exitFullscreen();
        } else {
          // 必須由使用者手勢觸發(點擊/按鍵),否則瀏覽器會拒絕
          await this._container.requestFullscreen();
        }
      } catch (err) {
        this._announceError(this._msg.fullscreenUnsupported);
        console.error('[AccessiblePdfFlipbook]', err);
      }
    }

    async _onFullscreenChange() {
      const isFs = document.fullscreenElement === this._container;

      this._container.classList.toggle('apf-fullscreen', isFs);

      const label = isFs ? this._msg.fullscreenExit : this._msg.fullscreenEnter;
      this._btnFullscreen.setAttribute('aria-label', label);
      this._btnFullscreen.title = label;
      this._btnFullscreen.textContent = isFs ? '🗗' : '⛶';

      this._announce(isFs ? this._msg.fullscreenOn : this._msg.fullscreenOff);

      if (!isFs && !this._container.contains(document.activeElement)) {
        this._btnFullscreen.focus();
      }

      // 切換全螢幕時重設為剛好顯示
      this._zoom = 1;

      if (this._zoomStatusEl) {
        this._zoomStatusEl.textContent = '100%';
      }

      await this._remountFlipbook();
    }

  }

  /* ------------------------------------------------------------------ *
   * 小工具:建立元素
   * ------------------------------------------------------------------ */
  function el(tag, attrs, text) {
    const node = document.createElement(tag);
    for (const k in attrs) node.setAttribute(k, attrs[k]);
    if (text != null) node.textContent = text;
    return node;
  }

  return AccessiblePdfFlipbook;
});
