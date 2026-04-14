/**
 * Tad Carousel v1.0.0
 * 現代化、無障礙輪播元件
 * WCAG 2.3 AAA 相容
 *
 * @license MIT
 */

(function (global, factory) {
    // 支援多種模組系統
    if (typeof module === 'object' && typeof module.exports === 'object') {
        // CommonJS
        module.exports = factory();
    } else if (typeof define === 'function' && define.amd) {
        // AMD
        define(factory);
    } else {
        // 瀏覽器全域變數
        global.TadCarousel = factory();
    }
})(typeof window !== 'undefined' ? window : this, function () {
    'use strict';

    // ===== 預設設定 =====
    var DEFAULTS = {
        items: 1,                    // 每頁顯示項目數
        gap: 16,                     // 項目間距 (px)
        loop: false,                 // 是否循環播放
        autoplay: false,             // 是否自動播放
        autoplayTimeout: 5000,       // 自動播放間隔 (ms)
        autoplayPauseOnHover: true,  // 滑鼠懸停時暫停
        nav: true,                   // 是否顯示導航按鈕
        dots: true,                  // 是否顯示分頁指示器
        startIndex: 0,               // 起始索引
        responsive: null,            // 響應式設定
        rtl: false,                  // 是否從右到左
        touchDrag: true,             // 是否支援觸控拖曳
        mouseDrag: true,             // 是否支援滑鼠拖曳
        dragThreshold: 50,           // 拖曳觸發閾值 (px)

        // 無障礙設定
        a11y: {
            prevText: '上一張',
            nextText: '下一張',
            dotText: '前往第 %d 張',
            slideText: '第 %d 張，共 %t 張',
            pauseText: '暫停自動播放',
            playText: '開始自動播放',
            carouselLabel: '輪播區域'
        },

        // 回呼函式
        onInit: null,
        onChange: null,
        onChanged: null,
        onDrag: null,
        onDragged: null
    };

    // ===== 工具函式 =====
    function extend(target, source) {
        var result = {};
        for (var key in target) {
            if (target.hasOwnProperty(key)) {
                result[key] = target[key];
            }
        }
        for (var key in source) {
            if (source.hasOwnProperty(key)) {
                if (typeof source[key] === 'object' && source[key] !== null && !Array.isArray(source[key])) {
                    result[key] = extend(target[key] || {}, source[key]);
                } else {
                    result[key] = source[key];
                }
            }
        }
        return result;
    }

    function formatText(template) {
        var args = Array.prototype.slice.call(arguments, 1);
        var result = template;
        args.forEach(function (arg, index) {
            result = result.replace(index === 0 ? '%d' : '%t', arg);
        });
        return result;
    }

    // ===== TadCarousel 建構函式 =====
    function TadCarousel(element, options) {
        // 取得元素
        this.element = typeof element === 'string'
            ? document.querySelector(element)
            : element;

        if (!this.element) {
            console.error('TadCarousel: 找不到指定元素');
            return;
        }

        // 合併設定
        this.options = extend(DEFAULTS, options || {});

        // 內部狀態
        this.state = {
            currentIndex: this.options.startIndex,
            itemCount: 0,
            itemsPerPage: this.options.items,
            isAnimating: false,
            isDragging: false,
            isAutoplayPaused: false,
            autoplayTimer: null,
            dragStart: { x: 0, y: 0 },
            dragDelta: 0,
            touchStartTime: 0
        };

        // DOM 元素參照
        this.dom = {};

        // ResizeObserver 參照
        this._resizeObserver = null;

        // 綁定方法的 this 上下文
        this._onDragStartBound = this._onDragStart.bind(this);
        this._onDragMoveBound = this._onDragMove.bind(this);
        this._onDragEndBound = this._onDragEnd.bind(this);
        this._handleKeydownBound = this._handleKeydown.bind(this);
        this._onVisibilityChangeBound = this._onVisibilityChange.bind(this);

        // 初始化
        this._init();
    }

    // ===== 原型方法 =====
    TadCarousel.prototype = {
        constructor: TadCarousel,

        // ----- 初始化 -----
        _init: function () {
            this._buildStructure();
            this._setupA11y();
            this._bindEvents();
            this._updateResponsive();
            this._goTo(this.state.currentIndex, false);
            this._emit('onInit');
        },

        _buildStructure: function () {
            var self = this;
            var options = this.options;
            var element = this.element;

            // 取得原始項目
            var originalItems = Array.prototype.slice.call(element.children);
            this.state.itemCount = originalItems.length;

            // 清空並重建結構
            element.innerHTML = '';
            element.classList.add('tad-carousel');

            // 建立軌道容器
            var trackContainer = document.createElement('div');
            trackContainer.className = 'tad-carousel__track-container';

            // 建立軌道
            var track = document.createElement('ul');
            track.className = 'tad-carousel__track';
            track.setAttribute('role', 'list');
            track.style.setProperty('--tad-carousel-gap', options.gap + 'px');

            // 建立項目
            originalItems.forEach(function (item, index) {
                var li = document.createElement('li');
                li.className = 'tad-carousel__item';
                li.setAttribute('role', 'group');
                li.setAttribute('aria-roledescription', '投影片');
                li.setAttribute('aria-label', formatText(options.a11y.slideText, index + 1, self.state.itemCount));
                li.appendChild(item);
                track.appendChild(li);
            });

            // ── WCAG 2.4.3 焦點順序修正 ─────────────────────────────────────────
            // 依據「左至右、由上而下」鍵盤遊走順序，自動播放的「暫停／播放」
            // 按鈕必須是進入輪播後第一個獲得焦點的互動元件。
            // 因此先將 autoplayToggle 附加至 DOM，後續元件才依序插入。
            // 視覺位置（右上角）由 CSS position:absolute 維持，不受 DOM 順序影響。
            // ────────────────────────────────────────────────────────────────────
            if (options.autoplay) {
                this._buildAutoplayToggle();
            }

            trackContainer.appendChild(track);
            element.appendChild(trackContainer);

            // 儲存 DOM 參照
            this.dom.trackContainer = trackContainer;
            this.dom.track = track;
            this.dom.items = Array.prototype.slice.call(track.children);

            // 建立導航
            if (options.nav) {
                this._buildNav();
            }

            // 建立分頁指示器
            if (options.dots) {
                this._buildDots();
            }

            // 建立即時區域（螢幕閱讀器）
            this._buildLiveRegion();
        },

        _buildNav: function () {
            var self = this;
            var options = this.options;
            var element = this.element;

            // 上一張按鈕
            var prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.className = 'tad-carousel__nav tad-carousel__nav--prev';
            prevBtn.setAttribute('aria-label', options.a11y.prevText);
            prevBtn.innerHTML =
                '<svg class="tad-carousel__nav-icon" viewBox="0 0 24 24" aria-hidden="true">' +
                '<path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>' +
                '</svg>';

            // 下一張按鈕
            var nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.className = 'tad-carousel__nav tad-carousel__nav--next';
            nextBtn.setAttribute('aria-label', options.a11y.nextText);
            nextBtn.innerHTML =
                '<svg class="tad-carousel__nav-icon" viewBox="0 0 24 24" aria-hidden="true">' +
                '<path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z"/>' +
                '</svg>';

            element.appendChild(prevBtn);
            element.appendChild(nextBtn);

            this.dom.prevBtn = prevBtn;
            this.dom.nextBtn = nextBtn;
        },

        _buildDots: function () {
            var self = this;
            var options = this.options;
            var element = this.element;
            var state = this.state;

            var pageCount = this._getPageCount();

            var dotsContainer = document.createElement('div');
            dotsContainer.className = 'tad-carousel__dots';
            dotsContainer.setAttribute('role', 'tablist');
            dotsContainer.setAttribute('aria-label', '投影片選擇');

            for (var i = 0; i < pageCount; i++) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'tad-carousel__dot';
                dot.setAttribute('role', 'tab');
                dot.setAttribute('aria-selected', i === state.currentIndex ? 'true' : 'false');
                dot.setAttribute('aria-label', formatText(options.a11y.dotText, i + 1));
                dot.setAttribute('tabindex', i === state.currentIndex ? '0' : '-1');
                dot.setAttribute('data-index', i);
                dotsContainer.appendChild(dot);
            }

            element.appendChild(dotsContainer);
            this.dom.dotsContainer = dotsContainer;
            this.dom.dots = Array.prototype.slice.call(dotsContainer.children);
        },

        _buildAutoplayToggle: function () {
            var options = this.options;
            var element = this.element;

            var toggle = document.createElement('button');
            toggle.type = 'button';
            toggle.className = 'tad-carousel__autoplay-toggle';
            toggle.setAttribute('aria-label', options.a11y.pauseText);
            toggle.setAttribute('aria-pressed', 'false');
            toggle.innerHTML =
                '<svg class="tad-carousel__nav-icon" viewBox="0 0 24 24" aria-hidden="true">' +
                '<path class="pause-icon" d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>' +
                '<path class="play-icon" d="M8 5v14l11-7z" style="display:none"/>' +
                '</svg>';

            element.appendChild(toggle);
            this.dom.autoplayToggle = toggle;
        },

        _buildLiveRegion: function () {
            var liveRegion = document.createElement('div');
            liveRegion.className = 'tad-carousel__live-region';
            liveRegion.setAttribute('aria-live', 'off'); // 從 'polite' 改為 'off'
            liveRegion.setAttribute('aria-atomic', 'true');
            this.element.appendChild(liveRegion);
            this.dom.liveRegion = liveRegion;
        },

        _setupA11y: function () {
            var element = this.element;
            var options = this.options;

            element.setAttribute('role', 'region');
            element.setAttribute('aria-roledescription', '輪播');
            element.setAttribute('aria-label', options.a11y.carouselLabel);

            // WCAG 2.4.3 焦點順序修正：
            // 容器本身不應成為 Tab 停駐點，焦點應直接落在第一個互動子元件（暫停/播放鈕）。
            // 移除原本設定於容器的 tabindex="0"，避免產生多餘的焦點停駐。
            element.removeAttribute('tabindex');
        },

        // ----- 事件綁定 -----
        _bindEvents: function () {
            var self = this;
            var options = this.options;
            var dom = this.dom;

            // 導航按鈕事件
            if (options.nav) {
                dom.prevBtn.addEventListener('click', function () {
                    self.prev();
                });
                dom.nextBtn.addEventListener('click', function () {
                    self.next();
                });
            }

            // 分頁指示器事件
            if (options.dots && dom.dots) {
                dom.dots.forEach(function (dot, index) {
                    dot.addEventListener('click', function () {
                        self.goTo(index);
                    });
                    dot.addEventListener('keydown', function (e) {
                        self._handleDotKeydown(e, index);
                    });
                });
            }

            // 自動播放控制
            if (options.autoplay && dom.autoplayToggle) {
                dom.autoplayToggle.addEventListener('click', function () {
                    self.toggleAutoplay();
                });

                if (options.autoplayPauseOnHover) {
                    this.element.addEventListener('mouseenter', function () {
                        self._pauseAutoplay();
                    });
                    this.element.addEventListener('mouseleave', function () {
                        self._resumeAutoplay();
                    });
                    this.element.addEventListener('focusin', function () {
                        self._pauseAutoplay();
                    });
                    this.element.addEventListener('focusout', function () {
                        self._resumeAutoplay();
                    });
                }

                this._startAutoplay();
            }

            // 觸控/滑鼠拖曳
            if (options.touchDrag || options.mouseDrag) {
                this._bindDragEvents();
            }

            // 鍵盤導航
            this.element.addEventListener('keydown', this._handleKeydownBound);

            // 響應式更新
            if (typeof ResizeObserver !== 'undefined') {
                this._resizeObserver = new ResizeObserver(function () {
                    self._updateResponsive();
                    self._updateLayout();
                });
                this._resizeObserver.observe(this.element);
            } else {
                // 降級方案：使用 resize 事件
                window.addEventListener('resize', function () {
                    self._updateResponsive();
                    self._updateLayout();
                });
            }

            // 視窗可見性變化
            document.addEventListener('visibilitychange', this._onVisibilityChangeBound);
        },

        _bindDragEvents: function () {
            var options = this.options;
            var track = this.dom.track;

            // 觸控事件
            if (options.touchDrag) {
                track.addEventListener('touchstart', this._onDragStartBound, { passive: true });
                track.addEventListener('touchmove', this._onDragMoveBound, { passive: false });
                track.addEventListener('touchend', this._onDragEndBound);
                track.addEventListener('touchcancel', this._onDragEndBound);
            }

            // 滑鼠事件
            if (options.mouseDrag) {
                track.addEventListener('mousedown', this._onDragStartBound);
                document.addEventListener('mousemove', this._onDragMoveBound);
                document.addEventListener('mouseup', this._onDragEndBound);
            }
        },

        _onVisibilityChange: function () {
            if (document.hidden) {
                this._pauseAutoplay();
            } else {
                this._resumeAutoplay();
            }
        },

        // ----- 拖曳處理 -----
        _onDragStart: function (e) {
            if (this.state.isAnimating) return;

            var point = e.touches ? e.touches[0] : e;

            this.state.isDragging = true;
            this.state.dragStart = { x: point.clientX, y: point.clientY };
            this.state.dragDelta = 0;
            this.state.touchStartTime = Date.now();

            this.dom.track.style.transition = 'none';
            this.element.setAttribute('aria-busy', 'true');

            this._emit('onDrag');
        },

        _onDragMove: function (e) {
            if (!this.state.isDragging) return;

            var point = e.touches ? e.touches[0] : e;
            var deltaX = point.clientX - this.state.dragStart.x;
            var deltaY = point.clientY - this.state.dragStart.y;

            // 判斷是水平還是垂直滑動
            if (Math.abs(deltaX) > Math.abs(deltaY)) {
                e.preventDefault();
                this.state.dragDelta = deltaX;

                var currentOffset = this._getOffset(this.state.currentIndex);
                this.dom.track.style.transform = 'translateX(' + (currentOffset + deltaX) + 'px)';
            }
        },

        _onDragEnd: function (e) {
            if (!this.state.isDragging) return;

            this.state.isDragging = false;
            this.element.removeAttribute('aria-busy');
            this.dom.track.style.transition = '';

            var dragDelta = this.state.dragDelta;
            var touchStartTime = this.state.touchStartTime;
            var currentIndex = this.state.currentIndex;
            var dragThreshold = this.options.dragThreshold;
            var elapsed = Date.now() - touchStartTime;

            // 快速滑動或超過閾值
            var isQuickSwipe = elapsed < 300 && Math.abs(dragDelta) > 30;
            var isOverThreshold = Math.abs(dragDelta) > dragThreshold;

            if (isQuickSwipe || isOverThreshold) {
                if (dragDelta > 0) {
                    this.prev();
                } else {
                    this.next();
                }
            } else {
                // 回彈到原位
                this._goTo(currentIndex, true);
            }

            this._emit('onDragged');
        },

        // ----- 鍵盤處理 -----
        _handleKeydown: function (e) {
            switch (e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    this.prev();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.next();
                    break;
                case 'Home':
                    e.preventDefault();
                    this.goTo(0);
                    break;
                case 'End':
                    e.preventDefault();
                    this.goTo(this._getPageCount() - 1);
                    break;
            }
        },

        _handleDotKeydown: function (e, index) {
            var dots = this.dom.dots;
            var newIndex = index;

            switch (e.key) {
                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    e.stopPropagation(); // 阻止冒泡至 _handleKeydown，避免再次呼叫 prev() 造成多跳一頁
                    newIndex = index > 0 ? index - 1 : dots.length - 1;
                    break;
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    e.stopPropagation(); // 阻止冒泡至 _handleKeydown，避免再次呼叫 next() 造成多跳一頁
                    newIndex = index < dots.length - 1 ? index + 1 : 0;
                    break;
                case 'Home':
                    e.preventDefault();
                    e.stopPropagation();
                    newIndex = 0;
                    break;
                case 'End':
                    e.preventDefault();
                    e.stopPropagation();
                    newIndex = dots.length - 1;
                    break;
                default:
                    return;
            }

            dots[newIndex].focus();
            this.goTo(newIndex);
        },

        // ----- 響應式 -----
        _updateResponsive: function () {
            var options = this.options;
            var width = this.element.offsetWidth;

            var itemsPerPage = options.items;

            if (options.responsive) {
                var breakpoints = Object.keys(options.responsive)
                    .map(Number)
                    .sort(function (a, b) { return b - a; });

                for (var i = 0; i < breakpoints.length; i++) {
                    var bp = breakpoints[i];
                    if (width <= bp) {
                        itemsPerPage = options.responsive[bp].items || itemsPerPage;
                    }
                }
            }

            this.state.itemsPerPage = itemsPerPage;
        },

        _updateLayout: function () {
            var self = this;
            var dom = this.dom;
            var state = this.state;
            var options = this.options;
            var containerWidth = dom.trackContainer.offsetWidth;
            var gap = options.gap;
            var itemsPerPage = state.itemsPerPage;

            // 計算項目寬度
            var totalGap = gap * (itemsPerPage - 1);
            var itemWidth = (containerWidth - totalGap) / itemsPerPage;

            dom.items.forEach(function (item) {
                item.style.width = itemWidth + 'px';
            });

            // 更新分頁指示器
            if (options.dots) {
                this._updateDots();
            }

            // 確保當前索引有效
            var maxIndex = this._getPageCount() - 1;
            if (state.currentIndex > maxIndex) {
                this._goTo(maxIndex, false);
            } else {
                this._goTo(state.currentIndex, false);
            }
        },

        _updateDots: function () {
            var self = this;
            var dom = this.dom;
            var state = this.state;
            var options = this.options;
            var pageCount = this._getPageCount();

            if (dom.dotsContainer) {
                var currentDotCount = dom.dots.length;

                if (currentDotCount !== pageCount) {
                    dom.dotsContainer.innerHTML = '';

                    for (var i = 0; i < pageCount; i++) {
                        (function (index) {
                            var dot = document.createElement('button');
                            dot.type = 'button';
                            dot.className = 'tad-carousel__dot';
                            dot.setAttribute('role', 'tab');
                            dot.setAttribute('aria-selected', index === state.currentIndex ? 'true' : 'false');
                            dot.setAttribute('aria-label', formatText(options.a11y.dotText, index + 1));
                            dot.setAttribute('tabindex', index === state.currentIndex ? '0' : '-1');
                            dot.addEventListener('click', function () {
                                self.goTo(index);
                            });
                            dot.addEventListener('keydown', function (e) {
                                self._handleDotKeydown(e, index);
                            });
                            dom.dotsContainer.appendChild(dot);
                        })(i);
                    }

                    dom.dots = Array.prototype.slice.call(dom.dotsContainer.children);
                }
            }
        },

        // ----- 核心導航 -----
        _goTo: function (index, animate) {
            var self = this;
            var state = this.state;
            var dom = this.dom;
            var options = this.options;
            var pageCount = this._getPageCount();

            if (animate === undefined) animate = true;

            // 處理邊界
            var targetIndex = index;
            if (options.loop) {
                targetIndex = ((index % pageCount) + pageCount) % pageCount;
            } else {
                targetIndex = Math.max(0, Math.min(index, pageCount - 1));
            }

            var prevIndex = state.currentIndex;
            state.currentIndex = targetIndex;

            // 觸發 onChange
            if (prevIndex !== targetIndex) {
                this._emit('onChange', { from: prevIndex, to: targetIndex });
            }

            // 更新位置
            var offset = this._getOffset(targetIndex);

            if (animate) {
                state.isAnimating = true;
                dom.track.style.transition = '';
            } else {
                dom.track.style.transition = 'none';
            }

            dom.track.style.transform = 'translateX(' + offset + 'px)';

            // 動畫結束處理
            if (animate) {
                var onTransitionEnd = function () {
                    state.isAnimating = false;
                    dom.track.removeEventListener('transitionend', onTransitionEnd);
                    self._emit('onChanged', { index: targetIndex });
                };
                dom.track.addEventListener('transitionend', onTransitionEnd);
            }

            // 更新 UI 狀態
            this._updateNavState();
            this._updateDotsState();
            this._updateItemsState();
            this._announceLiveRegion();
        },

        _getOffset: function (index) {
            var dom = this.dom;
            var state = this.state;
            var options = this.options;
            var containerWidth = dom.trackContainer.offsetWidth;
            var gap = options.gap;
            var itemsPerPage = state.itemsPerPage;

            var totalGap = gap * (itemsPerPage - 1);
            var itemWidth = (containerWidth - totalGap) / itemsPerPage;

            // 計算偏移量
            var itemIndex = index * itemsPerPage;
            var offset = -(itemIndex * (itemWidth + gap));

            // RTL 支援
            return options.rtl ? -offset : offset;
        },

        _getPageCount: function () {
            var state = this.state;
            return Math.ceil(state.itemCount / state.itemsPerPage);
        },

        _updateNavState: function () {
            var dom = this.dom;
            var state = this.state;
            var options = this.options;

            if (!options.nav) return;

            var pageCount = this._getPageCount();
            var isFirst = state.currentIndex === 0;
            var isLast = state.currentIndex === pageCount - 1;

            if (!options.loop) {
                dom.prevBtn.disabled = isFirst;
                dom.nextBtn.disabled = isLast;
            }
        },

        _updateDotsState: function () {
            var dom = this.dom;
            var state = this.state;
            var options = this.options;

            if (!options.dots || !dom.dots) return;

            dom.dots.forEach(function (dot, index) {
                var isActive = index === state.currentIndex;
                dot.setAttribute('aria-selected', isActive ? 'true' : 'false');
                dot.setAttribute('tabindex', isActive ? '0' : '-1');
                if (isActive) {
                    dot.classList.add('is-active');
                } else {
                    dot.classList.remove('is-active');
                }
            });
        },

        _updateItemsState: function () {
            var dom = this.dom;
            var state = this.state;
            var startIndex = state.currentIndex * state.itemsPerPage;
            var endIndex = startIndex + state.itemsPerPage;

            dom.items.forEach(function (item, index) {
                var isVisible = index >= startIndex && index < endIndex;
                item.setAttribute('aria-hidden', !isVisible);
                if (!isVisible) {
                    item.setAttribute('inert', '');
                    item.removeAttribute('tabindex');
                } else {
                    item.removeAttribute('inert');
                    // WCAG 2.1.2：僅讓「第一個」可見投影片成為 Tab 停駐點。
                    // 若多張投影片同時可見（items > 1），每張都設 tabindex="0" 會造成
                    // Tab 鍵在投影片區重複停駐（「遊走二次」），因此只有 startIndex
                    // 的項目可被 Tab 聚焦，其餘可見項目設 tabindex="-1" 排除於 Tab 序列外。
                    item.setAttribute('tabindex', index === startIndex ? '0' : '-1');
                }
            });
        },

        _announceLiveRegion: function () {
            var dom = this.dom;
            var state = this.state;
            var options = this.options;
            var text = formatText(
                options.a11y.slideText,
                state.currentIndex + 1,
                this._getPageCount()
            );
            dom.liveRegion.textContent = text;
        },

        // ----- 自動播放 -----
        _startAutoplay: function () {
            var self = this;
            var options = this.options;
            var state = this.state;

            if (state.autoplayTimer) {
                clearInterval(state.autoplayTimer);
            }

            state.autoplayTimer = setInterval(function () {
                if (!state.isAutoplayPaused && !state.isDragging) {
                    self.next();
                }
            }, options.autoplayTimeout);
        },

        _pauseAutoplay: function () {
            this.state.isAutoplayPaused = true;
        },

        _resumeAutoplay: function () {
            if (this.options.autoplay) {
                this.state.isAutoplayPaused = false;
            }
        },

        // ----- 事件發送 -----
        _emit: function (event, data) {
            var callback = this.options[event];
            data = data || {};

            if (typeof callback === 'function') {
                callback.call(this, extend({ carousel: this }, data));
            }

            // 也觸發自訂事件
            var customEvent;
            var eventName = 'tadcarousel:' + event.replace('on', '').toLowerCase();

            if (typeof CustomEvent === 'function') {
                customEvent = new CustomEvent(eventName, {
                    detail: extend({ carousel: this }, data)
                });
            } else {
                // IE 相容
                customEvent = document.createEvent('CustomEvent');
                customEvent.initCustomEvent(eventName, true, true, extend({ carousel: this }, data));
            }

            this.element.dispatchEvent(customEvent);
        },

        // ===== 公開方法 =====

        /**
         * 前往指定頁面
         * @param {number} index - 頁面索引
         */
        goTo: function (index) {
            this._goTo(index, true);
        },

        /**
         * 前往下一頁
         */
        next: function () {
            var state = this.state;
            var options = this.options;
            var pageCount = this._getPageCount();

            var nextIndex = state.currentIndex + 1;

            if (nextIndex >= pageCount) {
                nextIndex = options.loop ? 0 : pageCount - 1;
            }

            this._goTo(nextIndex, true);
        },

        /**
         * 前往上一頁
         */
        prev: function () {
            var state = this.state;
            var options = this.options;
            var pageCount = this._getPageCount();

            var prevIndex = state.currentIndex - 1;

            if (prevIndex < 0) {
                prevIndex = options.loop ? pageCount - 1 : 0;
            }

            this._goTo(prevIndex, true);
        },

        /**
         * 切換自動播放
         */
        toggleAutoplay: function () {
            var dom = this.dom;
            var state = this.state;
            var options = this.options;

            if (state.autoplayTimer) {
                clearInterval(state.autoplayTimer);
                state.autoplayTimer = null;
                state.isAutoplayPaused = true;

                dom.autoplayToggle.setAttribute('aria-label', options.a11y.playText);
                dom.autoplayToggle.setAttribute('aria-pressed', 'true');
                dom.autoplayToggle.querySelector('.pause-icon').style.display = 'none';
                dom.autoplayToggle.querySelector('.play-icon').style.display = 'block';
            } else {
                this._startAutoplay();
                state.isAutoplayPaused = false;

                dom.autoplayToggle.setAttribute('aria-label', options.a11y.pauseText);
                dom.autoplayToggle.setAttribute('aria-pressed', 'false');
                dom.autoplayToggle.querySelector('.pause-icon').style.display = 'block';
                dom.autoplayToggle.querySelector('.play-icon').style.display = 'none';
            }
        },

        /**
         * 更新輪播
         */
        refresh: function () {
            this._updateResponsive();
            this._updateLayout();
        },

        /**
         * 銷毀輪播實例
         */
        destroy: function () {
            var self = this;

            // 清除計時器
            if (this.state.autoplayTimer) {
                clearInterval(this.state.autoplayTimer);
            }

            // 移除 ResizeObserver
            if (this._resizeObserver) {
                this._resizeObserver.disconnect();
            }

            // 移除事件監聽
            document.removeEventListener('visibilitychange', this._onVisibilityChangeBound);
            document.removeEventListener('mousemove', this._onDragMoveBound);
            document.removeEventListener('mouseup', this._onDragEndBound);

            // 移除類別和屬性
            this.element.classList.remove('tad-carousel');
            this.element.removeAttribute('role');
            this.element.removeAttribute('aria-roledescription');
            this.element.removeAttribute('aria-label');

            // 清空內容（保留原始項目）
            var items = this.dom.items.map(function (item) {
                return item.firstElementChild;
            });
            this.element.innerHTML = '';
            items.forEach(function (item) {
                self.element.appendChild(item);
            });

            // 清除參照
            this.dom = {};
            this.state = {};
        },

        /**
         * 取得當前頁面索引
         * @returns {number}
         */
        getCurrentIndex: function () {
            return this.state.currentIndex;
        },

        /**
         * 取得總頁數
         * @returns {number}
         */
        getPageCount: function () {
            return this._getPageCount();
        }
    };

    // 回傳建構函式
    return TadCarousel;
});
