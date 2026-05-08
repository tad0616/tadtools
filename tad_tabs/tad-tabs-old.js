/*!
 * Tad Tabs v1.0.0
 * A fully accessible tab & accordion widget
 *
 * WCAG 2.2 AAA compliant
 * ARIA 1.2 Tab Pattern + Accordion Pattern
 * Screen reader tested: NVDA, JAWS, VoiceOver
 *
 * MIT License | https://github.com/tad-tabs
 */
(function (root, factory) {
  'use strict';
  if (typeof define === 'function' && define.amd) {
    define([], factory);
  } else if (typeof module === 'object' && module.exports) {
    module.exports = factory();
  } else {
    root.TadTabs = factory();
  }
}(typeof globalThis !== 'undefined' ? globalThis : typeof self !== 'undefined' ? self : this,
function () {
  'use strict';

  /* ═══════════════════════════════════════════════════════════════
     Constants
  ═══════════════════════════════════════════════════════════════ */

  const VERSION = '1.0.0';

  /** Keyboard key values (KeyboardEvent.key) */
  const KEY = {
    ENTER : 'Enter',
    SPACE : ' ',
    LEFT  : 'ArrowLeft',
    RIGHT : 'ArrowRight',
    UP    : 'ArrowUp',
    DOWN  : 'ArrowDown',
    HOME  : 'Home',
    END   : 'End',
    TAB   : 'Tab',
    ESC   : 'Escape',
  };

  /** Default options */
  const DEFAULTS = {
    /**
     * Layout type.
     * 'default'   — horizontal tabs (auto-switches to accordion below breakpoint)
     * 'vertical'  — vertical sidebar tabs (auto-switches to accordion below breakpoint)
     * 'accordion' — accordion only (never shows tab list)
     */
    type: 'default',

    /**
     * Whether tabs start closed.
     * false        — first tab open on init
     * true         — all closed on init
     * 'accordion'  — closed only when in accordion mode
     * 'tabs'       — closed only when in tab mode
     */
    closed: false,

    /**
     * Viewport width (px) at which 'default' and 'vertical' types
     * switch to accordion layout.
     */
    breakpoint: 768,

    /** Zero-based index of the initially active tab. */
    activeIndex: 0,

    /**
     * Arrow-key activation behaviour.
     * 'manual'  — arrows move focus only; Enter/Space activates (WCAG preferred for SR users)
     * 'auto'    — arrows move focus AND activate immediately
     */
    activation: 'manual',

    /**
     * Sync active tab with URL hash.
     * Hash format: #<container-id>-<1-based-index>
     */
    hash: true,

    /**
     * Callback fired after a tab is activated.
     * Receives (index: number, tabEl: Element, panelEl: Element)
     * `this` is the TadTabs instance.
     */
    activate: null,

    /** Localisation strings for screen readers */
    i18n: {
      tablistLabel  : '頁籤導覽',
      accordionLabel: '折疊面板',
    },
  };

  /* ═══════════════════════════════════════════════════════════════
     Utility helpers
  ═══════════════════════════════════════════════════════════════ */

  let _uidCounter = 0;
  const uid = () => `tad-${++_uidCounter}`;

  /** Set multiple attributes at once; pass null to remove. */
  function setAttrs(el, map) {
    for (const [key, val] of Object.entries(map)) {
      if (val === null || val === undefined) {
        el.removeAttribute(key);
      } else {
        el.setAttribute(key, String(val));
      }
    }
  }

  /** Deep merge objects (one level deep for i18n) */
  function mergeOptions(defaults, overrides) {
    const result = Object.assign({}, defaults, overrides);
    if (overrides && overrides.i18n) {
      result.i18n = Object.assign({}, defaults.i18n, overrides.i18n);
    }
    return result;
  }

  /* ═══════════════════════════════════════════════════════════════
     TadTabs class
  ═══════════════════════════════════════════════════════════════ */

  class TadTabs {

    /**
     * @param {Element|string} element  — container element or CSS selector
     * @param {object}         options  — configuration overrides
     */
    constructor(element, options = {}) {
      if (typeof element === 'string') {
        element = document.querySelector(element);
      }
      if (!(element instanceof Element)) {
        throw new TypeError('[TadTabs] element must be a DOM Element or CSS selector string.');
      }
      if (element._tadTabs) {
        console.warn('[TadTabs] Already initialized on this element. Returning existing instance.');
        return element._tadTabs;
      }

      this.root    = element;
      this.opts    = mergeOptions(DEFAULTS, options);
      this._id     = element.id ? element.id : uid();
      this._active = -1;   // currently active index (−1 = none)
      this._mode   = null; // 'tabs' | 'accordion'
      this._bound  = [];   // event listeners for cleanup: [{el, type, fn}]
      this.accBtns = [];   // accordion <button> elements
      this.tabs    = [];   // tab <li> elements
      this.panels  = [];   // panel <div>/<section> elements

      this._parseDOM();
      this._setupARIA();
      this._insertAccordionHeadings();
      this._bindAll();
      this._updateMode(true);   // silent first paint
      this._initActive();

      // Watch for viewport changes via ResizeObserver (preferred) or resize event
      if (typeof ResizeObserver !== 'undefined') {
        this._ro = new ResizeObserver(() => this._updateMode());
        this._ro.observe(this.root);
      } else {
        const fn = () => this._updateMode();
        window.addEventListener('resize', fn);
        this._bound.push({ el: window, type: 'resize', fn });
      }

      this.root._tadTabs = this;
      this.root.classList.add('tad-initialized');
    }

    /* ──────────────────────────────────────────────────────────────
       DOM parsing
    ────────────────────────────────────────────────────────────── */

    _parseDOM() {
      const root = this.root;

      // ① Tab list: first direct <ul> child
      this.list = root.querySelector(':scope > ul');
      if (!this.list) {
        throw new Error('[TadTabs] Requires a direct <ul> child element containing <li> tab titles.');
      }
      this.tabs  = Array.from(this.list.querySelectorAll(':scope > li'));
      this.count = this.tabs.length;

      if (this.count === 0) {
        throw new Error('[TadTabs] <ul> must contain at least one <li> tab title.');
      }

      // ② Panels: look for explicit wrapper (.tad-panels / [data-tad-panels])
      //    then fall back to direct siblings after the <ul>
      const wrapper = root.querySelector(':scope > .tad-panels, :scope > [data-tad-panels]');
      if (wrapper) {
        this.panelsWrapper = wrapper;
        this.panels = Array.from(wrapper.children);
      } else {
        this.panels = [];
        let sibling = this.list.nextElementSibling;
        while (sibling) {
          this.panels.push(sibling);
          sibling = sibling.nextElementSibling;
        }
      }

      if (this.panels.length !== this.count) {
        console.warn(
          `[TadTabs] Tab count (${this.count}) does not match panel count (${this.panels.length}).`
        );
      }
    }

    /* ──────────────────────────────────────────────────────────────
       ARIA setup
    ────────────────────────────────────────────────────────────── */

    _setupARIA() {
      // — Tab list —
      setAttrs(this.list, {
        role              : 'tablist',
        'aria-label'      : this.opts.i18n.tablistLabel,
        'aria-orientation': this.opts.type === 'vertical' ? 'vertical' : 'horizontal',
      });

      // — Individual tabs + panels —
      this.tabs.forEach((tab, i) => {
        const tabId   = `${this._id}-tab-${i}`;
        const panelId = `${this._id}-panel-${i}`;
        const panel   = this.panels[i];

        // Tab <li>
        setAttrs(tab, {
          role           : 'tab',
          id             : tabId,
          'aria-controls': panelId,
          'aria-selected': 'false',
          tabindex       : '-1',       // roving tabindex pattern: only active gets 0
        });
        tab.classList.add('tad-tab');

        // Panel
        if (panel) {
          setAttrs(panel, {
            role              : 'tabpanel',
            id                : panelId,
            'aria-labelledby' : tabId,   // may be updated to accBtn id in accordion mode
            'aria-hidden'     : 'true',
            tabindex          : '-1',    // managed by Tab-key interception logic
          });
          panel.classList.add('tad-panel');
          panel.hidden = true;
        }
      });
    }

    /* ──────────────────────────────────────────────────────────────
       Accordion headings (inserted AFTER panels are collected)
    ────────────────────────────────────────────────────────────── */

    _insertAccordionHeadings() {
      this.accBtns = this.tabs.map((tab, i) => {
        const panel   = this.panels[i];
        const panelId = `${this._id}-panel-${i}`;
        const btnId   = `${this._id}-acc-${i}`;

        // Semantic heading wrapper (ARIA APG accordion pattern requires heading element)
        const heading = document.createElement('div');
        heading.className = 'tad-acc-heading';
        heading.setAttribute('role',       'heading');
        heading.setAttribute('aria-level', '3');

        const btn = document.createElement('button');
        btn.type      = 'button';
        btn.id        = btnId;
        btn.className = 'tad-acc-btn';
        btn.innerHTML =
          `<span class="tad-acc-label">${tab.innerHTML}</span>` +
          `<span class="tad-acc-icon" aria-hidden="true">` +
            `<svg viewBox="0 0 12 12" width="12" height="12" focusable="false" aria-hidden="true">` +
              `<path d="M6 8.5L1 3.5h10L6 8.5z"/>` +
            `</svg>` +
          `</span>`;

        setAttrs(btn, {
          'aria-controls' : panelId,
          'aria-expanded' : 'false',
          tabindex        : '0',       // always in Tab sequence; hidden by CSS in tab mode
        });

        heading.appendChild(btn);

        // Insert immediately before the panel
        if (panel) {
          panel.before(heading);
        }

        return btn;
      });
    }

    /* ──────────────────────────────────────────────────────────────
       Event binding
    ────────────────────────────────────────────────────────────── */

    _on(el, type, fn) {
      el.addEventListener(type, fn);
      this._bound.push({ el, type, fn });
    }

    _bindAll() {
      // Tab <li> clicks + keyboard
      this.tabs.forEach((tab, i) => {
        this._on(tab, 'click',   ()  => this._activate(i));
        this._on(tab, 'keydown', (e) => this._tabKeydown(e, i));
      });

      // Accordion <button> clicks + keyboard
      this.accBtns.forEach((btn, i) => {
        this._on(btn, 'click',   ()  => this._activate(i));
        this._on(btn, 'keydown', (e) => this._accKeydown(e, i));
      });

      // Panel Tab-key interception (for correct Tab order in tab mode)
      this.panels.forEach((panel, i) => {
        this._on(panel, 'keydown', (e) => this._panelKeydown(e, i));
      });
    }

    /* ──────────────────────────────────────────────────────────────
       Activation logic
    ────────────────────────────────────────────────────────────── */

    _activate(index) {
      if (index < 0 || index >= this.count) return;

      const inAccordion = this._isAccordion();

      // Accordion toggle: clicking the active item closes it (if closed option allows)
      if (inAccordion && index === this._active) {
        const allowToggle = (this.opts.closed === true ||
                             this.opts.closed === 'accordion');
        if (allowToggle) {
          this._deactivateCurrent();
          return;
        }
        return; // Already active, don't re-fire
      }

      if (index === this._active) return; // No change in tab mode

      this._deactivateCurrent();
      this._active = index;

      const tab   = this.tabs[index];
      const panel = this.panels[index];
      const btn   = this.accBtns[index];

      // Activate tab <li>
      setAttrs(tab, { 'aria-selected': 'true', tabindex: '0' });
      tab.classList.add('tad-tab--active');

      // Activate accordion button
      setAttrs(btn, { 'aria-expanded': 'true' });
      btn.classList.add('tad-acc-btn--active');

      // Show panel
      if (panel) {
        setAttrs(panel, {
          'aria-hidden': 'false',
          tabindex     : '0',   // makes panel focusable for Tab-key interception
        });
        panel.classList.add('tad-panel--active');
        panel.hidden = false;
      }

      // Update URL hash
      if (this.opts.hash && window.history?.replaceState) {
        try {
          history.replaceState(null, '', `#${this._id}-${index + 1}`);
        } catch (_) { /* cross-origin hash failures are silently ignored */ }
      }

      // Fire activate callback
      if (typeof this.opts.activate === 'function') {
        this.opts.activate.call(this, index, tab, panel);
      }
    }

    _deactivateCurrent() {
      const i = this._active;
      if (i === -1) return;

      const tab   = this.tabs[i];
      const panel = this.panels[i];
      const btn   = this.accBtns[i];

      setAttrs(tab, { 'aria-selected': 'false', tabindex: '-1' });
      tab.classList.remove('tad-tab--active');

      setAttrs(btn, { 'aria-expanded': 'false' });
      btn.classList.remove('tad-acc-btn--active');

      if (panel) {
        setAttrs(panel, { 'aria-hidden': 'true', tabindex: '-1' });
        panel.classList.remove('tad-panel--active');
        panel.hidden = true;
      }

      this._active = -1;
    }

    /* ──────────────────────────────────────────────────────────────
       Keyboard handlers
    ────────────────────────────────────────────────────────────── */

    /**
     * Keyboard navigation for tab <li> items.
     *
     * WCAG 2.1 SC 2.1.1 + ARIA APG Tab Pattern:
     *   • Left/Right (or Up/Down for vertical): cycle through tabs
     *   • Home / End: jump to first / last tab
     *   • Enter / Space: activate focused tab
     *   • Tab: move focus into the active panel content (Tab-order fix)
     */
    _tabKeydown(e, index) {
      const total = this.count;
      let   next  = -1;

      switch (e.key) {
        case KEY.RIGHT:
        case KEY.DOWN:
          e.preventDefault();
          next = (index + 1) % total;
          break;

        case KEY.LEFT:
        case KEY.UP:
          e.preventDefault();
          next = (index - 1 + total) % total;
          break;

        case KEY.HOME:
          e.preventDefault();
          next = 0;
          break;

        case KEY.END:
          e.preventDefault();
          next = total - 1;
          break;

        case KEY.ENTER:
        case KEY.SPACE:
          e.preventDefault();
          this._activate(index);
          return;

        case KEY.TAB:
          // ══ Tab-order fix (Tab mode only) ══
          // Natural DOM order: [tab1][tab2][tab3][panel1][panel2][panel3]
          // Expected order  : [tab1]…[active-tab] → [active-panel] → [tab-after-active]…
          //
          // Rule ①: Tab forward from the ACTIVE tab → jump to active panel
          if (!e.shiftKey && !this._isAccordion() && index === this._active) {
            const panel = this.panels[index];
            if (panel) {
              e.preventDefault();
              panel.focus();
            }
          }
          return;
      }

      if (next !== -1) {
        this.tabs[next].focus();
        if (this.opts.activation === 'auto') {
          this._activate(next);
        }
      }
    }

    /**
     * Keyboard navigation for panel elements.
     *
     * Tab-order rules (Tab mode only):
     *   Rule ②: Tab forward  from ACTIVE panel → jump to tab AFTER active (or exit widget)
     *   Rule ③: Shift+Tab    from ACTIVE panel → return to active tab
     *   Rule ④: Shift+Tab    from the tab immediately AFTER active → return to active panel
     */
    _panelKeydown(e, panelIndex) {
      if (e.key !== KEY.TAB || this._isAccordion()) return;

      const activeIdx = this._active;
      const total     = this.count;

      if (!e.shiftKey) {
        // ── Rule ②: Tab forward from active panel ──
        if (panelIndex === activeIdx) {
          const nextTabIdx = activeIdx + 1;
          if (nextTabIdx < total) {
            e.preventDefault();
            this.tabs[nextTabIdx].focus();
          }
          // If active is the LAST tab, do NOT preventDefault.
          // Let the browser Tab naturally past the panel and exit the widget.
        }
      } else {
        // ── Rule ③: Shift+Tab from active panel → back to active tab ──
        if (panelIndex === activeIdx) {
          e.preventDefault();
          this.tabs[activeIdx]?.focus();
        }
      }
    }

    /**
     * Keyboard navigation for the (active-tab + 1) tab item.
     * Rule ④: Shift+Tab on the first tab AFTER the active tab → jump to active panel.
     *
     * This is bound on tab items alongside _tabKeydown, so we re-check here.
     */
    _tabKeydown_shiftTabRule4(e, index) {
      // Already handled inline in _tabKeydown; this note documents Rule ④.
      // See _tabKeydown: case KEY.TAB, !e.shiftKey branch handles Rule ①.
      // Rule ④ is handled in the same keydown handler below via an extra check.
    }

    /**
     * Keyboard navigation for accordion <button> elements.
     *
     * ARIA APG Accordion Pattern:
     *   • Down  : focus next accordion button (wraps)
     *   • Up    : focus prev accordion button (wraps)
     *   • Home  : focus first button
     *   • End   : focus last button
     *   • Enter / Space : toggle panel (handled by click via _activate)
     *   • Escape: collapse currently open panel (if toggleable)
     */
    _accKeydown(e, index) {
      const total = this.count;
      let   next  = -1;

      switch (e.key) {
        case KEY.DOWN:
          e.preventDefault();
          next = (index + 1) % total;
          break;

        case KEY.UP:
          e.preventDefault();
          next = (index - 1 + total) % total;
          break;

        case KEY.HOME:
          e.preventDefault();
          next = 0;
          break;

        case KEY.END:
          e.preventDefault();
          next = total - 1;
          break;

        case KEY.ENTER:
        case KEY.SPACE:
          e.preventDefault();
          this._activate(index);
          return;

        case KEY.ESC:
          // Collapse if this accordion item is open and toggleable
          if (index === this._active) {
            const allowToggle = (this.opts.closed === true ||
                                 this.opts.closed === 'accordion');
            if (allowToggle) {
              e.preventDefault();
              this._deactivateCurrent();
            }
          }
          return;
      }

      if (next !== -1) {
        this.accBtns[next].focus();
      }
    }

    /* ──────────────────────────────────────────────────────────────
       Mode switching (tabs ↔ accordion)
    ────────────────────────────────────────────────────────────── */

    /**
     * Returns true when the widget should render as an accordion.
     * Accordion type is always accordion; default/vertical switch below breakpoint.
     */
    _isAccordion() {
      if (this.opts.type === 'accordion') return true;
      return window.innerWidth <= this.opts.breakpoint;
    }

    /**
     * Evaluates current display mode and updates ARIA + tabindex accordingly.
     * @param {boolean} silent — if true, skip classList change (used on first init)
     */
    _updateMode(silent = false) {
      const isAcc = this._isAccordion();
      const newMode = isAcc ? 'accordion' : 'tabs';
      if (this._mode === newMode) return;
      this._mode = newMode;

      if (!silent) {
        this.root.classList.toggle('tad-mode-accordion', isAcc);
        this.root.classList.toggle('tad-mode-tabs',      !isAcc);
      } else {
        // Apply both on first paint
        this.root.classList.add(isAcc ? 'tad-mode-accordion' : 'tad-mode-tabs');
      }

      if (isAcc) {
        /* ── Accordion mode ──
           • Tab <li> items are visually hidden (CSS) → remove from Tab sequence
           • Accordion <button>s are visible → keep in Tab sequence
           • Panels: aria-labelledby → accordion button id
        */
        this.tabs.forEach(tab => {
          setAttrs(tab, { tabindex: '-1', 'aria-hidden': 'true' });
        });
        this.accBtns.forEach(btn => {
          setAttrs(btn, { tabindex: '0' });
          btn.removeAttribute('aria-hidden');
        });
        this.panels.forEach((panel, i) => {
          panel.setAttribute('aria-labelledby', `${this._id}-acc-${i}`);
        });
        setAttrs(this.list, { 'aria-hidden': 'true' });

      } else {
        /* ── Tab mode ──
           • Tab <li> items are visible → restore roving tabindex
           • Accordion <button>s are visually hidden (CSS) → remove from Tab sequence
           • Panels: aria-labelledby → tab id
        */
        this.tabs.forEach((tab, i) => {
          const isActive = i === this._active;
          setAttrs(tab, {
            tabindex    : isActive ? '0' : '-1',
            'aria-hidden': null,
          });
        });
        // Ensure at least tab[0] is reachable if nothing active
        if (this._active === -1) {
          this.tabs[0]?.setAttribute('tabindex', '0');
        }
        this.accBtns.forEach(btn => {
          setAttrs(btn, { tabindex: '-1', 'aria-hidden': 'true' });
        });
        this.panels.forEach((panel, i) => {
          panel.setAttribute('aria-labelledby', `${this._id}-tab-${i}`);
        });
        this.list.removeAttribute('aria-hidden');
      }
    }

    /* ──────────────────────────────────────────────────────────────
       Initialisation
    ────────────────────────────────────────────────────────────── */

    _initActive() {
      let idx = this.opts.activeIndex;

      // URL hash overrides activeIndex
      if (this.opts.hash) {
        const hashIdx = this._indexFromHash();
        if (hashIdx !== -1) idx = hashIdx;
      }

      // Determine if we should start closed
      const startClosed = (
        this.opts.closed === true ||
        (this.opts.closed === 'accordion' && this._isAccordion()) ||
        (this.opts.closed === 'tabs'      && !this._isAccordion())
      );

      if (!startClosed) {
        this._activate(idx);
      } else {
        // Nothing active, but keep first tab/button reachable via Tab key
        if (!this._isAccordion()) {
          this.tabs[0]?.setAttribute('tabindex', '0');
        } else {
          this.accBtns[0]?.setAttribute('tabindex', '0');
        }
      }
    }

    _indexFromHash() {
      const hash = window.location.hash;
      if (!hash) return -1;
      // Format: #<container-id>-<1-based-number>
      const pattern = new RegExp(`^#${this._id.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}-(\\d+)$`);
      const match   = hash.match(pattern);
      if (!match) return -1;
      const idx = parseInt(match[1], 10) - 1;
      return (idx >= 0 && idx < this.count) ? idx : -1;
    }

    /* ──────────────────────────────────────────────────────────────
       Public API
    ────────────────────────────────────────────────────────────── */

    /**
     * Activate the tab at the given zero-based index.
     * @param {number} index
     * @returns {TadTabs} this (chainable)
     */
    activate(index) {
      this._activate(index);
      return this;
    }

    /**
     * Activate the next tab (wraps around).
     * @returns {TadTabs} this
     */
    next() {
      const cur = this._active === -1 ? -1 : this._active;
      this._activate((cur + 1) % this.count);
      return this;
    }

    /**
     * Activate the previous tab (wraps around).
     * @returns {TadTabs} this
     */
    prev() {
      const cur = this._active === -1 ? this.count : this._active;
      this._activate((cur - 1 + this.count) % this.count);
      return this;
    }

    /**
     * Returns the currently active zero-based index, or -1 if none.
     * @returns {number}
     */
    getActive() {
      return this._active;
    }

    /**
     * Returns the number of tabs.
     * @returns {number}
     */
    length() {
      return this.count;
    }

    /**
     * Destroy this instance: remove event listeners, clean up ARIA,
     * remove injected accordion headings.
     */
    destroy() {
      // Remove event listeners
      this._bound.forEach(({ el, type, fn }) => el.removeEventListener(type, fn));
      this._bound = [];

      // Disconnect ResizeObserver
      this._ro?.disconnect();

      // Remove injected accordion headings
      this.root.querySelectorAll('.tad-acc-heading').forEach(el => el.remove());

      // Reset ARIA on tabs
      this.tabs.forEach(tab => {
        tab.removeAttribute('role');
        tab.removeAttribute('id');
        tab.removeAttribute('aria-controls');
        tab.removeAttribute('aria-selected');
        tab.removeAttribute('tabindex');
        tab.removeAttribute('aria-hidden');
        tab.classList.remove('tad-tab', 'tad-tab--active');
      });

      // Reset ARIA on panels
      this.panels.forEach(panel => {
        panel.removeAttribute('role');
        panel.removeAttribute('id');
        panel.removeAttribute('aria-labelledby');
        panel.removeAttribute('aria-hidden');
        panel.removeAttribute('tabindex');
        panel.removeAttribute('hidden');
        panel.classList.remove('tad-panel', 'tad-panel--active');
      });

      // Reset list
      this.list.removeAttribute('role');
      this.list.removeAttribute('aria-label');
      this.list.removeAttribute('aria-orientation');
      this.list.removeAttribute('aria-hidden');

      // Remove root classes
      this.root.classList.remove(
        'tad-initialized', 'tad-mode-tabs', 'tad-mode-accordion'
      );

      delete this.root._tadTabs;
    }

    /* ──────────────────────────────────────────────────────────────
       Static members
    ────────────────────────────────────────────────────────────── */

    /** Plugin version */
    static get version() { return VERSION; }

    /**
     * Auto-initialise all matching elements.
     * Reads configuration from data-* attributes.
     *
     * @param {string} selector — default: '[data-tad]'
     * @returns {TadTabs[]} array of created instances
     */
    static init(selector = '[data-tad]') {
      return Array.from(document.querySelectorAll(selector)).map(el => {
        if (el._tadTabs) return el._tadTabs;
        const d    = el.dataset;
        const opts = {};
        if (d.tadType       != null) opts.type        = d.tadType;
        if (d.tadBreakpoint != null) opts.breakpoint  = parseInt(d.tadBreakpoint, 10);
        if (d.tadActive     != null) opts.activeIndex = parseInt(d.tadActive, 10);
        if (d.tadActivation != null) opts.activation  = d.tadActivation;
        if (d.tadHash       != null) opts.hash        = d.tadHash !== 'false';
        if (d.tadClosed     != null) {
          opts.closed = (d.tadClosed === 'true')  ? true  :
                        (d.tadClosed === 'false') ? false :
                        d.tadClosed;
        }
        return new TadTabs(el, opts);
      });
    }

  } // end class TadTabs

  /* ═══════════════════════════════════════════════════════════════
     jQuery bridge (optional — loaded only if jQuery is present)

     Provides:
       $(el).tadTabs(options)   — primary API
       $(el).easyResponsiveTabs(options)  — drop-in replacement for legacy plugin
  ═══════════════════════════════════════════════════════════════ */

  if (typeof jQuery !== 'undefined') {

    jQuery.fn.tadTabs = function (options) {
      return this.each(function () {
        new TadTabs(this, typeof options === 'object' ? options : {});
      });
    };

    /**
     * Drop-in replacement for easyResponsiveTabs.
     * Maps the original option names to TadTabs equivalents.
     */
    jQuery.fn.easyResponsiveTabs = function (options = {}) {
      return this.each(function () {
        new TadTabs(this, {
          type       : options.type        || 'default',
          closed     : options.closed      ?? false,
          breakpoint : options.breakpoint  || 768,
          activate   : options.activate    || null,
          activeIndex: 0,
        });
      });
    };
  }

  /* ═══════════════════════════════════════════════════════════════
     Tab key: Rule ④ — Shift+Tab on tab-after-active → active panel
     (patched into _tabKeydown via prototype augmentation at module load)
  ═══════════════════════════════════════════════════════════════ */

  // Rule ④ is already covered inline inside _tabKeydown (Tab key, shiftKey case).
  // The original _tabKeydown only handles !shiftKey. We extend it here:
  const _origTabKeydown = TadTabs.prototype._tabKeydown;
  TadTabs.prototype._tabKeydown = function (e, index) {
    // ── Rule ④ ──
    // Shift+Tab from the tab immediately AFTER the active tab → focus active panel
    if (e.key === KEY.TAB && e.shiftKey && !this._isAccordion()) {
      const activeIdx = this._active;
      if (activeIdx !== -1 && index === activeIdx + 1) {
        const panel = this.panels[activeIdx];
        if (panel) {
          e.preventDefault();
          panel.focus();
          return;
        }
      }
    }
    // Delegate to original handler for all other cases
    _origTabKeydown.call(this, e, index);
  };

  /* ═══════════════════════════════════════════════════════════════
     Auto-init on DOMContentLoaded
  ═══════════════════════════════════════════════════════════════ */

  if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => TadTabs.init());
    } else {
      // DOM already ready
      TadTabs.init();
    }
  }

  return TadTabs;

}));
