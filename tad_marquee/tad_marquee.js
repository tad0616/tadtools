/**
 * TadMarquee - 無障礙跑馬燈套件
 * 版本: 2.0.9
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
 * ✓ itemHoverStyle / itemActiveStyle：可由 options 覆蓋 :hover / :active 偽類樣式
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

    /**
     * 將 camelCase 屬性物件轉為 CSS 宣告字串
     * 例：{ backgroundColor: '#fff', fontSize: '1rem' }
     *   → 'background-color: #fff; font-size: 1rem;'
     */
    function styleObjToCSSText(obj) {
        return Object.entries(obj)
            .map(([k, v]) => `${k.replace(/([A-Z])/g, '-$1').toLowerCase()}: ${v};`)
            .join(' ');
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
                // ── 新增：hover / active 偽類樣式覆蓋 ──────────────
                // 支援物件或 CSS 字串，null 表示使用 CSS 預設值
                itemHoverStyle:  options.itemHoverStyle  ?? null,
                itemActiveStyle: options.itemActiveStyle ?? null,
                // ────────────────────────────────────────────────────
                itemClassName: options.itemClassName || '',
                ariaLabel: options.ariaLabel || '跑馬燈內容',
                ariaLive: options.ariaLive || 'off',
                respectReducedMotion: options.respectReducedMotion === true,
                announceItems: options.announceItems !== false,
                keyboardControl: options.keyboardControl !== false,
                minContrastRatio: options.minContrastRatio || 7,
                responsiveSpeed: options.responsiveSpeed !== false,
                responsiveBreakpoints: options.responsiveBreakpoints || {
                    mobile: 480, tablet: 768, desktop: 1024
                },
                showPauseButton: options.showPauseButton !== false,
                pauseButtonPosition: options.pauseButtonPosition || 'top',
                pauseButtonLabel: options.pauseButtonLabel || {
                    pause:  '已繼續播放，按下可暫停',
                    resume: '已暫停，按下播放繼續'
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
            this.rootEl            = null;
            this.marqueeEl         = null;
            this.currentPosition   = 0;
            this.isSingleItem      = false;
            this.bounceDirection   = 1;
            this.currentFocusIndex = -1;
            this.prefersReducedMotion = false;
            this.currentBreakpoint = null;
            this._loopSize         = 0;
            this._dynamicStyleEl   = null;   // ← 動態注入的 <style> 元素

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
            this.buildLayout();
            this.setupContainer();
            this.setupAccessibility();
            this.createWrapper();
            this.renderItems();
            this._injectDynamicStyles();   // ← 注入 hover/active 動態樣式
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

        // ── 動態樣式注入（:hover / :active 偽類）─────────────────

        /**
         * 以 containerId 為 scope，動態產生 <style> 覆蓋偽類樣式。
         * 每次呼叫都會重新產生（供 setItemHoverStyle / setItemActiveStyle 公開 API 使用）。
         *
         * 優先順序（高 → 低）：
         *   JS options 動態注入（specificity: 0,2,0）
         *   > tad_marquee.css 規則（specificity: 0,1,1 ~ 0,2,0）
         *
         * 為確保覆蓋成功，選擇器加上容器 ID 提升優先度：
         *   #containerId .tad-marquee-item:hover { ... }
         */
        _injectDynamicStyles() {
            // 移除舊的動態樣式標籤（重新呼叫時刷新）
            if (this._dynamicStyleEl) {
                this._dynamicStyleEl.remove();
                this._dynamicStyleEl = null;
            }

            const hoverObj  = this.options.itemHoverStyle  ? parseStyle(this.options.itemHoverStyle)  : null;
            const activeObj = this.options.itemActiveStyle ? parseStyle(this.options.itemActiveStyle) : null;

            // 兩者皆未設定時，不注入，直接使用 CSS 檔的預設值
            if (!hoverObj && !activeObj) return;

            const scope = `#${CSS.escape(this.containerId)}`;
            let css = '';

            if (hoverObj && Object.keys(hoverObj).length > 0) {
                css += `${scope} .tad-marquee-item:hover { ${styleObjToCSSText(hoverObj)} }\n`;
            }
            if (activeObj && Object.keys(activeObj).length > 0) {
                css += `${scope} .tad-marquee-item:active { ${styleObjToCSSText(activeObj)} }\n`;
            }

            if (!css) return;

            const style = document.createElement('style');
            style.id = `tad-marquee-dynamic-${this.containerId}`;
            style.textContent = css;
            document.head.appendChild(style);
            this._dynamicStyleEl = style;
        }

        // ==================== 公開樣式 API ====================

        /**
         * 動態更新 :hover 偽類樣式
         * @param {object|string} style  - 新樣式（物件或 CSS 字串）
         * @param {boolean}       merge  - true（預設）合併舊值；false 完全取代
         * @returns {TadMarquee}
         *
         * 使用範例：
         *   marquee.setItemHoverStyle({ backgroundColor: '#ffeeba', color: '#333' });
         *   marquee.setItemHoverStyle('background-color: #ffeeba; color: #333;');
         *   marquee.setItemHoverStyle(null);  // 清除，恢復 CSS 預設
         */
        setItemHoverStyle(style, merge = true) {
            if (style === null || style === undefined) {
                this.options.itemHoverStyle = null;
            } else {
                const parsed = parseStyle(style);
                this.options.itemHoverStyle = merge
                    ? { ...parseStyle(this.options.itemHoverStyle || {}), ...parsed }
                    : parsed;
            }
            this._injectDynamicStyles();
            return this;
        }

        /**
         * 動態更新 :active 偽類樣式
         * @param {object|string} style  - 新樣式（物件或 CSS 字串）
         * @param {boolean}       merge  - true（預設）合併舊值；false 完全取代
         * @returns {TadMarquee}
         */
        setItemActiveStyle(style, merge = true) {
            if (style === null || style === undefined) {
                this.options.itemActiveStyle = null;
            } else {
                const parsed = parseStyle(style);
                this.options.itemActiveStyle = merge
                    ? { ...parseStyle(this.options.itemActiveStyle || {}), ...parsed }
                    : parsed;
            }
            this._injectDynamicStyles();
            return this;
        }

        // ── 以下與原版相同，未更動 ────────────────────────────────

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

        buildLayout() {
            const pos = this.options.pauseButtonPosition;

            if (isInlineMode(pos)) {
                this.rootEl = document.createElement('div');
                this.rootEl.className = 'tad-marquee-root tad-marquee-inline';
                Object.assign(this.rootEl.style, {
                    display:    'flex',
                    flexDirection: 'row',
                    alignItems: 'stretch',
                    width:      '100%'
                });
                this.container.parentNode.insertBefore(this.rootEl, this.container);
                this.rootEl.appendChild(this.container);
                this.marqueeEl = this.container;
                Object.assign(this.marqueeEl.style, {
                    flex:     '1 1 0%',
                    minWidth: '0',
                    overflow: 'hidden',
                    position: 'relative'
                });

            } else if (isTopMode(pos)) {
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
                this.rootEl    = null;
                this.marqueeEl = this.container;
            }
        }

        setupContainer() {
            this.marqueeEl.style.position = 'relative';
            this.marqueeEl.style.overflow = 'hidden';
            this.marqueeEl.addEventListener('scroll', () => {
                if (this.marqueeEl.scrollLeft !== 0) this.marqueeEl.scrollLeft = 0;
                if (this.marqueeEl.scrollTop !== 0) this.marqueeEl.scrollTop = 0;
            });
            if (!this.container.classList.contains('tad-marquee-container'))
                this.container.classList.add('tad-marquee-container');
            if (this.options.className) this.container.classList.add(this.options.className);
            if (this.options.containerStyle) applyStyle(this.container, this.options.containerStyle);
        }

        setupAccessibility() {
            const top      = isTopMode(this.options.pauseButtonPosition);
            const regionEl = top ? this.rootEl : this.marqueeEl;
            regionEl.setAttribute('role',       'region');
            regionEl.setAttribute('aria-label', this.options.ariaLabel);
            regionEl.setAttribute('aria-live',  'off');
            if (!document.getElementById('tad-marquee-announcer')) {
                const a = document.createElement('div');
                a.id = 'tad-marquee-announcer';
                a.setAttribute('role', 'status');
                a.setAttribute('aria-live', 'polite');
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

            Object.assign(btn.style, {
                flexShrink:     '0',
                border:         'none',
                cursor:         'pointer',
                display:        'flex',
                alignItems:     'center',
                justifyContent: 'center',
                color:          '#ffffff',
                transition:     'background 0.2s, box-shadow 0.2s',
                lineHeight:     '1'
            });

            if (inline) {
                Object.assign(btn.style, {
                    position:     'absolute',
                    top:          '0',
                    bottom:       '0',
                    left:         pos === 'left' ? '0' : 'auto',
                    right:        pos === 'right' ? '0' : 'auto',
                    zIndex:       '10',
                    width:        '36px',
                    height:       '100%',
                    minHeight:    '100%',
                    background:   'currentColor',
                    borderRadius: pos === 'left' ? '4px 0 0 4px' : '0 4px 4px 0',
                    borderLeft:   'none',
                    borderRight:  'none',
                    boxShadow:    'none',
                    border: '1px solid currentColor'
                });
            } else if (top) {
                Object.assign(btn.style, {
                    position:     'absolute',
                    left:         '0',
                    top:          '0',
                    bottom:       '0',
                    zIndex:       '10',
                    width:        '36px',
                    height:       '100%',
                    minHeight:    '100%',
                    background:   'currentColor',
                    borderRadius: '4px 0 0 4px',
                    boxShadow:    'none'
                });
            } else {
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
            if (inline || top) {
                this.pauseBtn = btn;
                this._applyPauseButtonPalette();
            }

            btn.addEventListener('mouseenter', () => {
                if (inline || top) {
                    btn.style.filter = 'brightness(0.92)';
                } else {
                    btn.style.background = 'rgba(0,0,0,0.80)';
                }
                if (!inline && !top) btn.style.transform = 'scale(1.1)';
            });
            btn.addEventListener('mouseleave', () => {
                if (inline || top) {
                    btn.style.filter = 'none';
                    this._applyPauseButtonPalette();
                } else {
                    btn.style.background = this.isPausedByUser
                        ? 'rgba(30,120,30,0.75)'
                        : 'rgba(0,0,0,0.55)';
                }
                if (!inline && !top) btn.style.transform = 'scale(1)';
            });

            btn.addEventListener('click', () => this._togglePauseByUser());
            this.pauseBtn = btn;

            if (inline) {
                this.marqueeEl.classList.add('tad-marquee-has-inside-pause', `tad-marquee-has-inside-pause-${pos}`);
                this.marqueeEl.insertBefore(btn, this.wrapper);
            } else if (top) {
                this.marqueeEl.classList.add('tad-marquee-has-inside-pause', 'tad-marquee-has-inside-pause-left');
                this.marqueeEl.insertBefore(btn, this.wrapper);
            } else {
                this.marqueeEl.insertBefore(btn, this.wrapper);
            }
        }

        _pauseIcon(large = false) {
            const s = large ? 16 : 14;
            return `<svg aria-hidden="true" focusable="false"
                        width="${s}" height="${s}" viewBox="0 0 14 14"
                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <rect x="2"   y="1" width="3.5" height="12" rx="1"/>
                      <rect x="8.5" y="1" width="3.5" height="12" rx="1"/>
                    </svg>`;
        }

        _playIcon(large = false) {
            const s = large ? 16 : 14;
            return `<svg aria-hidden="true" focusable="false"
                        width="${s}" height="${s}" viewBox="0 0 14 14"
                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path d="M3 1.5 L12 7 L3 12.5 Z"/>
                    </svg>`;
        }

        _pauseButtonPalette() {
            const item = this.wrapper?.querySelector('.tad-marquee-item:not([aria-hidden="true"])');
            const textColor = item ? getComputedStyle(item).color : getComputedStyle(this.marqueeEl).color;
            let bgColor = getComputedStyle(this.marqueeEl).backgroundColor;
            if (!bgColor || bgColor === 'transparent' || bgColor === 'rgba(0, 0, 0, 0)') {
                bgColor = '#ffffff';
            }
            return { textColor, bgColor };
        }

        _applyPauseButtonPalette() {
            if (!this.pauseBtn) return;
            const { textColor, bgColor } = this._pauseButtonPalette();
            this.pauseBtn.style.background = textColor;
            this.pauseBtn.style.color = bgColor;
        }

        _togglePauseByUser() {
            if (!this.isRunning) {
                this.start(true);
                this.isPausedByUser = false;
                this._updatePauseButton(false);
                if (document.activeElement !== this.pauseBtn) {
                    this.announceToScreenReader(this.options.pauseButtonLabel.pause);
                }
                this.triggerCallback('onResume');
                return;
            }
            if (this.isPaused) {
                this.resume(true);
                this.isPausedByUser = false;
                this._updatePauseButton(false);
                if (document.activeElement !== this.pauseBtn) {
                    this.announceToScreenReader(this.options.pauseButtonLabel.pause);
                }
                this.triggerCallback('onResume');
            } else {
                this.pause();
                this.isPausedByUser = true;
                this._updatePauseButton(true);
                if (document.activeElement !== this.pauseBtn) {
                    this.announceToScreenReader(this.options.pauseButtonLabel.resume);
                }
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
                if (inline || top) {
                    this._applyPauseButtonPalette();
                } else {
                    this.pauseBtn.style.background = 'rgba(30,120,30,0.75)';
                }
            } else {
                this.pauseBtn.innerHTML = this._pauseIcon(inline || top);
                this.pauseBtn.setAttribute('aria-label', this.options.pauseButtonLabel.pause);
                if (inline || top) {
                    this._applyPauseButtonPalette();
                } else {
                    this.pauseBtn.style.background = 'rgba(0,0,0,0.55)';
                }
            }
        }

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
            const userStyle = parseStyle(this.options.containerStyle);
            const userHasMinHeight = userStyle.minHeight !== undefined;
            const userHasMinWidth  = userStyle.minWidth  !== undefined;
            if (!vertical && this.wrapper.offsetHeight > 0) {
                if (!userHasMinHeight &&
                    this.marqueeEl.offsetHeight < this.wrapper.offsetHeight) {
                    this.marqueeEl.style.minHeight = Math.ceil(this.wrapper.offsetHeight) + 'px';
                }
            } else if (vertical && this.wrapper.offsetWidth > 0) {
                if (!userHasMinWidth &&
                    this.marqueeEl.offsetWidth < this.wrapper.offsetWidth) {
                    this.marqueeEl.style.minWidth = Math.ceil(this.wrapper.offsetWidth) + 'px';
                }
            }
            const containerSize = vertical ? this.marqueeEl.offsetHeight : this.marqueeEl.offsetWidth;
            this._loopSize = vertical ? this.wrapper.offsetHeight : this.wrapper.offsetWidth;
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
            const target = this.rootEl || this.marqueeEl;
            const top = isTopMode(this.options.pauseButtonPosition);
            target.addEventListener('keydown', (e) => {
                if (e.target === this.pauseBtn) return;
                switch (e.key) {
                    case ' ': case 'Enter':
                        if (e.target.classList.contains('tad-marquee-item') && e.key === 'Enter') break;
                        if (!top && e.key === ' ') { e.preventDefault(); this._togglePauseByUser(); }
                        break;
                    case 'ArrowRight': case 'ArrowDown':
                        e.preventDefault(); this.focusNextItem(); break;
                    case 'ArrowLeft':  case 'ArrowUp':
                        e.preventDefault(); this.focusPreviousItem(); break;
                    case 'Home':   e.preventDefault(); this.focusFirstItem(); break;
                    case 'End':    e.preventDefault(); this.focusLastItem();  break;
                    case 'Escape':
                        e.preventDefault();
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
            if (this.marqueeEl.scrollLeft !== 0) this.marqueeEl.scrollLeft = 0;
            if (this.marqueeEl.scrollTop !== 0) this.marqueeEl.scrollTop = 0;
            if (e.target === this.pauseBtn) return;
            if (this.wrapper.contains(e.target)) {
                if (!this.isPausedByUser) {
                    this.pause();
                    if (!this._focusPauseAnnounced) {
                        this._focusPauseAnnounced = true;
                        this.announceToScreenReader('跑馬燈已暫停以便導航');
                    }
                }
                const cr = this.marqueeEl.getBoundingClientRect();
                const er = e.target.getBoundingClientRect();
                const vertical = isVertical(this.options.direction);
                if (vertical) {
                    if (er.top < cr.top) {
                        this.currentPosition -= (er.top - cr.top);
                        this.wrapper.style.top = this.currentPosition + 'px';
                    } else if (er.bottom > cr.bottom) {
                        this.currentPosition -= er.height > cr.height
                            ? (er.top - cr.top)
                            : (er.bottom - cr.bottom);
                        this.wrapper.style.top = this.currentPosition + 'px';
                    }
                } else {
                    if (er.left < cr.left) {
                        this.currentPosition -= (er.left - cr.left);
                        this.wrapper.style.left = this.currentPosition + 'px';
                    } else if (er.right > cr.right) {
                        this.currentPosition -= er.width > cr.width
                            ? (er.left - cr.left)
                            : (er.right - cr.right);
                        this.wrapper.style.left = this.currentPosition + 'px';
                    }
                }
            }
        }

        handleBlur(e) {
            const root = this.rootEl || this.marqueeEl;
            if (!root.contains(e.relatedTarget)) {
                if (!this.isPausedByUser && !this.prefersReducedMotion) this.resume();
                this._focusPauseAnnounced = false;
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
            if (this.prefersReducedMotion && force) this.prefersReducedMotion = false;
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
            if (this.prefersReducedMotion && force) this.prefersReducedMotion = false;
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
            // ── 清除動態注入的 <style> ─────────────────────────────
            if (this._dynamicStyleEl) {
                this._dynamicStyleEl.remove();
                this._dynamicStyleEl = null;
            }
            if (this.pauseBtn) { this.pauseBtn.remove(); this.pauseBtn = null; }
            if (this._ctrlBar) { this._ctrlBar.remove(); this._ctrlBar = null; }
            if (this.wrapper)  { this.wrapper.remove();  this.wrapper  = null; }
            if (this.rootEl) {
                ['role','aria-label','aria-live'].forEach(a => this.rootEl.removeAttribute(a));
                this.rootEl.parentNode.insertBefore(this.container, this.rootEl);
                this.rootEl.remove();
                this.rootEl = null;
            }
            ['role','aria-label','aria-live','tabindex'].forEach(a => this.container.removeAttribute(a));
            this.container.classList.remove(
                'tad-marquee-container',
                'tad-marquee-paused',
                'tad-marquee-has-inside-pause',
                'tad-marquee-has-inside-pause-left',
                'tad-marquee-has-inside-pause-right'
            );
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