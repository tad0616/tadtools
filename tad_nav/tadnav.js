/**
 * TadNav v1.9.4
 * ★ v1.9.4 修正（無障礙／WCAG 2.4.3 焦點順序）：
 *  12. _wrapSubScroll 的 scroll()：捲動按鈕在 DOM 中固定位於子選單
 *      頭尾，捲動只切換項目 display，不搬動 DOM 順序；鍵盤使用者
 *      按下「向下捲動」後，焦點停留在 downBtn 上，往前 Tab 會跳過
 *      新出現、其實位於 downBtn 之前的項目，須改按 Shift+Tab 才能
 *      到達，焦點順序與畫面呈現順序不一致。
 *      修正：鍵盤觸發（Enter/Space）捲動時，捲動後自動將焦點移至
 *      新可視範圍的第一個項目，使 Tab 順序與內容順序一致；滑鼠點擊
 *      與滾輪捲動則維持原焦點，不做搬移。
 * 修正：
 *   1. 桌機版：hover/click 開啟子選單前先關閉同層其他子選單（互斥）
 *   2. 手機版：強制單欄手風琴，同層互斥
 *   3. WCAG 1.4.10：focusin 時 scrollIntoView
 *   4. Alt+U 便捷鍵：將焦點目標改為 #main-nav-skip，
 *      避免焦點落在 nav 容器導致 AT 朗讀整個導覽列；
 *      同時在焦點離開選單後清空 live region，防止殘留文字被重播
 *   5. _openSubmenu 同步修正左側溢出：
 *      wrap 換行模式下（平板），靠右登入按鈕在第二行靠左時，
 *      子選單開啟的當下立即以 getBoundingClientRect() 同步取得位置，
 *      用 margin-left 推回視窗範圍，瀏覽器首次繪製前就已修正完成
 *   ★ v1.9.1 修正：
 *   6. _markRightItems 移除 spacer early-return：改以實際位置判斷
 *      是否需要 is-right，修正 spacer 後的項目換行至第二行左側時
 *      仍被標記 is-right、子選單往左飛出視窗的問題
 *   7. 修正 is-right 子選單的左側溢出補正：
 *      is-right 使用 right:0 定位，margin-left 對其無效甚至反效果；
 *      改為動態切換成 left:0 定位，並在關閉時清除 inline style
 *   ★ v1.9.2 修正（無障礙）：
 *   8. 移除 aria-haspopup：
 *      aria-haspopup="true" 等同 aria-haspopup="menu"，告知 JAWS 等
 *      AT 切入「應用程式模式」並期待 role="menu" 的子元件；
 *      但本導覽列子選單的 <ul> 無此 role，導致 JAWS 不監聽 aria-live
 *      播報，NVDA 也因互動模式不符而忽略展開狀態通知。
 *      導覽列揭露模式（disclosure navigation）只需 aria-expanded 即可。
 *   9. _announce 改用 setTimeout(50ms) 取代 requestAnimationFrame：
 *      rAF 仍在按鈕點擊的同一繪製週期執行，NVDA + Chrome 會優先
 *      處理點擊系統反饋，導致 aria-live 被忽略；
 *      setTimeout 讓播報延至下一個 task，螢幕報讀器先完成點擊處理
 *      後再接收 live region 更新，確保「已展開／已收合」正確播報。
 *   ★ v1.9.3 修正（無障礙）：
 *  10. 漢堡按鈕改用靜態 aria-label：
 *      原策略隨狀態切換 aria-label（「開啟…」／「關閉…」），
 *      違反 ARIA APG「可及名稱應保持穩定」原則，並造成語音控制
 *      使用者必須記住兩個按鈕名稱；「已展開／已收合」資訊已由
 *      aria-expanded 單獨承擔，無需在名稱中重複傳達。
 *      修正：統一使用固定 aria-label="導覽列選單"，
 *      移除 _handleToggle、_closeMobileMenu、_checkBreakpoint
 *      三處的 aria-label 動態更新邏輯。
 *  11. _setupARIA 補充漢堡按鈕初始化：
 *      原本未對 toggleBtn 設置任何 ARIA 屬性，
 *      若 HTML 模板未預設，AT 在首次互動前無法得知按鈕狀態。
 *      修正：在 _setupARIA 中初始化 aria-expanded、aria-label、
 *      aria-controls，確保頁面載入時狀態即已正確揭露。
 */
