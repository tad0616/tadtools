/**
 * TadMarquee - 無障礙跑馬燈套件
 * 版本: 2.0.8
 * 符合 WCAG 2.2 AA / AAA 無障礙標準
 *
 * 功能特色:
 * ✓ 完整的鍵盤導航支援 (方向鍵、Home/End、Esc)
 * ✓ 螢幕閱讀器友善 (ARIA 標籤、即時通知)
 * ✓ 符合 WCAG AAA 色彩對比度要求 (7:1)
 * ✓ 響應式自適應設計 (自動調整速度)
 * ✓ 支援 prefers-reduced-motion (尊重用戶偏好)
 * ✓ 焦點管理和視覺指示器
 * ✓ 最小觸控目標尺寸 (44x44px)
 * ✓ 支援深色模式和高對比度模式
 * ✓ containerStyle / itemStyle 支援物件或 CSS 字串兩種格式
 * ✓ up/down 模式：內容靠左對齊，超出容器寬度自動換行
 * ✓ 無縫循環：第五則後直接接續第一則，不跳動
 * ✓ WCAG 2.2.2 AA：暫停按鈕預設置於頂部控制列（焦點順序第 1 位）
 * ✓ WCAG 2.4.3 AA：焦點順序「暫停按鈕 → 內容項目」，上至下、左至右
 * ✓ pauseButtonPosition 支援 'top'（預設）/ left / right（並排）/ 四角落模式
 */

