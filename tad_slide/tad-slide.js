/*!
 * tad-slide.js v1.1.0
 * WCAG 2.3 AAA Compliant Responsive Carousel
 * navMode: 'bottom' | 'sides' | 'none'
 */
(function (global) {
  'use strict';

  /* ============================================
     預設選項
     ============================================ */
  const DEFAULTS = {
    auto: true,
    speed: 600,
    timeout: 4000,
    effect: 'fade',
    random: false,
    pauseOnHover: true,
    announceSlide: true,

    /*
     * navMode 導覽模式（三選一）
     *   'bottom' → 下方控制列（含分頁點、上下張、暫停）
     *   'sides'  → 左右浮動箭頭 + 右下角暫停按鈕
     *   'none'   → 僅右下角暫停按鈕
     */
    navMode: 'bottom',

    /* bottom 模式專屬 */
    pager: true,
    nav: true,

    /* 文字標籤 */
    prevText: '',   // sides 模式由 CSS SVG 背景圖顯示；bottom 模式可自訂
    nextText: '',   // sides 模式由 CSS SVG 背景圖顯示；bottom 模式可自訂
    pauseText: '⏸',
    playText: '▶',
    pauseLabel: '暫停輪播',
    playLabel: '播放輪播',
    prevLabel: '上一張投影片',
    nextLabel: '下一張投影片',

    /* 回呼 */
    before: null,
    after: null,
  };

  /* ============================================
     主類別
     ============================================ */
  class TadSlide {
    constructor(element, options) {
      this.el = element;
      this.opts = Object.assign({}, DEFAULTS, options);
      this.items = [];
      this.current = 0;
      this.total = 0;
      this.timer = null;
      this.running = false;
      this.paused = false;
      this._isManual = false;
      this._isHovered = false;
      this._isFocused = false;

      this._init();
    }

    /* ────────────────────────────────────────
       初始化
       ──────────────────────────────────────── */
    _init() {
      const el = this.el;
      const opts = this.opts;

      this.items = Array.from(el.querySelectorAll('.tad-slide__item'));
      this.total = this.items.length;

      /* ── 單張投影片：套用 single 模式後直接結束 ── */
      if (this.total < 2) {
        this._initSingle();
        return;
      }

      if (opts.random) this._shuffle();

      /* 過場特效 & 速度 */
      el.setAttribute('data-tad-effect', opts.effect);
      this.items.forEach(item => {
        item.style.transitionDuration = opts.speed + 'ms';
      });

      /* 容器 ARIA */
      el.setAttribute('role', 'region');
      el.setAttribute('aria-roledescription', 'carousel');
      if (!el.getAttribute('aria-label') && this.total > 1) {
        el.setAttribute('aria-label', '圖片輪播');
      }

      /* 投影片 ARIA */
      this.items.forEach((item, i) => {
        item.setAttribute('role', 'group');
        item.setAttribute('aria-roledescription', 'slide');
        item.setAttribute('aria-label', `第 ${i + 1} 張，共 ${this.total} 張`);
        item.setAttribute('aria-hidden', i === 0 ? 'false' : 'true');
        /* 投影片容器本身不進入 Tab 順序，避免焦點停留兩次
           （實際焦點由內部的 <a> 或 <img> 承接） */
        item.setAttribute('tabindex', '-1');
        if (i === 0) item.classList.add('is-active');
      });

      /* 套用導覽模式 class */
      el.classList.add(`tad-slide--nav-${opts.navMode}`);

      /* 建立各元件 */
      this._buildProgress();
      this._buildNav();
      this._updateNavLabels(0);
      if (opts.announceSlide) this._buildLiveRegion();

      /* 事件 */
      if (opts.pauseOnHover) {
        el.addEventListener('mouseenter', () => { this._isHovered = true; this._updateInteractionPause(); });
        el.addEventListener('mouseleave', () => { this._isHovered = false; this._updateInteractionPause(); });
      }

      /* 鍵盤聚焦時暫停輪播 */
      el.addEventListener('focusin', () => { this._isFocused = true; this._updateInteractionPause(); });
      el.addEventListener('focusout', (e) => {
        if (!this.el.contains(e.relatedTarget)) {
          this._isFocused = false;
          this._updateInteractionPause();
        }
      });
      el.addEventListener('keydown', e => this._onKeydown(e));
      this._initTouch();

      if (opts.auto) this.play();
    }

    /* ────────────────────────────────────────
   單張投影片處理
   ──────────────────────────────────────── */
    _initSingle() {
      const el = this.el;

      /* 套用 single class，CSS 負責隱藏所有控制元件 */
      el.classList.add('tad-slide--single');

      /* 設定容器 ARIA（仍保留語意，但標示為靜態） */
      el.setAttribute('role', 'region');
      // if (!el.getAttribute('aria-label')) {
      //   el.setAttribute('aria-label', '圖片展示');
      // }

      /* 移除 <ul>/<li> 的清單語意，避免螢幕閱讀器朗讀「清單有一項」。
         role="none" 讓元素保留視覺結構，但不產生任何 ARIA 角色語意。 */
      const list = el.querySelector('.tad-slide__list');
      if (list) list.setAttribute('role', 'none');

      /* 確保唯一一張投影片正確顯示，同時移除 <li> 的清單項目語意 */
      if (this.items[0]) {
        this.items[0].setAttribute('role', 'none');
        this.items[0].classList.add('is-active');
        this.items[0].setAttribute('aria-hidden', 'false');
      }
    }

    /* ────────────────────────────────────────
       建立導覽（依 navMode 分流）
       ──────────────────────────────────────── */
    _buildNav() {
      switch (this.opts.navMode) {
        case 'bottom': this._buildNavBottom(); break;
        case 'sides': this._buildNavSides(); break;
        case 'none': this._buildNavNone(); break;
      }
    }

    /* ── 模式 A：bottom ── */
    _buildNavBottom() {
      const opts = this.opts;

      /* ── 暫停按鈕：獨立插入容器最頂部，焦點第一順位 ── */
      this._pauseBtn = this._makeBtn(opts.pauseText, 'tad-slide__btn tad-slide__pause', opts.pauseLabel);
      this._pauseBtn.setAttribute('data-playing', 'true');
      this._pauseBtn.addEventListener('click', () => this._togglePause());
      this.el.insertBefore(this._pauseBtn, this.el.firstChild);

      /* ── 下方控制列（進度條之後插入）：上一張 → 下一張 → 分頁點 ── */
      const bar = document.createElement('div');
      bar.className = 'tad-slide__controls-bar';

      /* 上一張 */
      if (opts.nav) {
        this._prevBtn = this._makeBtn(opts.prevText, 'tad-slide__btn tad-slide__arrow--prev', opts.prevLabel);
        this._prevBtn.addEventListener('click', () => this.prev(true));
        bar.appendChild(this._prevBtn);
      }

      /* 下一張 */
      if (opts.nav) {
        this._nextBtn = this._makeBtn(opts.nextText, 'tad-slide__btn tad-slide__arrow--next', opts.nextLabel);
        this._nextBtn.addEventListener('click', () => this.next(true));
        bar.appendChild(this._nextBtn);
      }

      /* 分頁點（最後） */
      if (opts.pager) {
        const pagerList = document.createElement('ul');
        pagerList.className = 'tad-slide__pager';
        pagerList.setAttribute('role', 'tablist');
        pagerList.setAttribute('aria-label', '投影片選擇');

        this._pagerBtns = this.items.map((_, i) => {
          const li = document.createElement('li');
          li.setAttribute('role', 'presentation');
          const btn = this._makeBtn('', 'tad-slide__pager-btn', `第 ${i + 1} 張投影片`);
          btn.setAttribute('role', 'tab');
          btn.setAttribute('aria-current', i === 0 ? 'true' : 'false');
          btn.addEventListener('click', () => {
            this._isManual = true;
            this.goTo(i);
            this.items[i].focus({ preventScroll: true });
          });
          li.appendChild(btn);
          pagerList.appendChild(li);
          return btn;
        });
        bar.appendChild(pagerList);
      }

      this.el.appendChild(bar);
      this._bar = bar;
    }

    /* ── 模式 B：sides ── */
    _buildNavSides() {
      const opts = this.opts;
      const list = this.el.querySelector('.tad-slide__list');

      /*
       * 暫停／播放按鈕：插入至投影片清單之前（DOM 第一個可聚焦元素）
       * 焦點順序：暫停 → 圖片 → 左箭頭 → 右箭頭
       * position: absolute 不影響視覺版面
       */
      this._pauseBtn = this._makeBtn(opts.pauseText, 'tad-slide__btn tad-slide__pause-float', opts.pauseLabel);
      this._pauseBtn.setAttribute('data-playing', 'true');
      this._pauseBtn.addEventListener('click', () => this._togglePause());
      this.el.insertBefore(this._pauseBtn, list);

      /* 左箭頭（圖片之後） */
      this._prevBtn = this._makeBtn(opts.prevText, 'tad-slide__btn tad-slide__arrow tad-slide__arrow--prev', opts.prevLabel);
      this._prevBtn.addEventListener('click', () => this.prev(true));
      this.el.appendChild(this._prevBtn);

      /* 右箭頭（左箭頭之後） */
      this._nextBtn = this._makeBtn(opts.nextText, 'tad-slide__btn tad-slide__arrow tad-slide__arrow--next', opts.nextLabel);
      this._nextBtn.addEventListener('click', () => this.next(true));
      this.el.appendChild(this._nextBtn);
    }

    /* ── 模式 C：none ── */
    _buildNavNone() {
      const opts = this.opts;
      const list = this.el.querySelector('.tad-slide__list');

      /*
       * 暫停／播放按鈕：插入至投影片清單之前（DOM 第一個可聚焦元素）
       * 焦點順序：暫停 → 圖片
       * position: absolute 不影響視覺版面
       */
      this._pauseBtn = this._makeBtn(opts.pauseText, 'tad-slide__btn tad-slide__pause-float', opts.pauseLabel);
      this._pauseBtn.setAttribute('data-playing', 'true');
      this._pauseBtn.addEventListener('click', () => this._togglePause());
      this.el.insertBefore(this._pauseBtn, list);
    }

    /* ────────────────────────────────────────
       進度條
       ──────────────────────────────────────── */
    _buildProgress() {
      this._progressBar = document.createElement('div');
      this._progressBar.className = 'tad-slide__progress';
      this._progressBar.setAttribute('aria-hidden', 'true');
      this.el.insertBefore(this._progressBar, this.el.firstChild);
    }

    _startProgress() {
      if (!this._progressBar) return;
      const bar = this._progressBar;
      const duration = this.opts.timeout;
      bar.style.transitionDuration = '0ms';
      bar.style.width = '0%';
      void bar.offsetWidth;
      bar.style.transitionDuration = duration + 'ms';
      bar.style.width = '100%';
    }

    _stopProgress() {
      if (!this._progressBar) return;
      const bar = this._progressBar;
      const w = getComputedStyle(bar).width;
      bar.style.transitionDuration = '0ms';
      bar.style.width = w;
    }

    /* ────────────────────────────────────────
      Live Region
      ──────────────────────────────────────── */
    _buildLiveRegion() {
      this._liveRegion = document.createElement('div');
      this._liveRegion.className = 'tad-sr-only';
      this._liveRegion.setAttribute('aria-live', 'polite');
      this._liveRegion.setAttribute('aria-atomic', 'true');
      this.el.appendChild(this._liveRegion);
    }

    /* ────────────────────────────────────────
       切換投影片
       ──────────────────────────────────────── */
    goTo(index) {
      if (index === this.current || this.running) return;

      const opts = this.opts;
      const prev = this.current;
      const next = (index + this.total) % this.total;

      if (typeof opts.before === 'function') opts.before(prev, next);

      this.running = true;
      this.current = next;

      const prevItem = this.items[prev];
      const nextItem = this.items[next];

      prevItem.setAttribute('aria-hidden', 'true');
      /* 投影片容器本身不進入 Tab 順序，保持 -1 */
      prevItem.setAttribute('tabindex', '-1');
      nextItem.setAttribute('aria-hidden', 'false');
      nextItem.setAttribute('tabindex', '-1');

      prevItem.classList.add('is-prev');
      prevItem.classList.remove('is-active');
      nextItem.classList.add('is-active');

      /* 更新分頁點 */
      if (this._pagerBtns) {
        this._pagerBtns[prev].setAttribute('aria-current', 'false');
        this._pagerBtns[next].setAttribute('aria-current', 'true');
      }

      /* 通知螢幕閱讀器（手動操作時，主動播報切換後的圖片資訊）
         除了說明文字（caption），也優先抓取圖片 alt 或連結的標籤，
         確保使用者切換上一張/下一張時能聽見圖片資訊。 */
      if (this._liveRegion && this._isManual) {
        let msg = '';

        const img = nextItem.querySelector('img');
        if (img && img.getAttribute('alt')) {
          msg = img.getAttribute('alt').trim();
        } else {
          const link = nextItem.querySelector('a');
          if (link) {
            msg = (link.getAttribute('title') || link.getAttribute('aria-label') || '').trim();
          }
        }

        const caption = nextItem.querySelector('.tad-slide__caption');
        const captionText = caption ? caption.textContent.trim() : '';

        if (captionText && captionText !== msg) {
          msg = msg ? msg + '，' + captionText : captionText;
        }

        this._liveRegion.textContent = '';
        if (msg) {
          setTimeout(() => { this._liveRegion.textContent = msg; }, 50);
        }
      }
      this._isManual = false;

      /* 動態更新上一張 / 下一張按鈕的 aria-label */
      this._updateNavLabels(next);

      setTimeout(() => {
        prevItem.classList.remove('is-prev');
        this.running = false;
        if (typeof opts.after === 'function') opts.after(prev, next);
        if (!this.paused && opts.auto) this._startProgress();
      }, opts.speed + 50);
    }

    next(manual = false) { if (manual) this._isManual = true; this.goTo(this.current + 1); }
    prev(manual = false) { if (manual) this._isManual = true; this.goTo(this.current - 1); }

    /* 取得指定索引投影片的最佳描述文字。
       優先順序：圖片 alt → 連結 title/aria-label → caption 文字。
       供 _updateNavLabels 組合上一張/下一張的 aria-label 使用。
       @param {number} index 投影片索引
       @returns {string} 描述文字（可能為空字串）
    */
    _getSlideLabel(index) {
      const item = this.items[index];
      if (!item) return '';

      // ① 圖片 alt（最具描述性）
      const img = item.querySelector('img');
      if (img) {
        const alt = (img.getAttribute('alt') || '').trim();
        if (alt) return alt;
      }

      // ② 連結的 title 或 aria-label
      const link = item.querySelector('a');
      if (link) {
        const label = (
          link.getAttribute('aria-label') ||
          link.getAttribute('title') || ''
        ).trim();
        if (label) return label;
      }

      // ③ caption 說明文字
      const caption = item.querySelector('.tad-slide__caption');
      if (caption) {
        const text = caption.textContent.trim();
        if (text) return text;
      }

      return '';
    }

    /* 更新上一張 / 下一張按鈕的 aria-label。
       僅保留簡潔的方向語意（如「上一張投影片」/「下一張投影片」），
       不附加目標投影片的圖片描述，避免螢幕閱讀器在聚焦按鈕時
       就預先朗讀圖片內容，造成使用者觸發按鈕後聽到兩次相同資訊的混淆。
       圖片資訊只在切換完成後透過 live region 播報一次。 */
    _updateNavLabels(current) {
      if (this._prevBtn) {
        this._prevBtn.setAttribute('aria-label', this.opts.prevLabel);
      }
      if (this._nextBtn) {
        this._nextBtn.setAttribute('aria-label', this.opts.nextLabel);
      }
    }

    /* ────────────────────────────────────────
       播放 / 暫停
       ──────────────────────────────────────── */
    play() {
      if (this.timer) clearInterval(this.timer);
      this.paused = false;
      this.el.classList.remove('tad-slide--paused');
      this.timer = setInterval(() => this.next(), this.opts.timeout);
      this._startProgress();
      this._updatePauseBtn();
    }

    pause() {
      if (this.timer) clearInterval(this.timer);
      this.timer = null;
      this.paused = true;
      this.el.classList.add('tad-slide--paused');
      this._stopProgress();
      this._updatePauseBtn();
    }

    _togglePause() {
      this.paused ? this.play() : this.pause();
    }

    _updatePauseBtn() {
      if (!this._pauseBtn) return;
      const opts = this.opts;
      if (this.paused) {
        this._pauseBtn.setAttribute('data-playing', 'false');
        this._pauseBtn.setAttribute('aria-label', opts.playLabel);
        this._pauseBtn.innerHTML = opts.playText;
      } else {
        this._pauseBtn.setAttribute('data-playing', 'true');
        this._pauseBtn.setAttribute('aria-label', opts.pauseLabel);
        this._pauseBtn.innerHTML = opts.pauseText;
      }
    }

    _updateInteractionPause() {
      if (!this.opts.auto) return;
      if (this._isHovered || this._isFocused) {
        if (this.timer) clearInterval(this.timer);
        this._stopProgress();
      } else {
        if (!this.paused) this.play();
      }
    }

    /* ────────────────────────────────────────
       鍵盤操作（WCAG 2.1.1）
       ──────────────────────────────────────── */
    _onKeydown(e) {
      /* 若焦點在暫停按鈕上，Space/Enter 交由瀏覽器預設處理 */
      const onPauseBtn = document.activeElement === this._pauseBtn;

      switch (e.key) {
        case 'ArrowLeft':
        case 'ArrowUp':
          e.preventDefault();
          this.prev(true);
          break;
        case 'ArrowRight':
        case 'ArrowDown':
          e.preventDefault();
          this.next(true);
          break;
        case ' ':
          if (onPauseBtn) break;
          e.preventDefault();
          this._togglePause();
          break;
        case 'Home':
          e.preventDefault();
          this.goTo(0);
          break;
        case 'End':
          e.preventDefault();
          this.goTo(this.total - 1);
          break;
      }
    }

    /* ────────────────────────────────────────
       觸控滑動
       ──────────────────────────────────────── */
    _initTouch() {
      let startX = 0, startY = 0;
      const threshold = 50;
      this.el.addEventListener('touchstart', e => {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
      }, { passive: true });
      this.el.addEventListener('touchend', e => {
        const dx = e.changedTouches[0].clientX - startX;
        const dy = e.changedTouches[0].clientY - startY;
        if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > threshold) {
          dx < 0 ? this.next(true) : this.prev(true);
        }
      }, { passive: true });
    }

    /* ────────────────────────────────────────
       工具
       ──────────────────────────────────────── */
    _makeBtn(html, className, ariaLabel) {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = className;
      btn.innerHTML = html;
      if (ariaLabel) btn.setAttribute('aria-label', ariaLabel);
      return btn;
    }

    _shuffle() {
      const list = this.el.querySelector('.tad-slide__list');
      for (let i = this.items.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        list.appendChild(this.items[j]);
      }
      this.items = Array.from(list.querySelectorAll('.tad-slide__item'));
    }

    /* ────────────────────────────────────────
       銷毀
       ──────────────────────────────────────── */
    destroy() {
      this.pause();
      [this._bar, this._prevBtn, this._nextBtn, this._pauseBtn,
      this._progressBar, this._liveRegion].forEach(el => el?.remove());
      if (this._pagerBtns) this._pagerBtns.forEach(b => b.closest('li')?.remove());
      this.items.forEach(item => {
        item.classList.remove('is-active', 'is-prev');
        ['aria-hidden', 'role', 'aria-roledescription', 'aria-label', 'tabindex']
          .forEach(a => item.removeAttribute(a));
      });
      /* 清除 single 模式對 <ul> 設置的 role="none" */
      const list = this.el.querySelector('.tad-slide__list');
      if (list) list.removeAttribute('role');
      this.el.classList.remove(
        `tad-slide--nav-${this.opts.navMode}`,
        'tad-slide--single',
        'tad-slide--paused'
      );
    }
  } // end class TadSlide

  /* ============================================
     工廠函式
     ============================================ */
  function tadSlide(selector, options) {
    const els = typeof selector === 'string'
      ? Array.from(document.querySelectorAll(selector))
      : [selector];
    const instances = els.map(el => new TadSlide(el, options));
    return instances.length === 1 ? instances[0] : instances;
  }

  global.tadSlide = tadSlide;
  global.TadSlide = TadSlide;

})(typeof window !== 'undefined' ? window : this);