(function (root, factory) {
  if (typeof define === "function" && define.amd) { define([], factory); }
  else if (typeof module === "object" && module.exports) { module.exports = factory(); }
  else { root.TadNav = factory(); }
})(typeof self !== "undefined" ? self : this, function () {
  "use strict";

  const THEME_MAP = {
    fontFamily:           "--tadnav-font-family",
    innerMaxWidth:        "--tadnav-inner-max-width",
    navMinHeight:         "--tadnav-nav-min-height",
    navBg:                "--tadnav-nav-bg",
    navShadow:            "--tadnav-nav-shadow",
    brandColor:           "--tadnav-brand-color",
    focusColor:           "--tadnav-focus-color",
    focusShadowColor:     "--tadnav-focus-shadow-color",
    focusWidth:           "--tadnav-focus-width",
    itemColor:            "--tadnav-item-color",
    itemBg:               "--tadnav-item-bg",
    itemFontSize:         "--tadnav-item-font-size",
    itemPaddingX:         "--tadnav-item-padding-x",
    itemPaddingY:         "--tadnav-item-padding-y",
    itemHoverBg:          "--tadnav-item-hover-bg",
    itemHoverColor:       "--tadnav-item-hover-color",
    itemAccent:           "--tadnav-item-accent",
    subBg:                "--tadnav-sub-bg",
    subShadow:            "--tadnav-sub-shadow",
    subBorder:            "--tadnav-sub-border",
    subDivider:           "--tadnav-sub-divider",
    subDividerWidth:      "--tadnav-sub-divider-width",
    subMinWidth:          "--tadnav-sub-min-width",
    subScrollBtnBg:       "--tadnav-scroll-btn-bg",
    subScrollBtnHoverBg:  "--tadnav-scroll-btn-hover-bg",
    subScrollBtnColor:    "--tadnav-scroll-btn-color",
    subScrollBtnHeight:   "--tadnav-scroll-btn-height",
    subItemColor:         "--tadnav-sub-item-color",
    subItemBg:            "--tadnav-sub-item-bg",
    subItemFontSize:      "--tadnav-sub-item-font-size",
    subItemPaddingX:      "--tadnav-sub-item-padding-x",
    subItemPaddingY:      "--tadnav-sub-item-padding-y",
    subItemHoverBg:       "--tadnav-sub-item-hover-bg",
    subItemHoverColor:    "--tadnav-sub-item-hover-color",
    toggleColor:          "--tadnav-toggle-color",
    toggleHoverBg:        "--tadnav-toggle-hover-bg",
    mobileSubBg:          "--tadnav-mobile-bg",
    mobileSubBorder:      "--tadnav-mobile-sub-border",
    mobileSubColor:       "--tadnav-mobile-sub-color",
    mobileItemBorder:     "--tadnav-mobile-item-border",
  };

  class TadNav {
    static _instances = [];
    static _globalListenersAttached = false;

    constructor(selector, options = {}) {
      this.menu =
        typeof selector === "string"
          ? document.querySelector(selector)
          : selector;

      if (!this.menu) {
        console.error("TadNav: element not found:", selector);
        return;
      }

      this.options = Object.assign({
        trigger:             "hover",
        hoverClose:          true,
        hoverDelay:          200,
        hideDelay:           300,
        breakpoint:          768,
        collisionDetection:  true,
        closeOnOutsideClick: true,
        closeOnEsc:          true,
        subScrollItems:      "auto",
        subScrollStep:       3,
        subScrollMargin:     16,
        topOverflow:         "wrap",
        // 手機版導覽列底色深淺設定：'dark' 用半透明黑色疊加（預設），'light' 用半透明白色疊加
        mobileNavTheme:      "dark",
        theme:               {},
        onInit:              null,
        onOpen:              null,
        onClose:             null,
        onBreakpointChange:  null,
        onDestroy:           null,
      }, options);

      this._hoverTimers      = new Map();
      this._eventListeners   = [];
      this._customListeners  = {};
      this._isMobile         = false;
      this._destroyed        = false;
      this._scrollStates     = new Map();
      this._focusTrapHandler = null;
      this._lastInteractionWasKeyboard = false;
      // 程式化批次操作時暫停 aria-live 播報，避免干擾鍵盤導覽
      this._suppressAnnounce = false;

      this._wrapper =
        this.menu.closest(".tadnav-wrapper") || this.menu.parentElement;
      this.toggleBtn = this._wrapper
        ? this._wrapper.querySelector(".tadnav-toggle")
        : null;

      this._init();
      TadNav._instances.push(this);
      if (!TadNav._globalListenersAttached)
        TadNav._attachGlobalListeners();
    }

    // =============================================
    // Init
    // =============================================
    _init() {
      this._applyTheme(this.options.theme);
      this._applyNavTheme();           // 根據 mobileNavTheme 設定 data-nav-theme 屬性
      this._createLiveRegion();
      this._markRightItems();
      this._setupARIA();
      this._applyTopOverflow();
      this._bindEvents();
      this._checkBreakpoint();
      requestAnimationFrame(() => this._markRightItems());
      if (this.options.onInit) this.options.onInit(this);
      this._emit("init", { instance: this });
    }

    // =============================================
    // 頂層溢出模式
    // =============================================
    _applyTopOverflow() {
      this.menu.classList.remove("tadnav-menu-wrap", "tadnav-menu-scroll");
      switch (this.options.topOverflow) {
        case "wrap":
          this.menu.classList.add("tadnav-menu-wrap");
          break;
        case "scroll":
          this.menu.classList.add("tadnav-menu-scroll");
          this._on(this.menu, "wheel", e => {
            if (this._isMobile) return;
            e.preventDefault();
            this.menu.scrollLeft += e.deltaY;
          }, { passive: false });
          break;
      }
    }

    // =============================================
    // 子選單捲動（桌機版專用）
    // =============================================
    _checkSubOverflow(sub) {
      if (this.options.subScrollItems === 0) return;
      if (this._isMobile) return;
      if (this._scrollStates.has(sub)) return;

      const subRect   = sub.getBoundingClientRect();
      const vh        = window.innerHeight;
      const margin    = this.options.subScrollMargin;
      const overflows = subRect.bottom > vh - margin;

      if (this.options.subScrollItems === "auto") {
        if (!overflows) return;
      } else {
        const itemCount = sub.querySelectorAll(":scope > li:not(.tadnav-scroll-btn)").length;
        if (itemCount <= this.options.subScrollItems && !overflows) return;
      }
      this._wrapSubScroll(sub);
    }

    _wrapSubScroll(sub) {
      const items = Array.from(sub.querySelectorAll(":scope > li:not(.tadnav-scroll-btn)"));
      if (items.length < 2) return;
      const itemH = items[0].getBoundingClientRect().height;
      if (itemH <= 0) return;
      const visibleN = this._calcVisibleItems(sub, itemH, items.length);
      if (visibleN >= items.length) return;

      const upBtn = document.createElement("li");
      upBtn.className = "tadnav-scroll-btn tadnav-scroll-up";
      upBtn.setAttribute("role", "button");
      upBtn.setAttribute("tabindex", "0");
      upBtn.setAttribute("aria-label", "向上捲動");
      upBtn.setAttribute("aria-disabled", "true");
      upBtn.innerHTML = '<i class="fa-solid fa-chevron-up" aria-hidden="true"></i>';

      const downBtn = document.createElement("li");
      downBtn.className = "tadnav-scroll-btn tadnav-scroll-down";
      downBtn.setAttribute("role", "button");
      downBtn.setAttribute("tabindex", "0");
      downBtn.setAttribute("aria-label", "向下捲動");
      downBtn.innerHTML = '<i class="fa-solid fa-chevron-down" aria-hidden="true"></i>';

      sub.insertBefore(upBtn, sub.firstChild);
      sub.appendChild(downBtn);

      const state = {
        currentIndex: 0, upBtn, downBtn,
        totalItems: items.length, items, visibleN, itemH,
        scrollListeners: [],
      };
      this._scrollStates.set(sub, state);

      // ★ 修正（WCAG 2.4.3 焦點順序）：
      //   upBtn／downBtn 在 DOM 中固定放在子選單的最前／最後，捲動只是
      //   切換項目的 display，並不會搬動 DOM 順序。因此按下「向下捲動」
      //   後，新出現的項目在 DOM 中仍位於 downBtn 之前；若焦點停留在
      //   downBtn 上，往前 Tab 會直接跳出子選單，鍵盤使用者必須改按
      //   Shift+Tab 才能碰到剛顯示出來的內容，導致取得焦點的順序與畫面
      //   呈現順序不一致。
      //   修正方式：鍵盤觸發（Enter/Space）捲動後，將焦點移至捲動後可視
      //   範圍內的第一個項目，讓 Tab 順序自然銜接新內容；滑鼠點擊與滾輪
      //   捲動則不搬移焦點，避免無預期地打斷視覺焦點所在位置。
      const scroll = (dir, moveFocus) => {
        if (this._isMobile) return;
        const s = this._scrollStates.get(sub);
        if (!s) return;
        const max = s.totalItems - s.visibleN;
        s.items.forEach(li => {
          const nested = li.querySelector(':scope > .tadnav-submenu[data-open="true"]');
          if (nested) this._closeSubmenu(nested);
        });
        const prevIndex = s.currentIndex;
        s.currentIndex = dir === "up"
          ? Math.max(0, s.currentIndex - this.options.subScrollStep)
          : Math.min(max, s.currentIndex + this.options.subScrollStep);
        this._applySubScroll(sub);

        if (moveFocus && s.currentIndex !== prevIndex) {
          const firstVisible = s.items[s.currentIndex];
          const focusTarget = firstVisible?.querySelector(
            'a[href], button.tadnav-submenu-toggle'
          );
          focusTarget?.focus();
        }
      };

      const onUpClick   = () => scroll("up", false);
      const onDownClick = () => scroll("down", false);
      const onUpKey     = e => { if (e.key === "Enter" || e.key === " ") { e.preventDefault(); scroll("up", true); } };
      const onDownKey   = e => { if (e.key === "Enter" || e.key === " ") { e.preventDefault(); scroll("down", true); } };
      const onWheel     = e => {
        if (this._isMobile) return;
        e.preventDefault(); e.stopPropagation();
        scroll(e.deltaY > 0 ? "down" : "up", false);
      };

      upBtn.addEventListener("click",    onUpClick);
      downBtn.addEventListener("click",  onDownClick);
      upBtn.addEventListener("keydown",  onUpKey);
      downBtn.addEventListener("keydown", onDownKey);
      sub.addEventListener("wheel",      onWheel, { passive: false });

      state.scrollListeners.push(
        { el: upBtn,   ev: "click",   fn: onUpClick },
        { el: downBtn, ev: "click",   fn: onDownClick },
        { el: upBtn,   ev: "keydown", fn: onUpKey },
        { el: downBtn, ev: "keydown", fn: onDownKey },
        { el: sub,     ev: "wheel",   fn: onWheel },
      );
      this._applySubScroll(sub);
    }

    _unwrapSubScroll(sub) {
      const state = this._scrollStates.get(sub);
      if (!state) return;
      state.scrollListeners.forEach(({ el, ev, fn }) => el.removeEventListener(ev, fn));
      state.items.forEach(li => { li.style.display = ""; });
      state.upBtn.remove();
      state.downBtn.remove();
      this._scrollStates.delete(sub);
    }

    _calcVisibleItems(sub, itemH, totalItems) {
      if (itemH <= 0) return 5;
      const vh      = window.innerHeight;
      const subTop  = sub.getBoundingClientRect().top;
      const btnHStr = getComputedStyle(this._wrapper || document.documentElement)
                        .getPropertyValue("--tadnav-scroll-btn-height").trim();
      const btnH    = parseFloat(btnHStr) || 28;
      const margin  = this.options.subScrollMargin;
      if (this.options.subScrollItems !== "auto")
        return Math.min(this.options.subScrollItems, totalItems);
      const available = vh - subTop - (btnH * 2) - margin;
      return Math.max(2, Math.min(Math.floor(available / itemH), totalItems));
    }

    _applySubScroll(sub) {
      const state = this._scrollStates.get(sub);
      if (!state) return;
      const { currentIndex, items, totalItems, visibleN, upBtn, downBtn } = state;
      items.forEach((li, i) => {
        li.style.display = (i >= currentIndex && i < currentIndex + visibleN) ? "" : "none";
      });
      upBtn.setAttribute("aria-disabled",   currentIndex <= 0                     ? "true" : "false");
      downBtn.setAttribute("aria-disabled", currentIndex >= totalItems - visibleN ? "true" : "false");
    }

    // =============================================
    // aria-live
    // =============================================
    _createLiveRegion() {
      if (this._liveRegion) return;
      const el = document.createElement("div");
      el.setAttribute("role", "status");
      el.setAttribute("aria-live", "polite");
      el.setAttribute("aria-atomic", "true");
      // aria-relevant="additions" 限制僅新增內容才播報，
      // 清空文字（刪除）時不觸發 AT"空白”播報
      el.setAttribute("aria-relevant", "additions");
      el.style.cssText = "position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;";
      document.body.appendChild(el);
      this._liveRegion = el;
    }

    _announce(message) {
      // 程式化批次操作期間（互斥關閉、focusout 觸發）暫停播報，
      // 避免 Alt+U 跳到導覽列時螢幕報讀器持續播報子選單狀態
      if (!this._liveRegion || this._suppressAnnounce) return;
      // ★ 改用 setTimeout 取代 requestAnimationFrame：
      //   rAF 仍在按鈕點擊的同一繪製週期內執行，NVDA + Chrome 會優先
      //   處理點擊事件的系統反饋，導致 aria-live 變更被忽略。
      //   setTimeout(0) 確保播報在瀏覽器事件佇列的下一個 task 執行，
      //   讓螢幕報讀器先處理完點擊反饋，再接收 live region 更新。
      this._liveRegion.textContent = "";
      setTimeout(() => { this._liveRegion.textContent = message; }, 50);
    }

    // =============================================
    // 主題
    // =============================================
    _applyTheme(theme) {
      if (!theme || typeof theme !== "object" || !this._wrapper) return;
      Object.entries(theme).forEach(([key, value]) => {
        if (key === "mobileNavTheme") return; // 特殊屬性，不作為 CSS 變數寫入
        const cssVar = THEME_MAP[key];
        if (!cssVar) { console.warn(`TadNav: 未知的 theme 屬性 "${key}"`); return; }
        if (value !== null && value !== undefined)
          this._wrapper.style.setProperty(cssVar, String(value));
      });
    }

    /**
     * 依據 options.mobileNavTheme 在 wrapper 元素上設定 data-nav-theme 屬性。
     * 支援 options.mobileNavTheme 與 options.theme.mobileNavTheme 兩種傳參方式。
     * 'light' → 手機版子選單改用半透明白色疊加（適合淡色底深色文字的導覽列）
     * 'dark' （預設） → 手機版子選單繼續使用半透明黑色疊加
     */
    _applyNavTheme() {
      if (!this._wrapper) return;
      const themeVal = this.options.mobileNavTheme || (this.options.theme && this.options.theme.mobileNavTheme);
      const scheme = themeVal === "light" ? "light" : "dark";
      this._wrapper.setAttribute("data-nav-theme", scheme);
    }

    setTheme(newTheme, merge = true) {
      if (!merge) this._clearTheme();
      this.options.theme = merge ? Object.assign({}, this.options.theme, newTheme) : newTheme;
      this._applyTheme(this.options.theme);
      this._applyNavTheme();
      this._emit("themeChange", { theme: this.options.theme });
    }

    _clearTheme() {
      if (!this._wrapper) return;
      Object.values(THEME_MAP).forEach(v => this._wrapper.style.removeProperty(v));
    }

    resetTheme() {
      this._clearTheme();
      this.options.theme = {};
      this._applyNavTheme();
      this._emit("themeChange", { theme: {} });
    }

    getTheme() { return Object.assign({}, this.options.theme); }

    // =============================================
    // Spacer / ARIA
    // =============================================
    _markRightItems() {
      const items = Array.from(this.menu.querySelectorAll(":scope > li"));
      items.forEach(li => li.classList.remove("is-right"));
      const vw          = window.innerWidth;
      const margin      = 8;
      const cssMinWidth = getComputedStyle(this._wrapper || document.documentElement)
        .getPropertyValue("--tadnav-sub-min-width").trim();
      const subMinWidth = parseFloat(cssMinWidth) || 220;
      // ★ 修正：無論有無 spacer，一律以「實際位置」判斷是否需要 is-right。
      //   舊版在偵測到 spacer 後直接 return，不管 li 的實際位置，
      //   導致 wrap 換行後跑到第二行左側的項目仍被標記 is-right，
      //   子選單以 right:0 定位，往左飛出視窗。
      items.forEach(li => {
        if (li.classList.contains("tadnav-spacer")) return;
        if (!li.querySelector(":scope > .tadnav-submenu")) return;
        const liRect = li.getBoundingClientRect();
        if (liRect.width === 0) return;
        if (liRect.left + subMinWidth > vw - margin) li.classList.add("is-right");
      });
    }

    _setupARIA() {
      this.menu.querySelectorAll(".tadnav-submenu").forEach(sub => {
        if (!sub.hasAttribute("data-open")) sub.setAttribute("data-open", "false");
      });

      // ★ 初始化漢堡按鈕的 ARIA 屬性：
      //   _setupARIA 在 _init 與 refresh 時都會呼叫；
      //   若 HTML 模板未預設這些屬性，AT 在首次互動前不知道按鈕狀態。
      //   aria-label 使用固定的「導覽列選單」，不隨展開／收合變動
      //   （狀態語意由 aria-expanded 單獨承擔，符合 ARIA APG）。
      if (this.toggleBtn) {
        if (!this.toggleBtn.hasAttribute("aria-expanded"))
          this.toggleBtn.setAttribute("aria-expanded", "false");
        if (!this.toggleBtn.hasAttribute("aria-label"))
          this.toggleBtn.setAttribute("aria-label", "導覽列選單");
        // aria-controls 指向選單，讓 AT 可直接跳轉至受控元件
        if (!this.menu.id)
          this.menu.id = "tadnav-menu-" + Math.random().toString(36).slice(2, 9);
        this.toggleBtn.setAttribute("aria-controls", this.menu.id);
      }

      // ★ 移除所有 <a role="menuitem"> 的 role：
      //   role="menuitem" 會覆蓋 <a> 的原生連結語義，
      //   螢幕報讀器只播報「功能表項目」而不播報「連結」，
      //   使用者無法得知這是可前往的連結。
      //   移除後 AT 可正確播報「[名稱] 連結」。
      this.menu.querySelectorAll('a[role="menuitem"]').forEach(a => {
        a.removeAttribute("role");
      });

      this.menu.querySelectorAll(".tadnav-submenu-toggle").forEach(toggle => {
        // ★ 移除 role="menuitem"：
        //   <button> 本身具有原生 button 語義，若同時加上 role="menuitem"
        //   會覆蓋 button 角色，導致螢幕報讀器僅播報「功能表項目 子功能表」，
        //   不播報「按鈕」，也不播報 aria-expanded 的展開／收合狀態。
        //   移除後，AT 可正確播報「[名稱] 按鈕 已收合／已展開」。
        toggle.removeAttribute("role");

        if (!toggle.hasAttribute("aria-expanded")) toggle.setAttribute("aria-expanded", "false");
        // ★ 移除 aria-haspopup（或不再加入）：
        //   aria-haspopup="true" 等同於 aria-haspopup="menu"，告知螢幕報讀器
        //   此按鈕會彈出一個 role="menu" 的元件。但本導覽列子選單的 <ul>
        //   並無 role="menu"，造成 JAWS 切入「應用程式模式」後不監聽
        //   aria-live 播報；NVDA 也因 haspopup 期待的互動模式不同而
        //   忽略展開狀態的 live region 通知。
        //   對導覽列揭露模式（disclosure navigation），aria-expanded 已足夠
        //   讓 AT 得知狀態；移除 aria-haspopup 可確保 AT 維持「瀏覽模式」
        //   並正常播報「[名稱] 按鈕 已展開／已收合」。
        toggle.removeAttribute("aria-haspopup");
        const sub = toggle.nextElementSibling;
        if (sub?.classList.contains("tadnav-submenu")) {
          const id = sub.id || "tadnav-sub-" + Math.random().toString(36).slice(2, 9);
          sub.id = id;
          toggle.setAttribute("aria-controls", id);
        }
      });
      // ★ 初始化完成後同步 tabindex 與 aria-hidden
      this._syncSubMenuTabindex();
      // 確保所有收合子選單的 aria-hidden 正確設定
      this.menu.querySelectorAll(".tadnav-submenu").forEach(sub => {
        const isOpen = sub.getAttribute("data-open") === "true";
        sub.setAttribute("aria-hidden", isOpen ? "false" : "true");
      });
    }

    // =============================================
    // Events
    // =============================================
    _bindEvents() {
      if (this.toggleBtn)
        this._on(this.toggleBtn, "click", e => this._handleToggle(e));

      if (this.options.trigger !== "click")
        this._bindHoverEvents();

      this._bindClickEvents();
      this._on(this.menu, "keydown",  e => this._handleKeydown(e));
      this._on(this.menu, "focusout", e => this._handleFocusOut(e));
      this._on(this.menu, "focusin",  e => this._handleFocusIn(e));

      this._on(document, "keydown",   () => { this._lastInteractionWasKeyboard = true; });
      this._on(document, "mousedown", () => { this._lastInteractionWasKeyboard = false; });

      this._resizeObserver = new ResizeObserver(() => {
        this._checkBreakpoint();
        this._markRightItems();
        if (!this._isMobile) {
          this.menu.querySelectorAll('.tadnav-submenu[data-open="true"]')
            .forEach(s => this._detectCollision(s));
        }
      });
      this._resizeObserver.observe(document.documentElement);
    }

    // ★ WCAG 1.4.10：焦點移入時確保可見
    _handleFocusIn(e) {
      const target = e.target;
      if (!target) return;
      // ★ 原以 role="menuitem" 判斷，但 <a> 的 role 已在 _setupARIA 移除，
      //   改為：凡是 menu 內的 <a>、submenu-toggle 按鈕、漢堡按鈕，
      //   取得焦點時均確保捲動可見（WCAG 1.4.10）。
      const isMenuLink  = target.tagName === "A" && this.menu.contains(target);
      const isToggleBtn = target.classList.contains("tadnav-submenu-toggle");
      const isHamburger = target === this.toggleBtn;
      if (!isMenuLink && !isToggleBtn && !isHamburger) return;
      requestAnimationFrame(() => {
        if (document.activeElement === target)
          target.scrollIntoView({ block: "nearest", inline: "nearest", behavior: "smooth" });
      });
    }

    _handleFocusOut(e) {
      if (this._lastInteractionWasKeyboard) {
        setTimeout(() => {
          const active = document.activeElement;
          // ★ 關鍵修正：排除 toggleBtn。
          //   focus trap 將焦點移至 toggleBtn 時，toggleBtn 在 <ul> 之外，
          //   若不排除，this.menu.contains() 為 false，會誤觸 _closeMobileMenu。
          //   使用者應能自行決定何時按 Enter 關閉，而非 Tab 到按鈕就自動關閉。
          if (!this.menu.contains(active) && active !== this.toggleBtn) {
            // ★ 改用 data-mobile-open（而非 _isMobile）判斷選單是否展開，
            //   確保 200-400% 縮放時仍能正確關閉。
            // ★ 焦點因 Alt+U 等便捷鍵離開選單時，程式化關閉不需播報，
            //   以免 aria-live 的播報蓋過焦點目標的播報
            this._suppressAnnounce = true;
            if (this.menu.getAttribute("data-mobile-open") === "true") {
              this._closeMobileMenu();
            } else {
              this.closeAll();
            }
            // ★ 關閉完成後立即清空 live region 殘留文字，
            //   防止 AT 在焦點移到新目標（如 #main-nav-skip）時
            //   重新播報 live region 中的削除前殘留內容
            if (this._liveRegion) this._liveRegion.textContent = "";
            this._suppressAnnounce = false;
          } else if (active) {
            // 焦點還在選單內，檢查所有已展開的子選單
            // 若焦點不在該子選單及其所屬的 <li> 內（亦即離開了該項目層級），則將其收合
            // 同樣靜音，避免焦點在選單內移動時觸發不必要的播報
            this._suppressAnnounce = true;
            this.menu.querySelectorAll('.tadnav-submenu[data-open="true"]').forEach(sub => {
              const parentLi = sub.parentElement;
              // 當焦點從子選單離開時，自動收合該子選單，避免遺擋網頁內容
              if (parentLi && !parentLi.contains(active)) {
                this._closeSubmenu(sub);
              }
            });
            this._suppressAnnounce = false;
          }
        }, 10);
      }
    }

    // ★ 桌機版 hover：開啟前先關閉同層其他子選單
    _bindHoverEvents() {
      this.menu.querySelectorAll("li").forEach(li => {
        const sub = li.querySelector(":scope > .tadnav-submenu");
        if (!sub) return;
        this._on(li, "mouseenter", () => {
          if (this._isMobile || this.options.trigger === "click") return;
          this._clearTimer(li);
          this._hoverTimers.set(li, setTimeout(() => {
            this._closeSiblingSubmenus(sub);   // ★ 關閉同層
            this._openSubmenu(sub);
          }, this.options.hoverDelay));
        });
        this._on(li, "mouseleave", () => {
          if (this._isMobile || this.options.trigger === "click") return;
          if (!this.options.hoverClose) { this._clearTimer(li); return; }
          this._clearTimer(li);
          this._hoverTimers.set(li,
            setTimeout(() => {
              // ★ 增加判斷：若游標正停留在該子選單內的表單中，則不關閉
              const active = document.activeElement;
              if (sub.contains(active) && active.closest("form")) {
                return;
              }
              this._closeSubmenu(sub);
            }, this.options.hideDelay)
          );
        });
      });
    }

    // ★ click：開啟前先關閉同層其他子選單（桌機 + 手機均適用）
    _bindClickEvents() {
      this.menu.querySelectorAll(".tadnav-submenu-toggle").forEach(toggle => {
        this._on(toggle, "click", e => {
          e.preventDefault();
          e.stopPropagation();
          const sub = toggle.nextElementSibling;
          if (!sub) return;
          const isOpen = sub.getAttribute("data-open") === "true";
          if (isOpen) {
            this._closeSubmenu(sub, true);
          } else {
            this._closeSiblingSubmenus(sub);   // ★ 手風琴互斥
            this._openSubmenu(sub);
          }
        });
      });
    }

    _on(el, event, handler, opts) {
      el.addEventListener(event, handler, opts);
      this._eventListeners.push({ el, event, handler, opts });
    }

    _clearTimer(li) {
      if (this._hoverTimers.has(li)) {
        clearTimeout(this._hoverTimers.get(li));
        this._hoverTimers.delete(li);
      }
    }

    // =============================================
    // Hamburger Toggle
    // =============================================
    _handleToggle(e) {
      e.preventDefault();
      const isOpen = this.toggleBtn.getAttribute("aria-expanded") === "true";
      if (isOpen) {
        this.toggleBtn.setAttribute("aria-expanded", "false");
        // ★ 不更動 aria-label：
        //   aria-label 是按鈕的「可及名稱（accessible name）」，
        //   ARIA APG 要求其保持穩定，狀態語意應由 aria-expanded 單獨承擔。
        //   動態改名稱會造成語音控制使用者無法穩定呼叫，
        //   且 "開啟/已收合" 與 "關閉/已展開" 的雙重播報製造資訊冗餘。
        this.menu.setAttribute("data-mobile-open", "false");
        this.closeAll();
        this._deactivateFocusTrap();
        this.toggleBtn.focus();
        this._announce("選單已收合");
      } else {
        this.toggleBtn.setAttribute("aria-expanded", "true");
        this.menu.setAttribute("data-mobile-open", "true");
        this._announce("選單已展開");
        // ★ 焦點保留在 toggleBtn（而非立即跳到第一個選單項）：
        //   讓螢幕報讀器先播報「關閉導覽列選單 按鈕 已展開」，
        //   使用者確認狀態後再自行 Tab 進入選單（符合 WCAG 4.1.2）。
        this._activateFocusTrap();
        // 短暫延遲確保 focus trap 已註冊，再將焦點拉回按鈕
        setTimeout(() => { this.toggleBtn.focus(); }, 50);
      }
    }

    // =============================================
    // Public API
    // =============================================
    open(sub)  { this._openSubmenu(sub); }
    close(sub) { this._closeSubmenu(sub); }

    closeAll() {
      // 批次關閉時靜音，避免每個子選單各自觸發 aria-live 播報
      this._suppressAnnounce = true;
      this.menu.querySelectorAll('.tadnav-submenu[data-open="true"]')
        .forEach(s => this._closeSubmenu(s));
      this._suppressAnnounce = false;
    }

    setTrigger(mode) {
      if (mode !== "hover" && mode !== "click") return;
      this.options.trigger = mode;
      this.closeAll();
    }

    setHoverClose(value) {
      this.options.hoverClose = Boolean(value);
      if (value) this.closeAll();
    }

    refresh() {
      this._markRightItems();
      this._setupARIA();
      this._checkBreakpoint();
    }

    destroy() {
      this._destroyed = true;
      this.closeAll();
      this._deactivateFocusTrap();
      this._eventListeners.forEach(({ el, event, handler, opts }) =>
        el.removeEventListener(event, handler, opts));
      this._eventListeners = [];
      this._hoverTimers.forEach(t => clearTimeout(t));
      this._hoverTimers.clear();
      this._scrollStates.forEach((_, sub) => this._unwrapSubScroll(sub));
      this._scrollStates.clear();
      if (this._resizeObserver) this._resizeObserver.disconnect();
      if (this._liveRegion) { this._liveRegion.remove(); this._liveRegion = null; }
      TadNav._instances = TadNav._instances.filter(i => i !== this);
      if (this.options.onDestroy) this.options.onDestroy();
      this._emit("destroy");
    }

    // =============================================
    // Open / Close
    // =============================================
    _openSubmenu(sub) {
      if (!sub) return;
      const toggle = sub.previousElementSibling;
      sub.classList.remove("tadnav-flip-x", "tadnav-flip-y", "tadnav-flip-x-root", "tadnav-flip-y-root");
      sub.style.removeProperty("max-width");
      // ★ 先清除上次殘留的左側補正，才能取得真實初始位置
      sub.style.removeProperty("margin-left");
      sub.setAttribute("data-open", "true");
      if (toggle?.hasAttribute("aria-expanded"))
        toggle.setAttribute("aria-expanded", "true");

      if (!this._isMobile) {
        // ★ 左側溢出：同步立即修正（在首次 paint 之前執行）
        //   getBoundingClientRect() 強制同步 layout，
        //   確保瀏覽器不會先畫出溢出的狀態再修正。
        //   適用情境：wrap 換行模式下，靠右登入按鈕在第二行靠左，
        //   其子選單以 right:0 對齊 li 右緣，整個面板往左飛出視窗。
        const r = sub.getBoundingClientRect();
        if (r.left < 4) {
          // ★ 修正：is-right 使用 right:0 定位，margin-left 對其無效
          //   （CSS 規格：margin-left 加在 right:0 絕對定位元素上，
          //    不會往右推，反而讓元素往左偏更遠）。
          //   正確做法：切換成 left 定位，讓子選單從 li 左緣展開。
          const parentLi = sub.parentElement;
          if (parentLi?.classList.contains("is-right")) {
            sub.style.setProperty("right", "auto");
            sub.style.setProperty("left", "0");
          } else {
            sub.style.setProperty("margin-left", (4 - r.left) + "px");
          }
        }

        // 桌機版：碰撞偵測（右側 / 下方翻轉）+ 捲動包裝（RAF 異步即可）
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            this._checkSubOverflow(sub);
            if (this.options.collisionDetection) this._detectCollision(sub);
          });
        });
      } else {
        // 手機版：展開後捲動到 toggle 確保可見（WCAG 1.4.10）
        requestAnimationFrame(() => {
          if (toggle) toggle.scrollIntoView({ block: "nearest", behavior: "smooth" });
        });
      }

      // ★ 展開後同步 tabindex 與 aria-hidden
      sub.setAttribute("aria-hidden", "false");
      this._syncSubMenuTabindex();
      const label = toggle?.textContent?.trim() || "子選單";
      this._announce(`${label} 已展開`);
      if (this.options.onOpen) this.options.onOpen(sub, toggle);
      this._emit("open", { submenu: sub, trigger: toggle });
    }

    _closeSubmenu(sub, returnFocus = false) {
      if (!sub) return;
      const toggle = sub.previousElementSibling;

      // 桌機版才需要拆掉捲動包裝
      if (!this._isMobile) this._unwrapSubScroll(sub);

      sub.setAttribute("data-open", "false");
      sub.classList.remove("tadnav-flip-x", "tadnav-flip-y", "tadnav-flip-x-root", "tadnav-flip-y-root");
      sub.style.removeProperty("max-width");
      // ★ 清除左側碰撞補正，確保下次開啟時重新計算
      sub.style.removeProperty("margin-left");
      // ★ 清除 is-right 換行補正（切換成 left 定位的 inline style）
      sub.style.removeProperty("left");
      sub.style.removeProperty("right");

      if (toggle?.hasAttribute("aria-expanded")) {
        toggle.setAttribute("aria-expanded", "false");
        if (returnFocus) toggle.focus();
      }

      // 遞迴關閉所有巢狀子選單
      sub.querySelectorAll('.tadnav-submenu[data-open="true"]')
         .forEach(n => this._closeSubmenu(n));

      // ★ 收合後同步 tabindex 與 aria-hidden
      sub.setAttribute("aria-hidden", "true");
      this._syncSubMenuTabindex();
      const label = toggle?.textContent?.trim() || "子選單";
      this._announce(`${label} 已收合`);
      if (this.options.onClose) this.options.onClose(sub, toggle);
      this._emit("close", { submenu: sub, trigger: toggle });
    }

    /**
     * ★ 手風琴核心：關閉同層（同父 ul）的其他子選單
     * 桌機 hover / click、手機 click 均呼叫此方法
     */
    _closeSiblingSubmenus(sub) {
      const parentLi = sub.parentElement;        // 直屬 li
      if (!parentLi) return;
      const parentUl = parentLi.parentElement;   // 直屬 ul（同層容器）
      if (!parentUl) return;
      // 互斥關閉同層選單時靜音，使用者正在開啟的選單才需要播報
      this._suppressAnnounce = true;
      parentUl.querySelectorAll(':scope > li > .tadnav-submenu[data-open="true"]')
        .forEach(s => { if (s !== sub) this._closeSubmenu(s); });
      this._suppressAnnounce = false;
    }

    // =============================================
    // Tab 順序管理（DOM 層級）
    // =============================================
    /**
     * ★ 核心修正：在 DOM 層級用 tabindex="-1" 管理 Tab 順序。
     *
     * 手機版子選單以 max-height:0 + overflow:hidden 收合，視覺上隱藏，
     * 但 <a>/<button> 元素仍在 DOM 中且原生 tabindex = 0，
     * 瀏覽器 Tab 鍵會照常訪問它們，不管 focus trap 是否啟動。
     *
     * 此方法遍歷選單內全部可聚焦元素：
     *   - 位於 data-open="false" 子選單中 → tabindex="-1"（移出 Tab 順序）
     *   - 其他（頂層或已展開子選單中）   → 移除 tabindex（回復自然順序）
     *
     * 在 _setupARIA、_openSubmenu、_closeSubmenu 三處呼叫，
     * 確保任何展開 / 收合操作後立即同步。
     */
    _syncSubMenuTabindex() {
      this.menu.querySelectorAll(
        'a[href], button.tadnav-submenu-toggle'
      ).forEach(el => {
        const closedParent = el.closest('.tadnav-submenu[data-open="false"]');
        if (closedParent) {
          el.setAttribute('tabindex', '-1');
        } else {
          el.removeAttribute('tabindex');
        }
      });
    }

    // =============================================
    // Focus Trap
    // =============================================
    _getFocusableInMenu() {
      const menuItems = Array.from(
        this.menu.querySelectorAll('a[href], button.tadnav-submenu-toggle')
      ).filter(el => {
        // 手風琴收合中的子選單內項目不可 Tab
        const closedParent = el.closest('.tadnav-submenu[data-open="false"]');
        if (closedParent) return false;
        const rect = el.getBoundingClientRect();
        return rect.width > 0 && rect.height > 0;
      });

      // ★ 漢堡選單展開時，將關閉按鈕（tadnav-toggle）加入 Tab 循環首位。
      //   toggleBtn 位於 <ul> 之外，不在 menuItems 內；若不納入，
      //   鍵盤使用者永遠無法 Tab 到它，違反 WCAG 2.1.1。
      if (
        this.toggleBtn &&
        this.menu.getAttribute("data-mobile-open") === "true"
      ) {
        return [this.toggleBtn, ...menuItems];
      }

      return menuItems;
    }

    _activateFocusTrap() {
      if (this._focusTrapHandler) return;
      this._focusTrapHandler = (e) => {
        if (e.key !== "Tab") return;
        const focusable = this._getFocusableInMenu();
        if (focusable.length === 0) return;
        const first  = focusable[0];
        const last   = focusable[focusable.length - 1];
        const active = document.activeElement;

        // ★ 手機版：完全接管 Tab 焦點順序。
        //   手機版子選單收合採 max-height:0 + overflow:hidden，
        //   視覺上隱藏但 DOM 元素仍可被瀏覽器原生 Tab 鍵訪問，
        //   因此必須攔截所有 Tab 事件，只在 _getFocusableInMenu()
        //   回傳的可見項目間循環，防止焦點落入隱形項目或逃逸選單。
        // ★ 改用 data-mobile-open 判斷（而非 _isMobile）：
        //   瀏覽器縮放 200-400% 時 window.innerWidth 可能仍大於 breakpoint，
        //   使 _isMobile 為 false，但漢堡選單已展開，仍須接管全部 Tab。
        if (this.menu.getAttribute("data-mobile-open") === "true") {
          e.preventDefault();
          const idx = focusable.indexOf(active);
          if (e.shiftKey) {
            // Shift+Tab：往前循環（找不到則跳到最後一項）
            const prev = idx <= 0 ? last : focusable[idx - 1];
            prev.focus();
          } else {
            // Tab：往後循環（找不到或已是最後一項則跳回第一項）
            const next = (idx === -1 || idx >= focusable.length - 1) ? first : focusable[idx + 1];
            next.focus();
          }
          return;
        }

        // 桌機版（理論上不應啟用 trap，保留作為備援）
        if (e.shiftKey) {
          if (active === first || !this.menu.contains(active)) { e.preventDefault(); last.focus(); }
        } else {
          if (active === last  || !this.menu.contains(active)) { e.preventDefault(); first.focus(); }
        }
      };
      document.addEventListener("keydown", this._focusTrapHandler, true);
    }

    _deactivateFocusTrap() {
      if (this._focusTrapHandler) {
        document.removeEventListener("keydown", this._focusTrapHandler, true);
        this._focusTrapHandler = null;
      }
    }

    // =============================================
    // Close Mobile Menu
    // =============================================
    _closeMobileMenu() {
      if (!this.toggleBtn) return;
      if (this.toggleBtn.getAttribute("aria-expanded") !== "true") return;
      this.toggleBtn.setAttribute("aria-expanded", "false");
      // ★ 不更動 aria-label（理由同 _handleToggle）
      this.menu.setAttribute("data-mobile-open", "false");
      this.closeAll();
      this._deactivateFocusTrap();
      this.toggleBtn.focus();
      this._announce("選單已收合");
    }

    // =============================================
    // Collision Detection（桌機版）
    // =============================================
    _detectCollision(sub) {
      if (!sub || this._isMobile) return;

      // ★ 先重設左側偏移補正，再取得最新位置
      sub.style.removeProperty("margin-left");

      const rect = sub.getBoundingClientRect();
      const vw   = window.innerWidth;
      const vh   = window.innerHeight;
      const isRootLevel = sub.parentElement?.parentElement === this.menu;

      // 水平右側翻轉
      if (rect.right > vw - 4)
        sub.classList.add(isRootLevel ? "tadnav-flip-x-root" : "tadnav-flip-x");

      // ★ 左側溢出修正：
      //   wrap 換行模式下，is-right 子選單以 right:0 對齊 li 右邊緣，
      //   但 li 在第二行靠左時，子選單可能超出視窗左側。
      //   ★ 修正：is-right 使用 right:0 定位，margin-left 無效，
      //   改為切換成 left:0 定位，讓子選單從 li 左緣展開。
      const rect2 = sub.getBoundingClientRect(); // 翻轉後重新取得
      if (rect2.left < 4) {
        const parentLi = sub.parentElement;
        if (parentLi?.classList.contains("is-right")) {
          sub.style.setProperty("right", "auto");
          sub.style.setProperty("left", "0");
        } else {
          const shift = 4 - rect2.left;
          sub.style.setProperty("margin-left", shift + "px");
        }
      }

      // 垂直翻轉
      if (rect.bottom > vh - 4)
        sub.classList.add(isRootLevel ? "tadnav-flip-y-root" : "tadnav-flip-y");

      // 巢狀子選單遞迴偵測
      sub.querySelectorAll(':scope > li > .tadnav-submenu[data-open="true"]')
        .forEach(child => this._detectCollision(child));
    }

    // =============================================
    // Keyboard Navigation
    // =============================================
    _handleKeydown(e) {
      const target = e.target;
      const key    = e.key;

      // ESC：關閉最近的開啟子選單，或收合手機選單
      if (key === "Escape" && this.options.closeOnEsc) {
        const openSub = target.closest('.tadnav-submenu[data-open="true"]');
        if (openSub) {
          this._closeSubmenu(openSub, true);
        } else {
          const topSub = target.closest('.tadnav-menu > li > .tadnav-submenu[data-open="true"]');
          if (topSub) {
            this._closeSubmenu(topSub, true);
          } else if (this.menu.getAttribute("data-mobile-open") === "true") {
            // ★ 改用 data-mobile-open（而非 _isMobile），確保 200-400% 縮放下 ESC 有效
            this._closeMobileMenu();
          } else {
            this.closeAll();
          }
        }
        e.preventDefault();
        return;
      }

      if (!this._isMobile) {
        this._handleDesktopKeydown(e, target, key);
      } else {
        this._handleMobileKeydown(e, target, key);
      }
    }

    _handleDesktopKeydown(e, target, key) {
      const li     = target.closest("li");
      const sub    = li?.querySelector(":scope > .tadnav-submenu");
      const inSub  = !!target.closest(".tadnav-submenu");
      const isRoot = li?.parentElement === this.menu;

      // 頂層：左右鍵切換項目
      if (!inSub && isRoot) {
        if (key === "ArrowRight" || key === "ArrowLeft") {
          e.preventDefault();
          const items = Array.from(
            this.menu.querySelectorAll(
              ":scope > li > a[href], :scope > li > button.tadnav-submenu-toggle"
            )
          );
          const idx  = items.indexOf(target);
          const next = key === "ArrowRight"
            ? items[(idx + 1) % items.length]
            : items[(idx - 1 + items.length) % items.length];
          next?.focus();
        }
        // 下鍵：進入子選單
        if (key === "ArrowDown" && sub) {
          e.preventDefault();
          this._openSubmenu(sub);
          setTimeout(() => sub.querySelector('a[href], button.tadnav-submenu-toggle')?.focus(), 50);
        }
      } else if (inSub) {
        // 子選單內：上下鍵切換
        if (key === "ArrowDown" || key === "ArrowUp") {
          e.preventDefault();
          const parentSub = target.closest(".tadnav-submenu");
          const items = Array.from(
            parentSub.querySelectorAll(
              ':scope > li:not(.tadnav-scroll-btn):not([style*="display: none"]) > a[href], ' +
              ':scope > li:not(.tadnav-scroll-btn):not([style*="display: none"]) > button.tadnav-submenu-toggle'
            )
          );
          const idx  = items.indexOf(target);
          const next = key === "ArrowDown"
            ? items[(idx + 1) % items.length]
            : items[(idx - 1 + items.length) % items.length];
          next?.focus();
        }
        // 右鍵：展開巢狀子選單
        if (key === "ArrowRight" && sub) {
          e.preventDefault();
          this._openSubmenu(sub);
          setTimeout(() => sub.querySelector('a[href], button.tadnav-submenu-toggle')?.focus(), 50);
        }
        // 左鍵：收合並回到父層
        if (key === "ArrowLeft") {
          e.preventDefault();
          const parentSub = target.closest(".tadnav-submenu");
          if (parentSub) this._closeSubmenu(parentSub, true);
        }
      }

      // Home / End
      if (key === "Home" || key === "End") {
        e.preventDefault();
        const parentSub = target.closest(".tadnav-submenu");
        const container = parentSub || this.menu;
        const items = Array.from(
          container.querySelectorAll(
            ':scope > li:not(.tadnav-scroll-btn) > a[href], ' +
            ':scope > li:not(.tadnav-scroll-btn) > button.tadnav-submenu-toggle'
          )
        );
        if (key === "Home") items[0]?.focus();
        else items[items.length - 1]?.focus();
      }
    }

    _handleMobileKeydown(e, target, key) {
      // 手機模式：上下鍵在可見項目間移動
      if (key === "ArrowDown" || key === "ArrowUp") {
        e.preventDefault();
        const allItems = this._getFocusableInMenu();
        const idx  = allItems.indexOf(target);
        const next = key === "ArrowDown"
          ? allItems[(idx + 1) % allItems.length]
          : allItems[(idx - 1 + allItems.length) % allItems.length];
        next?.focus();
      }
    }

    // =============================================
    // Breakpoint
    // =============================================
    _checkBreakpoint() {
      const wasMobile = this._isMobile;
      this._isMobile  = window.innerWidth < this.options.breakpoint;

      if (wasMobile !== this._isMobile) {
        // 切換模式時關閉所有子選單並清除捲動包裝
        this.closeAll();
        this._scrollStates.forEach((_, sub) => this._unwrapSubScroll(sub));

        if (!this._isMobile) {
          // 切回桌機：重設手機選單狀態
          this.menu.setAttribute("data-mobile-open", "false");
          if (this.toggleBtn) {
            this.toggleBtn.setAttribute("aria-expanded", "false");
            // ★ 不更動 aria-label（理由同 _handleToggle）
          }
          this._deactivateFocusTrap();
        }

        if (this.options.onBreakpointChange)
          this.options.onBreakpointChange(this._isMobile);
        this._emit("breakpointChange", { isMobile: this._isMobile });
      }
    }

    // =============================================
    // Global Listeners（點擊外部關閉）
    // =============================================
    static _attachGlobalListeners() {
      TadNav._globalListenersAttached = true;

      document.addEventListener("click", e => {
        const skipLink = e.target.closest("#xoops_theme_nav_key");
        if (skipLink) {
          e.preventDefault();
          const firstItem = document.querySelector("#main-menu a[href], #main-menu button.tadnav-submenu-toggle");
          firstItem?.focus();
          firstItem?.scrollIntoView({ block: "nearest", inline: "nearest" });
          return;
        }
        TadNav._instances.forEach(inst => {
          if (!inst.options.closeOnOutsideClick) return;
          if (!inst.menu.contains(e.target) && !inst.toggleBtn?.contains(e.target)) {
            inst.closeAll();
          }
        });
      });

      document.addEventListener("keydown", e => {
        if (e.key === "Escape") {
          TadNav._instances.forEach(inst => {
            // ★ 改判斷選單是否實際開啟（data-mobile-open），
            //   而非 _isMobile：瀏覽器縮放 200-400% 時 window.innerWidth
            //   可能仍大於 breakpoint，使 _isMobile 為 false，
            //   但漢堡選單仍可見，ESC 應能關閉。
            if (inst.options.closeOnEsc &&
                inst.menu.getAttribute("data-mobile-open") === "true") {
              inst._closeMobileMenu();
            }
          });
        }
      });
    }

    // =============================================
    // Custom Events
    // =============================================
    on(eventName, callback) {
      if (!this._customListeners[eventName])
        this._customListeners[eventName] = [];
      this._customListeners[eventName].push(callback);
      return this;
    }

    off(eventName, callback) {
      if (!this._customListeners[eventName]) return this;
      this._customListeners[eventName] =
        this._customListeners[eventName].filter(fn => fn !== callback);
      return this;
    }

    _emit(eventName, data = {}) {
      const listeners = this._customListeners[eventName];
      if (listeners) listeners.forEach(fn => fn(data));
    }
  }

  return TadNav;
});