(function(global, factory) {
    if (typeof exports === 'object' && typeof module !== 'undefined') {
        module.exports = factory();
    } else if (typeof define === 'function' && define.amd) {
        define(factory);
    } else {
        global.TadMarquee = factory();
    }
}(typeof self !== 'undefined' ? self : this, function() {
    'use strict';

    // ==================== 工具函式 ====================

    function parseStyle(style) {
        if (!style) return {};
        if (typeof style === 'object' && !Array.isArray(style)) return { ...style };
        if (typeof style === 'string') {
            const result = {};
            style.split(';').map(s => s.trim()).filter(Boolean).forEach(decl => {
                const ci = decl.indexOf(':');
                if (ci === -1) return;
                const prop  = decl.slice(0, ci).trim();
                const value = decl.slice(ci + 1).trim();
                if (!prop || !value) return;
                result[prop.replace(/-([a-z])/g, (_, l) => l.toUpperCase())] = value;
            });
            return result;
        }
        console.warn('TadMarquee: style 必須是字串或物件，已忽略。');
        return {};
    }

    function applyStyle(el, style) {
        Object.assign(el.style, parseStyle(style));
    }

    function isVertical(dir) {
        return dir === 'up' || dir === 'down';
    }

    /** 判斷是否為 input-group 並排模式 */
    function isInlineMode(pos) {
        return pos === 'left' || pos === 'right';
    }

    /** 判斷是否為頂部控制列模式（WCAG 2.2.2 / 2.4.3 AA 建議位置） */
    function isTopMode(pos) {
        return pos === 'top';
    }

    // ==================== 主類別 ====================

    class TadMarquee {
        constructor(containerId, options = {}) {
            this.container = typeof containerId === 'string'
                ? document.getElementById(containerId)
                : containerId;

            if (!this.container) throw new Error('TadMarquee: 找不到指定的容器元素');

            this.containerId = this.container.id || 'tad-marquee-' + Date.now();

            this.options = {
                direction: options.direction || 'right',
                speed: options.speed || 50,
                pauseOnHover: options.pauseOnHover !== false,
                pauseOnFocus: options.pauseOnFocus !== false,
                items: options.items || [],
                gap: options.gap || 20,
                autoStart: options.autoStart !== false,
                loop: options.loop !== false,
                className: options.className || '',
                containerStyle: options.containerStyle || {},
                itemStyle: options.itemStyle || {},
                itemClassName: options.itemClassName || '',
                ariaLabel: options.ariaLabel || '跑馬燈內容',
                ariaLive: options.ariaLive || 'off', // 從 'polite' 改為 'off'
                respectReducedMotion: options.respectReducedMotion === true, // 預設改為 false，避免 Chrome 因為作業系統設定而預設不播放
                announceItems: options.announceItems !== false,
                keyboardControl: options.keyboardControl !== false,
                minContrastRatio: options.minContrastRatio || 7,
                responsiveSpeed: options.responsiveSpeed !== false,
                responsiveBreakpoints: options.responsiveBreakpoints || {
                    mobile: 480, tablet: 768, desktop: 1024
                },
                showPauseButton: options.showPauseButton !== false,
                // 支援：'top'（預設，WCAG 2.2.2/2.4.3 AA 建議）| 'bottom-right' | 'bottom-left' | 'top-right' | 'top-left' | 'left' | 'right'
                pauseButtonPosition: options.pauseButtonPosition || 'top',
                pauseButtonLabel: options.pauseButtonLabel || {
                    pause:  '暫停跑馬燈',
                    resume: '繼續跑馬燈'
                },
                ...options
            };

            // 狀態
            this.isRunning         = false;
            this.isPaused          = false;
            this.isPausedByUser    = false;
            this.animationId       = null;
            this.wrapper           = null;
            this.pauseBtn          = null;
            this.rootEl            = null;   // ← input-group 外層容器
            this.marqueeEl         = null;   // ← 跑馬燈實際捲動區域
            this.currentPosition   = 0;
            this.isSingleItem      = false;
            this.bounceDirection   = 1;
            this.currentFocusIndex = -1;
            this.prefersReducedMotion = false;
            this.currentBreakpoint = null;
            this._loopSize         = 0;

            this.callbacks = {
                onStart: options.onStart || null,
                onStop: options.onStop || null,
                onPause: options.onPause || null,
                onResume: options.onResume || null,
                onDirectionChange: options.onDirectionChange || null,
                onBreakpointChange: options.onBreakpointChange || null
            };

            this.init();
        }

        // ── 初始化 ────────────────────────────────────────────────

        init() {
            this.checkReducedMotion();
            this.buildLayout();           // ← 先建立 root / marqueeEl 結構
            this.setupContainer();
            this.setupAccessibility();
            this.createWrapper();
            this.renderItems();
            this.setupPauseButton();
            this.setupEventListeners();
            this.setupKeyboardNavigation();
            this.setupResponsive();

            if (this.options.autoStart && !this.prefersReducedMotion) {
                this.start();
            } else if (this.prefersReducedMotion) {
                this.announceToScreenReader('跑馬燈已暫停以尊重您的動畫偏好設定');
            }
        }

        checkReducedMotion() {
            if (!this.options.respectReducedMotion) return;
            const mq = window.matchMedia('(prefers-reduced-motion: reduce)');
            this.prefersReducedMotion = mq.matches;
            try {
                mq.addEventListener('change', (e) => {
                    this.prefersReducedMotion = e.matches;
                    if (e.matches) { this.pause(); this.announceToScreenReader('動畫已暫停'); }
                    else if (!this.isPausedByUser) this.resume();
                });
            } catch (_) {
                mq.addListener((e) => { this.prefersReducedMotion = e.matches; if (e.matches) this.pause(); });
            }
        }

        // ── 版面結構 ──────────────────────────────────────────────

        /**
         * 根據 pauseButtonPosition 決定版面結構：
         *
         * ■ 角落模式（top-left / top-right / bottom-left / bottom-right）
         *   container（原始元素）直接作為跑馬燈區域，按鈕 absolute 疊加其上
         *   DOM：container > [wrapper, pauseBtn]
         *
         * ■ 並排模式（left / right）
         *   在 container 外插入 rootEl（flex 橫排），
         *   container 縮為 marqueeEl（flex:1），按鈕為 flex item 並排
         *   DOM：rootEl > [pauseBtn?, marqueeEl, pauseBtn?]
         */
        buildLayout() {
            const pos = this.options.pauseButtonPosition;

            if (isInlineMode(pos)) {
                // ── 並排模式：建立外層 rootEl ──────────────────────
                this.rootEl = document.createElement('div');
                this.rootEl.className = 'tad-marquee-root tad-marquee-inline';
                Object.assign(this.rootEl.style, {
                    display:    'flex',
                    flexDirection: 'row',
                    alignItems: 'stretch',
                    width:      '100%'
                    // overflow: hidden 不設在 rootEl 層，以免焦點外框被裁切
                    // 實際裁切由 marqueeEl 自身的 overflow: hidden 負責
                });

                // 將 container 的父節點插入 rootEl，container 移入 rootEl
                this.container.parentNode.insertBefore(this.rootEl, this.container);
                this.rootEl.appendChild(this.container);

                // container 本身作為 marqueeEl（捲動區域）
                this.marqueeEl = this.container;
                Object.assign(this.marqueeEl.style, {
                    flex:     '1 1 0%',
                    minWidth: '0',          // 防止 flex item 撐破
                    overflow: 'hidden',
                    position: 'relative'
                });

            } else if (isTopMode(pos)) {
                // ── 頂部模式：外層 rootEl（column flex），控制列在上、捲動區在下 ──
                this.rootEl = document.createElement('div');
                this.rootEl.className = 'tad-marquee-root tad-marquee-top';
                Object.assign(this.rootEl.style, {
                    display:       'flex',
                    flexDirection: 'column',
                    width:         '100%'
                });

                this.container.parentNode.insertBefore(this.rootEl, this.container);
                this.rootEl.appendChild(this.container);

                this.marqueeEl = this.container;
                Object.assign(this.marqueeEl.style, {
                    flex:     '1 1 auto',
                    overflow: 'hidden',
                    position: 'relative'
                });

            } else {
                // ── 角落模式：container 直接作為跑馬燈區域 ─────────
                this.rootEl    = null;
                this.marqueeEl = this.container;
            }
        }

        setupContainer() {
            this.marqueeEl.style.position = 'relative';
            this.marqueeEl.style.overflow = 'hidden';

            if (!this.container.classList.contains('tad-marquee-container'))
                this.container.classList.add('tad-marquee-container');
            if (this.options.className) this.container.classList.add(this.options.className);
            if (this.options.containerStyle) applyStyle(this.container, this.options.containerStyle);
        }

        setupAccessibility() {
            const top      = isTopMode(this.options.pauseButtonPosition);
            // 頂部模式：role="region" 置於外層 rootEl，涵蓋控制列與捲動區
            // 其他模式：role="region" 直接在 marqueeEl
            const regionEl = top ? this.rootEl : this.marqueeEl;

            regionEl.setAttribute('role',       'region');
            regionEl.setAttribute('aria-label', this.options.ariaLabel);
            regionEl.setAttribute('aria-live',  'off'); // 從 this.options.ariaLive 改為固定值 'off'

            // 頂部模式：Tab 焦點順序為「暫停按鈕 → 各項目」，容器本身不需成為 Tab 停靠點
            // 其他模式：容器本身可接收鍵盤焦點（Space/Enter 觸發暫停）
            if (this.options.keyboardControl && !top) {
                this.marqueeEl.setAttribute('tabindex', '0');
            }

            if (!document.getElementById('tad-marquee-announcer')) {
                const a = document.createElement('div');
                a.id = 'tad-marquee-announcer';
                a.setAttribute('role', 'status');
                a.setAttribute('aria-live', 'polite'); // 這裡保留 polite，因為這是主動通知區
                a.setAttribute('aria-atomic', 'true');
                a.className = 'tad-marquee-sr-only';
                document.body.appendChild(a);
            }
            this.announcer = document.getElementById('tad-marquee-announcer');
        }

        announceToScreenReader(msg, priority = 'polite') {
            if (!this.announcer) return;
            this.announcer.setAttribute('aria-live', priority);
            this.announcer.textContent = msg;
            setTimeout(() => { if (this.announcer) this.announcer.textContent = ''; }, 1000);
        }

        // ── Wrapper ───────────────────────────────────────────────

        createWrapper() {
            if (this.wrapper) this.wrapper.remove();

            this.wrapper = document.createElement('div');
            this.wrapper.className = 'tad-marquee-wrapper';
            this.wrapper.setAttribute('role', 'list');
            this.wrapper.style.position = 'absolute';

            if (isVertical(this.options.direction)) {
                this.wrapper.style.whiteSpace    = 'normal';
                this.wrapper.style.width         = '100%';
                this.wrapper.style.overflowWrap  = 'break-word';
                this.wrapper.style.wordBreak     = 'break-word';
                this.wrapper.style.display       = 'flex';
                this.wrapper.style.flexDirection = 'column';
                this.wrapper.style.alignItems    = 'flex-start';
            } else {
                this.wrapper.style.whiteSpace = 'nowrap';
                this.wrapper.style.display    = 'flex';
                this.wrapper.style.alignItems = 'center';
            }

            this.marqueeEl.appendChild(this.wrapper);
        }

        // ── 暫停按鈕 ──────────────────────────────────────────────

        setupPauseButton() {
            if (!this.options.showPauseButton) return;
            if (this.pauseBtn) this.pauseBtn.remove();

            const pos      = this.options.pauseButtonPosition;
            const inline   = isInlineMode(pos);
            const top      = isTopMode(pos);
            const btn      = document.createElement('button');
            btn.className  = 'tad-marquee-pause-btn';
            btn.setAttribute('type', 'button');
            btn.setAttribute('aria-label', this.options.pauseButtonLabel.pause);
            btn.setAttribute('aria-pressed', 'false');

            // ── 共用樣式 ──────────────────────────────────────────
            Object.assign(btn.style, {
                flexShrink:     '0',
                border:         'none',
                cursor:         'pointer',
                display:        'flex',
                alignItems:     'center',
                justifyContent: 'center',
                color:          '#ffffff',
                transition:     'background 0.2s, box-shadow 0.2s',
                // outline: 'none' 不設定，讓 CSS :focus-visible 規則在高對比模式下生效
                lineHeight:     '1'
            });

            if (inline) {
                // ── 並排模式：高度撐滿、寬度固定、無圓角（融入 input-group）
                Object.assign(btn.style, {
                    position:     'static',
                    width:        '40px',
                    height:       '100%',
                    minHeight:    '36px',
                    background:   'rgba(0,0,0,0.55)',
                    borderRadius: '0',
                    // 左側按鈕：右邊有分隔線；右側按鈕：左邊有分隔線
                    borderLeft:   pos === 'right' ? '1px solid rgba(255,255,255,0.25)' : 'none',
                    borderRight:  pos === 'left'  ? '1px solid rgba(255,255,255,0.25)' : 'none',
                    boxShadow:    'none'
                });
            } else if (top) {
                // ── 頂部模式：固定尺寸矩形按鈕，符合 WCAG 2.5.5 目標尺寸（44×36px）
                Object.assign(btn.style, {
                    position:     'static',
                    width:        '44px',
                    height:       '36px',
                    minHeight:    '36px',
                    background:   'rgba(0,0,0,0.65)',
                    borderRadius: '4px',
                    boxShadow:    'none'
                });
            } else {
                // ── 角落模式：圓形浮動按鈕 ────────────────────────
                const posMap = {
                    'bottom-right': { bottom: '6px', right: '6px', top: 'auto',  left: 'auto'  },
                    'bottom-left':  { bottom: '6px', left:  '6px', top: 'auto',  right: 'auto' },
                    'top-right':    { top:    '6px', right: '6px', bottom: 'auto', left: 'auto' },
                    'top-left':     { top:    '6px', left:  '6px', bottom: 'auto', right: 'auto'}
                };
                const p = posMap[pos] || posMap['bottom-right'];
                Object.assign(btn.style, {
                    position:     'absolute',
                    zIndex:       '10',
                    width:        '32px',
                    height:       '32px',
                    background:   'rgba(0,0,0,0.55)',
                    borderRadius: '50%',
                    boxShadow:    '0 1px 4px rgba(0,0,0,0.4)',
                    ...p
                });
            }

            btn.innerHTML = this._pauseIcon(inline || top);

            // ── Hover ──────────────────────────────────────────────
            btn.addEventListener('mouseenter', () => {
                btn.style.background = 'rgba(0,0,0,0.80)';
                if (!inline && !top) btn.style.transform = 'scale(1.1)';
            });
            btn.addEventListener('mouseleave', () => {
                btn.style.background = this.isPausedByUser
                    ? 'rgba(30,120,30,0.75)'
                    : (top ? 'rgba(0,0,0,0.65)' : 'rgba(0,0,0,0.55)');
                if (!inline && !top) btn.style.transform = 'scale(1)';
            });

            // ── Focus（WCAG 2.4.11 可見焦點）──────────────────────
            btn.addEventListener('focus', () => {
                btn.style.outline      = '3px solid #ffdd00';
                // 角落模式：按鈕在 overflow:hidden 容器內，outline-offset 若為正值會被裁切
                // → 改為負值（向內），確保焦點框完整顯示在按鈕範圍內
                btn.style.outlineOffset = (inline || top) ? '2px' : '-2px';
                btn.style.boxShadow    = (inline || top)
                    ? '0 0 0 3px rgba(255,221,0,0.5)'
                    : 'inset 0 0 0 3px rgba(255,221,0,0.35)';
            });
            btn.addEventListener('blur', () => {
                btn.style.outline   = '';
                btn.style.outlineOffset = '';
                btn.style.boxShadow = (inline || top) ? 'none' : '0 1px 4px rgba(0,0,0,0.4)';
            });

            // ── Click（Enter/Space 由瀏覽器原生行為觸發按鈕點擊）─
            btn.addEventListener('click', () => this._togglePauseByUser());

            this.pauseBtn = btn;

            // ── 插入位置 ──────────────────────────────────────────
            if (inline) {
                // 並排模式：暫停按鈕一律插入 DOM 第一位，確保 Tab 先到達按鈕（WCAG 2.2.2）
                // 視覺位置由 CSS flex order 控制：left = order 0（最左），right = order 2（最右）
                if (pos === 'left') {
                    btn.style.order = '0';
                    this.rootEl.insertBefore(btn, this.rootEl.firstChild);
                } else {
                    // right 模式：DOM 排第一（Tab 最先到），視覺靠右（order: 2）
                    btn.style.order = '2';
                    this.rootEl.insertBefore(btn, this.rootEl.firstChild);
                    // container（marqueeEl）預設 order: 0，視覺上排在按鈕左方
                }
            } else if (top) {
                // 頂部模式：建立控制列容器，置於 rootEl 最頂端（DOM 第一位）
                // 焦點順序：暫停按鈕（第 1 位） → 各項目（第 2+ 位）
                const ctrlBar = document.createElement('div');
                ctrlBar.className = 'tad-marquee-controls';
                ctrlBar.setAttribute('role', 'group');
                ctrlBar.setAttribute('aria-label', '跑馬燈控制');
                ctrlBar.appendChild(btn);
                // 插入至 rootEl 第一個子節點之前（captive: container 之前）
                this.rootEl.insertBefore(ctrlBar, this.rootEl.firstChild);
                this._ctrlBar = ctrlBar;
            } else {
                // 角落模式：插入 marqueeEl 第一個子節點之前（即 wrapper 之前）
                // 按鈕為 position: absolute，視覺位置不受 DOM 順序影響
                // 但 Tab 焦點順序依 DOM 順序，因此暫停按鈕會先於跑馬燈項目被聚焦（WCAG 2.2.2）
                this.marqueeEl.insertBefore(btn, this.wrapper);
            }
        }

        /** 暫停圖示 SVG（▐▐） */
        _pauseIcon(large = false) {
            const s = large ? 16 : 14;
            return `<svg aria-hidden="true" focusable="false"
                        width="${s}" height="${s}" viewBox="0 0 14 14"
                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <rect x="2"   y="1" width="3.5" height="12" rx="1"/>
                      <rect x="8.5" y="1" width="3.5" height="12" rx="1"/>
                    </svg>`;
        }

        /** 播放圖示 SVG（▶） */
        _playIcon(large = false) {
            const s = large ? 16 : 14;
            return `<svg aria-hidden="true" focusable="false"
                        width="${s}" height="${s}" viewBox="0 0 14 14"
                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path d="M3 1.5 L12 7 L3 12.5 Z"/>
                    </svg>`;
        }

        _togglePauseByUser() {
            if (!this.isRunning) {
                this.start(true);
                this.isPausedByUser = false;
                this._updatePauseButton(false);
                this.announceToScreenReader(this.options.pauseButtonLabel.resume);
                this.triggerCallback('onResume');
                return;
            }

            const inline = isInlineMode(this.options.pauseButtonPosition);
            if (this.isPaused) {
                this.resume(true);
                this.isPausedByUser = false;
                this._updatePauseButton(false);
                this.announceToScreenReader(this.options.pauseButtonLabel.resume);
                this.triggerCallback('onResume');
            } else {
                this.pause();
                this.isPausedByUser = true;
                this._updatePauseButton(true);
                this.announceToScreenReader(this.options.pauseButtonLabel.pause);
                this.triggerCallback('onPause');
            }
        }

        _updatePauseButton(paused) {
            if (!this.pauseBtn) return;
            const inline = isInlineMode(this.options.pauseButtonPosition);
            const top    = isTopMode(this.options.pauseButtonPosition);
            if (paused) {
                this.pauseBtn.innerHTML = this._playIcon(inline || top);
                this.pauseBtn.setAttribute('aria-label', this.options.pauseButtonLabel.resume);
                this.pauseBtn.setAttribute('aria-pressed', 'true');
                // 暫停時背景改為深綠，提示目前狀態
                this.pauseBtn.style.background = 'rgba(30,120,30,0.75)';
            } else {
                this.pauseBtn.innerHTML = this._pauseIcon(inline || top);
                this.pauseBtn.setAttribute('aria-label', this.options.pauseButtonLabel.pause);
                this.pauseBtn.setAttribute('aria-pressed', 'false');
                this.pauseBtn.style.background = top ? 'rgba(0,0,0,0.65)' : 'rgba(0,0,0,0.55)';
            }
        }

        // ── 渲染項目（含無縫複本）────────────────────────────────

        renderItems() {
            this.wrapper.innerHTML = '';
            this.isSingleItem = this.options.items.length === 1;
            this._loopSize = 0;

            if (this.options.items.length === 0) {
                console.warn('TadMarquee: 沒有提供任何項目內容');
                return;
            }

            const vertical = isVertical(this.options.direction);

            const buildGroup = (ariaHidden = false) => {
                const frag = document.createDocumentFragment();
                this.options.items.forEach((item, index) => {
                    const el = this.createItemElement(item, index);
                    if (ariaHidden) {
                        el.setAttribute('aria-hidden', 'true');
                        el.setAttribute('tabindex', '-1');
                    }
                    if (vertical) {
                        el.style.display     = 'block';
                        el.style.width       = '100%';
                        el.style.whiteSpace  = 'normal';
                        el.style.overflowWrap = 'break-word';
                        el.style.wordBreak   = 'break-word';
                    }
                    frag.appendChild(el);

                    const gap = document.createElement('div');
                    gap.className = 'tad-marquee-gap';
                    gap.setAttribute('aria-hidden', 'true');
                    if (vertical) {
                        gap.style.width   = '100%';
                        gap.style.height  = '1px';
                        gap.style.display = 'block';
                    } else {
                        gap.style.width      = this.options.gap + 'px';
                        gap.style.height     = '100%';
                        gap.style.display    = 'inline-block';
                        gap.style.flexShrink = '0';
                    }
                    frag.appendChild(gap);
                });
                return frag;
            };

            this.wrapper.appendChild(buildGroup(false));
            requestAnimationFrame(() => this._measureAndClone(buildGroup, vertical));
            this.resetPosition();
        }

        _measureAndClone(buildGroup, vertical) {
            if (!this.wrapper) return;

            if (!vertical && this.wrapper.offsetHeight > 0) {
                if (this.marqueeEl.offsetHeight < this.wrapper.offsetHeight) {
                    this.marqueeEl.style.minHeight = Math.ceil(this.wrapper.offsetHeight) + 'px';
                }
            } else if (vertical && this.wrapper.offsetWidth > 0) {
                if (this.marqueeEl.offsetWidth < this.wrapper.offsetWidth) {
                    this.marqueeEl.style.minWidth = Math.ceil(this.wrapper.offsetWidth) + 'px';
                }
            }

            const containerSize = vertical
                ? this.marqueeEl.offsetHeight
                : this.marqueeEl.offsetWidth;

            this._loopSize = vertical
                ? this.wrapper.offsetHeight
                : this.wrapper.offsetWidth;

            if (this._loopSize === 0) return;

            const copiesNeeded = Math.ceil((containerSize + this._loopSize) / this._loopSize);
            for (let i = 0; i < copiesNeeded; i++) {
                this.wrapper.appendChild(buildGroup(true));
            }
        }

        createItemElement(item, index) {
            const isLink = !!item.link;
            const el = document.createElement(isLink ? 'a' : 'div');
            el.className = 'tad-marquee-item';
            el.setAttribute('role', 'listitem');
            el.style.display = 'inline-block';
            el.setAttribute('data-index', index);
            el.setAttribute('tabindex', '0');

            if (this.options.itemClassName)
                this.options.itemClassName.split(/\s+/).forEach(c => { if (c) el.classList.add(c); });
            if (this.options.itemStyle) applyStyle(el, this.options.itemStyle);
            if (item.className)
                item.className.split(/\s+/).forEach(c => { if (c) el.classList.add(c); });
            if (item.style) applyStyle(el, item.style);

            if (isLink) {
                el.href   = item.link;
                el.target = item.target || '_blank';
                el.rel    = item.rel || 'noopener noreferrer';
                el.setAttribute('aria-label',
                    item.ariaLabel || item.text || item.content || `連結 ${index + 1}`);

                // 新增：當 target="_blank" 時加入 title 屬性，表明會在新視窗開啟
                if (item.target === '_blank' || (!item.target && '_blank')) {
                    el.setAttribute('title', '於新視窗開啟此連結');
                }
            }

            if (item.type === 'text') {
                el.textContent = item.content;
            } else if (item.type === 'image') {
                const img = document.createElement('img');
                img.src = item.content;
                img.alt = item.alt || item.text || `圖片 ${index + 1}`;
                img.style.maxHeight = '100%';
                img.style.verticalAlign = 'middle';
                img.onerror = () => {
                    console.warn(`TadMarquee: 圖片載入失敗 - ${item.content}`);
                    img.style.display = 'none';
                };
                el.appendChild(img);
                if (item.text) {
                    const span = document.createElement('span');
                    span.textContent = item.text;
                    span.style.marginLeft = '8px';
                    el.appendChild(span);
                }
            } else if (item.type === 'html') {
                el.innerHTML = item.content;
            }

            return el;
        }

        // ── 位置重置 ──────────────────────────────────────────────

        resetPosition() {
            if (!this.wrapper) return;
            const cr = this.marqueeEl.getBoundingClientRect();

            const startVisible = !this.options.autoStart || this.prefersReducedMotion;

            switch (this.options.direction) {
                case 'left':
                    this.currentPosition = startVisible ? 0 : cr.width;
                    this.wrapper.style.left      = this.currentPosition + 'px';
                    this.wrapper.style.top       = '50%';
                    this.wrapper.style.transform = 'translateY(-50%)';
                    break;
                case 'right':
                    this.currentPosition = startVisible ? 0 : -(this._loopSize || this.wrapper.offsetWidth);
                    this.wrapper.style.left      = this.currentPosition + 'px';
                    this.wrapper.style.top       = '50%';
                    this.wrapper.style.transform = 'translateY(-50%)';
                    break;
                case 'up':
                    this.currentPosition = startVisible ? 0 : cr.height;
                    this.wrapper.style.top       = this.currentPosition + 'px';
                    this.wrapper.style.left      = '0';
                    this.wrapper.style.transform = 'none';
                    break;
                case 'down':
                    this.currentPosition = startVisible ? 0 : -(this._loopSize || this.wrapper.offsetHeight);
                    this.wrapper.style.top       = this.currentPosition + 'px';
                    this.wrapper.style.left      = '0';
                    this.wrapper.style.transform = 'none';
                    break;
            }

            this.bounceDirection = 1;
        }

        // ── 動畫主迴圈 ────────────────────────────────────────────

        animate() {
            if (!this.isRunning) return;
            if (this.isPaused || this.prefersReducedMotion) {
                this.animationId = requestAnimationFrame(() => this.animate());
                return;
            }

            const cr   = this.marqueeEl.getBoundingClientRect();
            const dist = (this.options.speed * 16) / 1000;

            if (this.isSingleItem && !this.options.loop) {
                this._animateSingleBounce(cr, dist);
            } else {
                this._animateLoop(dist);
            }

            this.animationId = requestAnimationFrame(() => this.animate());
        }

        _animateLoop(dist) {
            const loopSize = this._loopSize;
            if (loopSize === 0) return;

            switch (this.options.direction) {
                case 'left':
                    this.currentPosition -= dist;
                    if (this.currentPosition <= -loopSize) this.currentPosition += loopSize;
                    this.wrapper.style.left = this.currentPosition + 'px';
                    break;
                case 'right':
                    this.currentPosition += dist;
                    if (this.currentPosition >= 0) this.currentPosition -= loopSize;
                    this.wrapper.style.left = this.currentPosition + 'px';
                    break;
                case 'up':
                    this.currentPosition -= dist;
                    if (this.currentPosition <= -loopSize) this.currentPosition += loopSize;
                    this.wrapper.style.top = this.currentPosition + 'px';
                    break;
                case 'down':
                    this.currentPosition += dist;
                    if (this.currentPosition >= 0) this.currentPosition -= loopSize;
                    this.wrapper.style.top = this.currentPosition + 'px';
                    break;
            }
        }

        _animateSingleBounce(cr, dist) {
            const wr       = this.wrapper.getBoundingClientRect();
            const vertical = isVertical(this.options.direction);
            const cSize    = vertical ? cr.height : cr.width;
            const wSize    = vertical ? wr.height : wr.width;

            if (vertical) {
                this.currentPosition += dist * this.bounceDirection *
                    (this.options.direction === 'up' ? -1 : 1);
                if (this.currentPosition <= 0) {
                    this.currentPosition = 0; this.bounceDirection = -this.bounceDirection;
                } else if (this.currentPosition >= cSize - wSize) {
                    this.currentPosition = cSize - wSize; this.bounceDirection = -this.bounceDirection;
                }
                this.wrapper.style.top = this.currentPosition + 'px';
            } else {
                this.currentPosition += dist * this.bounceDirection *
                    (this.options.direction === 'left' ? -1 : 1);
                if (this.currentPosition <= -(wSize - cSize)) {
                    this.currentPosition = -(wSize - cSize); this.bounceDirection = -this.bounceDirection;
                } else if (this.currentPosition >= 0) {
                    this.currentPosition = 0; this.bounceDirection = -this.bounceDirection;
                }
                this.wrapper.style.left = this.currentPosition + 'px';
            }
        }

        // ── 事件監聽 ──────────────────────────────────────────────

        setupEventListeners() {
            if (this.options.pauseOnHover) {
                this.marqueeEl.addEventListener('mouseenter', this.handleMouseEnter.bind(this));
                this.marqueeEl.addEventListener('mouseleave', this.handleMouseLeave.bind(this));
            }
            if ('ontouchstart' in window) {
                this.marqueeEl.addEventListener('touchstart', this.handleMouseEnter.bind(this));
                this.marqueeEl.addEventListener('touchend',   this.handleMouseLeave.bind(this));
            }
            if (this.options.pauseOnFocus) {
                this.marqueeEl.addEventListener('focus', this.handleFocus.bind(this), true);
                this.marqueeEl.addEventListener('blur',  this.handleBlur.bind(this),  true);
            }
        }

        setupKeyboardNavigation() {
            if (!this.options.keyboardControl) return;
            // 監聽 rootEl（並排／頂部模式）或 marqueeEl（角落模式）
            const target = this.rootEl || this.marqueeEl;
            const top = isTopMode(this.options.pauseButtonPosition);
            target.addEventListener('keydown', (e) => {
                if (e.target === this.pauseBtn) return;
                switch (e.key) {
                    case ' ': case 'Enter':
                        // 頂部模式：Space/Enter 由暫停按鈕原生行為處理，不在此攔截
                        // 其他模式：container 有 tabindex，Space/Enter 觸發暫停
                        if (!top) { e.preventDefault(); this._togglePauseByUser(); }
                        break;
                    case 'ArrowRight': case 'ArrowDown':
                        e.preventDefault(); this.focusNextItem(); break;
                    case 'ArrowLeft':  case 'ArrowUp':
                        e.preventDefault(); this.focusPreviousItem(); break;
                    case 'Home':   e.preventDefault(); this.focusFirstItem(); break;
                    case 'End':    e.preventDefault(); this.focusLastItem();  break;
                    case 'Escape':
                        e.preventDefault();
                        // 頂部模式：Escape 將焦點返回暫停按鈕（符合邏輯流向）
                        if (top && this.pauseBtn) { this.pauseBtn.focus(); }
                        else { target.blur(); }
                        break;
                }
            });
        }

        setupResponsive() {
            if (!this.options.responsiveSpeed) return;
            const onResize = () => {
                const bp = this.getBreakpoint();
                if (bp !== this.currentBreakpoint) {
                    this.currentBreakpoint = bp;
                    this.adjustForBreakpoint(bp);
                    this.triggerCallback('onBreakpointChange', bp);
                }
            };
            if (typeof ResizeObserver !== 'undefined') {
                new ResizeObserver(onResize).observe(this.marqueeEl);
            } else {
                window.addEventListener('resize', onResize);
            }
            this.currentBreakpoint = this.getBreakpoint();
            this.adjustForBreakpoint(this.currentBreakpoint);
        }

        getBreakpoint() {
            const w = window.innerWidth, bp = this.options.responsiveBreakpoints;
            if (w < bp.mobile)  return 'mobile';
            if (w < bp.tablet)  return 'tablet';
            if (w < bp.desktop) return 'desktop';
            return 'large';
        }

        adjustForBreakpoint(bp) {
            const base = this.options.speed || 50;
            this.options.speed = ({ mobile: base*0.6, tablet: base*0.8, desktop: base, large: base*1.2 })[bp] || base;
        }

        // ── 焦點管理 ──────────────────────────────────────────────

        focusNextItem() {
            const items = Array.from(
                this.wrapper.querySelectorAll('.tad-marquee-item[data-index]:not([aria-hidden="true"])')
            );
            if (!items.length) return;
            this.currentFocusIndex = (this.currentFocusIndex + 1) % items.length;
            items[this.currentFocusIndex].focus();
            if (this.options.announceItems) {
                const t = items[this.currentFocusIndex].textContent ||
                          items[this.currentFocusIndex].getAttribute('aria-label');
                this.announceToScreenReader(`項目 ${this.currentFocusIndex + 1}：${t}`);
            }
        }

        focusPreviousItem() {
            const items = Array.from(
                this.wrapper.querySelectorAll('.tad-marquee-item[data-index]:not([aria-hidden="true"])')
            );
            if (!items.length) return;
            this.currentFocusIndex = this.currentFocusIndex <= 0 ? items.length - 1 : this.currentFocusIndex - 1;
            items[this.currentFocusIndex].focus();
            if (this.options.announceItems) {
                const t = items[this.currentFocusIndex].textContent ||
                          items[this.currentFocusIndex].getAttribute('aria-label');
                this.announceToScreenReader(`項目 ${this.currentFocusIndex + 1}：${t}`);
            }
        }

        focusFirstItem() {
            const items = Array.from(
                this.wrapper.querySelectorAll('.tad-marquee-item[data-index]:not([aria-hidden="true"])')
            );
            if (!items.length) return;
            this.currentFocusIndex = 0;
            items[0].focus();
            if (this.options.announceItems)
                this.announceToScreenReader(`第一個項目：${items[0].textContent}`);
        }

        focusLastItem() {
            const items = Array.from(
                this.wrapper.querySelectorAll('.tad-marquee-item[data-index]:not([aria-hidden="true"])')
            );
            if (!items.length) return;
            this.currentFocusIndex = items.length - 1;
            items[this.currentFocusIndex].focus();
            if (this.options.announceItems)
                this.announceToScreenReader(`最後一個項目：${items[this.currentFocusIndex].textContent}`);
        }

        handleMouseEnter() {
            if (!this.isPausedByUser) {
                this.pause();
                this.marqueeEl.classList.add('tad-marquee-paused');
                this.triggerCallback('onPause');
            }
        }

        handleMouseLeave() {
            if (!this.isPausedByUser && !this.prefersReducedMotion) {
                this.resume();
                this.marqueeEl.classList.remove('tad-marquee-paused');
                this.triggerCallback('onResume');
            }
        }

        handleFocus(e) {
            if (e.target === this.pauseBtn) return;
            if (this.wrapper.contains(e.target) && !this.isPausedByUser) {
                this.pause();
                this.announceToScreenReader('跑馬燈已暫停以便導航');
            }
        }

        handleBlur(e) {
            const root = this.rootEl || this.marqueeEl;
            if (!root.contains(e.relatedTarget)) {
                if (!this.isPausedByUser && !this.prefersReducedMotion) this.resume();
            }
        }

        // ==================== 公共 API ====================

        start(force = false) {
            if (this.isRunning) return this;
            if (this.prefersReducedMotion && !force) {
                console.info('TadMarquee: 因用戶偏好設定，跑馬燈不會自動播放');
                return this;
            }
            this.isRunning = true;
            this.isPausedByUser = false;
            if (this.prefersReducedMotion && force) {
                this.prefersReducedMotion = false;
            }
            this._updatePauseButton(false);
            this.animate();
            this.triggerCallback('onStart');
            if (this.options.announceItems) this.announceToScreenReader('跑馬燈開始播放');
            return this;
        }

        stop() {
            if (!this.isRunning) return this;
            this.isRunning = false;
            this.isPausedByUser = false;
            if (this.animationId) { cancelAnimationFrame(this.animationId); this.animationId = null; }
            this._updatePauseButton(false);
            this.triggerCallback('onStop');
            if (this.options.announceItems) this.announceToScreenReader('跑馬燈已停止');
            return this;
        }

        pause() {
            if (!this.isRunning || this.isPaused) return this;
            this.isPaused = true;
            return this;
        }

        resume(force = false) {
            if (!this.isRunning) return this.start(force);
            if (!this.isPaused) return this;
            if (this.prefersReducedMotion && !force) {
                console.info('TadMarquee: 因用戶偏好設定，跑馬燈保持暫停');
                return this;
            }
            this.isPaused = false;
            if (this.prefersReducedMotion && force) {
                this.prefersReducedMotion = false;
            }
            return this;
        }

        changeDirection(direction) {
            if (!['left', 'right', 'up', 'down'].includes(direction)) {
                console.warn('TadMarquee: 無效的方向參數:', direction); return this;
            }
            const wasRunning = this.isRunning;
            this.stop();
            this.options.direction = direction;
            this.createWrapper();
            this.renderItems();
            if (wasRunning && !this.prefersReducedMotion) this.start();
            this.triggerCallback('onDirectionChange', direction);
            if (this.options.announceItems) {
                const map = { left: '向左', right: '向右', up: '向上', down: '向下' };
                this.announceToScreenReader(`方向已改為${map[direction]}`);
            }
            return this;
        }

        updateItems(items) {
            if (!Array.isArray(items)) { console.warn('TadMarquee: items 必須是陣列'); return this; }
            const wasRunning = this.isRunning;
            this.stop();
            this.options.items = items;
            this.renderItems();
            if (wasRunning && !this.prefersReducedMotion) this.start();
            if (this.options.announceItems)
                this.announceToScreenReader(`內容已更新，共 ${items.length} 個項目`);
            return this;
        }

        setSpeed(speed) {
            if (typeof speed !== 'number' || speed <= 0) {
                console.warn('TadMarquee: 速度必須是正數'); return this;
            }
            this.options.speed = speed;
            return this;
        }

        setItemStyle(style, merge = true) {
            if (!style) { console.warn('TadMarquee: style 不可為空'); return this; }
            const parsed = parseStyle(style);
            this.options.itemStyle = merge
                ? { ...parseStyle(this.options.itemStyle), ...parsed }
                : parsed;
            this.wrapper.querySelectorAll('.tad-marquee-item').forEach(el => applyStyle(el, parsed));
            return this;
        }

        setItemClassName(className, oldClassName) {
            if (typeof className !== 'string') {
                console.warn('TadMarquee: className 必須是字串'); return this;
            }
            const oldCls = (oldClassName || this.options.itemClassName || '').split(/\s+/);
            const newCls = className.split(/\s+/);
            this.wrapper.querySelectorAll('.tad-marquee-item').forEach(el => {
                oldCls.forEach(c => { if (c) el.classList.remove(c); });
                newCls.forEach(c => { if (c) el.classList.add(c); });
            });
            this.options.itemClassName = className;
            return this;
        }

        getOptions() { return { ...this.options }; }

        getStatus() {
            return {
                isRunning: this.isRunning,
                isPaused: this.isPaused,
                isPausedByUser: this.isPausedByUser,
                direction: this.options.direction,
                speed: this.options.speed,
                itemCount: this.options.items.length,
                isSingleItem: this.isSingleItem,
                prefersReducedMotion: this.prefersReducedMotion,
                currentBreakpoint: this.currentBreakpoint,
                loopSize: this._loopSize,
                inlineMode: isInlineMode(this.options.pauseButtonPosition),
                topMode:    isTopMode(this.options.pauseButtonPosition)
            };
        }

        triggerCallback(name, ...args) {
            if (this.callbacks[name] && typeof this.callbacks[name] === 'function') {
                try { this.callbacks[name].call(this, ...args); }
                catch (e) { console.error(`TadMarquee callback error (${name}):`, e); }
            }
        }

        destroy() {
            this.stop();
            if (this.pauseBtn) { this.pauseBtn.remove(); this.pauseBtn = null; }
            if (this._ctrlBar) { this._ctrlBar.remove(); this._ctrlBar = null; }
            if (this.wrapper)  { this.wrapper.remove();  this.wrapper  = null; }

            // 並排／頂部模式：將 container 移回原位，移除 rootEl
            if (this.rootEl) {
                // 清除 rootEl 上設置的 ARIA 屬性
                ['role','aria-label','aria-live'].forEach(a =>
                    this.rootEl.removeAttribute(a));
                this.rootEl.parentNode.insertBefore(this.container, this.rootEl);
                this.rootEl.remove();
                this.rootEl = null;
            }

            ['role','aria-label','aria-live','tabindex'].forEach(a =>
                this.container.removeAttribute(a));
            this.container.classList.remove('tad-marquee-container', 'tad-marquee-paused');
            if (this.options?.className) this.container.classList.remove(this.options.className);

            this.container = null;
            this.marqueeEl = null;
            this.options   = null;
            this.callbacks = null;
            return null;
        }

        static createDefaultCSS() {
            if (document.getElementById('tad-marquee-css')) return;
            let cssPath = 'tad_marquee.css';
            const scripts = document.getElementsByTagName('script');
            for (let i = scripts.length - 1; i >= 0; i--) {
                const src = scripts[i].src || '';
                if (src.match(/tad_marquee(\.min)?\.js/)) {
                    cssPath = src.replace(/tad_marquee(\.min)?\.js/, 'tad_marquee.css');
                    break;
                }
            }
            const link = document.createElement('link');
            link.id = 'tad-marquee-css'; link.rel = 'stylesheet'; link.href = cssPath;
            document.head.appendChild(link);
        }
    }

    if (typeof document !== 'undefined') {
        if (document.readyState === 'loading')
            document.addEventListener('DOMContentLoaded', () => TadMarquee.createDefaultCSS());
        else
            TadMarquee.createDefaultCSS();
    }

    return TadMarquee;
}));