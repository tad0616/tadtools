/*!
 * Name: TadLoop
 * Version: 1.1.0
 * Description: Pure JavaScript seamless looping marquee/carousel
 * Based on: jQuery grouploop plugin by Scott Alguire
 * Rewritten: Pure JS, no dependencies, WCAG 2 AA compliance
 *
 * WCAG 2 AA 焦點順序 (Focus Order — SC 2.4.3)：
 *   暫停／播放  →  捲動項目連結  →  向左  →  向右
 *   依 DOM 由上而下排列，輔助科技可依序正確報讀。
 */
(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define([], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory();
    } else {
        root.TadLoop = factory();
    }
})(typeof self !== 'undefined' ? self : this, function () {
    'use strict';

    /**
     * TadLoop Constructor
     * @param {string|HTMLElement} selector - CSS selector or DOM element
     * @param {Object} options - Configuration options
     */
    function TadLoop(selector, options) {
        if (typeof selector === 'string') {
            this.el = document.querySelector(selector);
        } else if (selector instanceof HTMLElement) {
            this.el = selector;
        } else {
            console.error('[TadLoop] Invalid selector or element.');
            return;
        }

        if (!this.el) {
            console.error('[TadLoop] Element not found:', selector);
            return;
        }

        // Default options
        this.options = Object.assign(
            {
                velocity: 2,              // Pixels per frame
                forward: true,            // true = right-to-left, false = left-to-right
                childNode: '.item',       // Selector for each item
                childWrapper: '.item-wrap', // Selector for the wrapper
                pauseOnHover: true,       // Pause animation on hover
                autoStart: true,          // Start animation automatically
                disableAnimation: false,  // Disable animation entirely
                ariaLive: 'off',          // ARIA live region setting
                ariaLabel: 'Scrolling content', // ARIA label for container
                reduceMotion: false,      // Respect prefers-reduced-motion
                seamlessLoop: true,       // Enable seamless looping
                showControls: true,       // Show pause/play toggle button
                showNavButtons: true,     // Show left/right navigation buttons
                // WCAG 2 AA: controlPosition controls the horizontal alignment of
                // the toggle button. The toggle is ALWAYS placed first in DOM (top)
                // to ensure correct focus order per SC 2.4.3.
                controlPosition: 'top-right', // toggle alignment: top-right | top-left
                controlSize: 36,          // Button size in px
                iconPause: '⏸',           // Pause icon (text fallback)
                iconPlay: '▶',            // Play icon (text fallback)
                iconPrev: '◀',            // Left nav icon
                iconNext: '▶',            // Right nav icon (mirrored semantics)
                useFontAwesome: false,    // Use FontAwesome icons
                // Localised ARIA labels ─ override for your language
                ariaLabelPause: '暫停',  // label when animation is playing
                ariaLabelPlay: '播放',    // label when animation is paused
                ariaLabelPrev: '向左捲動',       // left/back button
                ariaLabelNext: '向右捲動',      // right/forward button
                onComplete: null,         // Callback after initialization
                onPause: null,            // Callback when paused
                onResume: null,           // Callback when resumed
            },
            options || {}
        );

        // Internal state
        this._offset = 0;
        this._rafId = null;
        this._animationPaused = !this.options.autoStart;
        this._manuallyPaused = false;
        this._isHovered = false;
        this._focusPaused = false;          // NEW: pause triggered by keyboard focus on items
        this._totalContentWidth = 0;
        this._wrapper = null;
        // WCAG 2 AA control elements
        this._toggleBtn = null;             // Single pause/play toggle button (replaces _pauseBtn/_resumeBtn)
        this._prevBtn = null;               // Left navigation button
        this._nextBtn = null;               // Right navigation button
        this._topBar = null;                // Top controls bar DOM element
        this._bottomBar = null;             // Bottom controls bar DOM element
        // Deprecated references kept for API compatibility
        this._pauseBtn = null;
        this._resumeBtn = null;
        this._controlsEl = null;
        this._destroyed = false;
        this._boundHandlers = {};

        // Check prefers-reduced-motion (WCAG 2.3.3 / 1.4.3)
        if (
            window.matchMedia &&
            window.matchMedia('(prefers-reduced-motion: reduce)').matches
        ) {
            this.options.reduceMotion = true;
        }

        this._init();
    }

    // ─── Prototype Methods ───────────────────────────────────────────────────

    TadLoop.prototype._init = function () {
        var self = this;
        var el = this.el;
        var opts = this.options;

        // Find wrapper
        this._wrapper = el.querySelector(opts.childWrapper);
        if (!this._wrapper) {
            console.error('[TadLoop] Child wrapper not found:', opts.childWrapper);
            return;
        }

        // Container positioning
        if (getComputedStyle(el).position === 'static') {
            el.style.position = 'relative';
        }
        el.style.overflow = 'hidden';

        // ── ARIA on container (SC 1.3.1, 4.1.2) ────────────────────────────
        el.setAttribute('role', 'region');
        el.setAttribute('aria-label', opts.ariaLabel);
        el.setAttribute('aria-live', opts.ariaLive);
        // NOTE: tabindex is intentionally NOT set on the container.
        // Focus goes directly to the child buttons in DOM order,
        // satisfying WCAG SC 2.4.3 Focus Order without a "ghost" focus stop.

        // Seamless loop (clone items)
        if (opts.seamlessLoop) {
            this._setupSeamlessLoop();
        }

        this._calculateTotalWidth();

        // ── Create controls ─────────────────────────────────────────────────
        // IMPORTANT: _createControls inserts the toggle button as the FIRST child
        // of el (before .item-wrap) and nav buttons as the LAST child, giving the
        // correct DOM tab order:  toggle → items → prev → next   (SC 2.4.3)
        if (opts.showControls) {
            this._createControls();
        }

        // ── Keyboard events (SC 2.1.1) ──────────────────────────────────────
        // Kept on container as a fallback. Primary keyboard handling is on buttons.
        this._boundHandlers.keydown = function (e) { self._onKeydown(e); };
        el.addEventListener('keydown', this._boundHandlers.keydown);

        // ── Hover events ────────────────────────────────────────────────────
        if (opts.pauseOnHover) {
            this._boundHandlers.mouseenter = function () { self._onMouseEnter(); };
            this._boundHandlers.mouseleave = function () { self._onMouseLeave(); };
            el.addEventListener('mouseenter', this._boundHandlers.mouseenter);
            el.addEventListener('mouseleave', this._boundHandlers.mouseleave);
        }

        // ── Focus events ─────────────────────────────────────────────────────
        // SC 2.1.1 / 2.2.2: When a keyboard user focuses an item link inside the
        // scrolling area, the animation pauses so they can read/activate the link.
        // Animation resumes when focus leaves the scrolling area entirely.
        this._boundHandlers.focusin = function (e) { self._onFocusIn(e); };
        this._boundHandlers.focusout = function (e) { self._onFocusOut(e); };
        el.addEventListener('focusin', this._boundHandlers.focusin);
        el.addEventListener('focusout', this._boundHandlers.focusout);

        // ── Resize ──────────────────────────────────────────────────────────
        this._boundHandlers.resize = function () { self._onResize(); };
        window.addEventListener('resize', this._boundHandlers.resize);

        // Initial button state
        this._updateControlState();

        // Start animation
        if (!this._animationPaused && !opts.disableAnimation && !opts.reduceMotion) {
            this._rafId = requestAnimationFrame(function () { self._animate(); });
        }

        if (typeof opts.onComplete === 'function') {
            opts.onComplete.call(el);
        }
    };

    // ─── Seamless Loop ───────────────────────────────────────────────────────

    TadLoop.prototype._setupSeamlessLoop = function () {
        var wrapper = this._wrapper;
        var opts = this.options;
        var items = wrapper.querySelectorAll(opts.childNode);

        items.forEach(function (item) {
            var clone = item.cloneNode(true);
            // SC 1.3.1 / 4.1.2: hide clones from assistive technology
            clone.setAttribute('aria-hidden', 'true');
            // Cloned links must not receive keyboard focus
            var links = clone.querySelectorAll('a, button, [tabindex]');
            links.forEach(function (link) { link.setAttribute('tabindex', '-1'); });
            wrapper.appendChild(clone);
        });

        if (opts.forward) {
            this._offset = 0;
        } else {
            this._calculateTotalWidth();
            this._offset = -this._totalContentWidth / 2;
        }
    };

    TadLoop.prototype._calculateTotalWidth = function () {
        var items = this._wrapper.querySelectorAll(this.options.childNode);
        var total = 0;
        items.forEach(function (item) {
            var style = getComputedStyle(item);
            total +=
                item.offsetWidth +
                parseFloat(style.marginLeft || 0) +
                parseFloat(style.marginRight || 0);
        });
        this._totalContentWidth = total;
        return total;
    };

    // ─── Animation ───────────────────────────────────────────────────────────

    TadLoop.prototype._animate = function () {
        var self = this;
        var opts = this.options;

        if (opts.disableAnimation || opts.reduceMotion || this._destroyed) return;

        if (opts.seamlessLoop) {
            if (opts.forward) {
                this._offset -= opts.velocity;
                if (this._offset < -this._totalContentWidth / 2) {
                    this._offset = 0;
                }
            } else {
                this._offset += opts.velocity;
                if (this._offset > 0) {
                    this._offset = -this._totalContentWidth / 2;
                }
            }
            this._wrapper.style.transform = 'translateX(' + this._offset + 'px)';
        } else {
            var winW = window.innerWidth < 768 ? 2 * window.innerWidth : window.innerWidth;
            if (opts.forward) {
                this._offset -= opts.velocity;
                if (this._offset < -winW) { this._offset = 0; }
            } else {
                this._offset += opts.velocity;
                if (this._offset > 0) { this._offset = -winW; }
            }
            this._wrapper.style.transform = 'translateX(' + this._offset + 'px)';
        }

        if (!this._animationPaused) {
            this._rafId = requestAnimationFrame(function () { self._animate(); });
        }
    };

    // ─── Controls ────────────────────────────────────────────────────────────

    /**
     * Create accessible controls with correct DOM focus order:
     *   1. Toggle (pause/play) button  — inserted as FIRST child of container
     *   2. .item-wrap  (scrolling items with <a> links)
     *   3. Prev / Next nav buttons     — appended as LAST child of container
     *
     * Tab order follows DOM source order (SC 2.4.3), so screen readers and
     * keyboard users always traverse:  toggle → items → ◀ prev → next ▶
     */
    TadLoop.prototype._createControls = function () {
        var self = this;
        var opts = this.options;
        var el = this.el;

        var btnSize = opts.controlSize || 36;
        var btnBase =
            'background-color:rgba(255,255,255,0.82);border:none;border-radius:50%;' +
            'width:' + btnSize + 'px;height:' + btnSize + 'px;' +
            'cursor:pointer;display:flex;align-items:center;justify-content:center;' +
            'box-shadow:0 2px 6px rgba(0,0,0,0.22);transition:background-color 0.2s ease;' +
            'color:#1a1a1a;font-size:' + Math.round(btnSize * 0.38) + 'px;' +
            'flex-shrink:0;';

        // ── Helper: attach hover styles ──────────────────────────────────────
        function addHover(btn) {
            btn.addEventListener('mouseenter', function () {
                btn.style.backgroundColor = 'rgba(255,255,255,0.97)';
            });
            btn.addEventListener('mouseleave', function () {
                btn.style.backgroundColor = 'rgba(255,255,255,0.82)';
            });
        }

        // ════════════════════════════════════════════════════════════════════
        // 1. TOP BAR — Pause/Play toggle button
        //    Placed FIRST in DOM so it is the FIRST focusable element (SC 2.4.3).
        //    Also satisfies SC 2.2.2: user can pause moving content before
        //    encountering the items.
        // ════════════════════════════════════════════════════════════════════
        var topBar = document.createElement('div');
        topBar.className = 'tadloop-controls tadloop-controls--top';
        // Horizontal alignment follows controlPosition option
        var alignRight = !opts.controlPosition || opts.controlPosition.indexOf('left') === -1;
        topBar.style.cssText =
            'position:absolute;top:0;' + (alignRight ? 'right:0;' : 'left:0;') +
            'z-index:20;display:flex;align-items:center;padding:6px 8px;gap:4px;';
        // Convey the group purpose to assistive technology
        topBar.setAttribute('role', 'group');
        topBar.setAttribute('aria-label', opts.ariaLabelGroup || '跑馬燈播放控制');

        var toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.className = 'tadloop-btn tadloop-toggle';
        toggleBtn.style.cssText = btnBase;

        // SC 4.1.2 Name, Role, Value:
        //   aria-label  describes the ACTION the button will perform (toggle convention).
        //   aria-pressed reflects the CURRENT state (true = animation is stopped).
        var isPlaying = opts.autoStart && !opts.disableAnimation && !opts.reduceMotion;
        toggleBtn.setAttribute('aria-label', isPlaying
            ? (opts.ariaLabelPause || 'Pause scrolling')
            : (opts.ariaLabelPlay  || 'Play scrolling'));
        toggleBtn.setAttribute('aria-pressed', isPlaying ? 'false' : 'true');

        if (opts.useFontAwesome) {
            toggleBtn.innerHTML = isPlaying
                ? '<i class="fa-solid fa-pause" aria-hidden="true"></i>'
                : '<i class="fa-solid fa-play"  aria-hidden="true"></i>';
        } else {
            toggleBtn.textContent = isPlaying ? opts.iconPause : opts.iconPlay;
        }

        toggleBtn.addEventListener('click', function () { self.toggle(); });
        addHover(toggleBtn);

        topBar.appendChild(toggleBtn);

        // Insert TOP BAR as the very first child of the container — before .item-wrap
        el.insertBefore(topBar, el.firstChild);

        // ════════════════════════════════════════════════════════════════════
        // 2. BOTTOM BAR — Prev (◀) and Next (▶) navigation buttons
        //    Placed LAST in DOM so they receive focus AFTER the scrolling items,
        //    matching the required tab order:  toggle → items → prev → next
        // ════════════════════════════════════════════════════════════════════
        if (opts.showNavButtons !== false) {
            var bottomBar = document.createElement('div');
            bottomBar.className = 'tadloop-controls tadloop-controls--bottom';
            bottomBar.style.cssText =
                'position:absolute;bottom:0;left:0;right:0;' +
                'z-index:20;display:flex;justify-content:space-between;' +
                'padding:6px 8px;pointer-events:none;';
            bottomBar.setAttribute('role', 'group');
            bottomBar.setAttribute('aria-label', opts.ariaLabelNavGroup || '跑馬燈方向控制');

            // SC 4.1.2: accessible name on every interactive element
            var prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.className = 'tadloop-btn tadloop-prev';
            prevBtn.style.cssText = btnBase + 'pointer-events:all;';
            prevBtn.setAttribute('aria-label', opts.ariaLabelPrev || 'Scroll left');
            if (opts.useFontAwesome) {
                prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>';
            } else {
                prevBtn.textContent = opts.iconPrev || '◀';
            }
            prevBtn.addEventListener('click', function () {
                // Auto-pause on navigation so item positions are predictable
                if (!self._animationPaused) { self.pause(true); }
                self._moveContent('left');
            });
            addHover(prevBtn);

            var nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.className = 'tadloop-btn tadloop-next';
            nextBtn.style.cssText = btnBase + 'pointer-events:all;';
            nextBtn.setAttribute('aria-label', opts.ariaLabelNext || 'Scroll right');
            if (opts.useFontAwesome) {
                nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>';
            } else {
                nextBtn.textContent = opts.iconNext || '▶';
            }
            nextBtn.addEventListener('click', function () {
                if (!self._animationPaused) { self.pause(true); }
                self._moveContent('right');
            });
            addHover(nextBtn);

            bottomBar.appendChild(prevBtn);
            bottomBar.appendChild(nextBtn);

            // Append as LAST child — after .item-wrap — to keep correct tab order
            el.appendChild(bottomBar);

            this._prevBtn = prevBtn;
            this._nextBtn = nextBtn;
            this._bottomBar = bottomBar;
        }

        // Store references
        this._toggleBtn = toggleBtn;
        this._topBar    = topBar;
        this._controlsEl = topBar; // legacy alias
        // Nullify deprecated separate-button references
        this._pauseBtn  = null;
        this._resumeBtn = null;
    };

    /**
     * Update the toggle button label, icon, and aria-pressed to reflect current state.
     * SC 4.1.2: Name, Role, Value must stay in sync with state changes.
     */
    TadLoop.prototype._updateControlState = function () {
        if (!this._toggleBtn) return;
        var isPaused = this._animationPaused || this._manuallyPaused;
        var opts = this.options;

        // aria-pressed="true"  → animation is stopped (button was "pressed/engaged")
        // aria-pressed="false" → animation is playing  (button is in default state)
        this._toggleBtn.setAttribute('aria-pressed', isPaused ? 'true' : 'false');
        // aria-label names the next ACTION, making the button self-describing
        this._toggleBtn.setAttribute('aria-label', isPaused
            ? (opts.ariaLabelPlay  || 'Play scrolling')
            : (opts.ariaLabelPause || 'Pause scrolling'));

        if (opts.useFontAwesome) {
            this._toggleBtn.innerHTML = isPaused
                ? '<i class="fa-solid fa-play"  aria-hidden="true"></i>'
                : '<i class="fa-solid fa-pause" aria-hidden="true"></i>';
        } else {
            this._toggleBtn.textContent = isPaused ? opts.iconPlay : opts.iconPause;
        }
    };

    // ─── Event Handlers ──────────────────────────────────────────────────────

    /**
     * Keyboard handler on the container (fallback / arrow key support).
     * SC 2.1.1 Keyboard: all functionality operable by keyboard.
     */
    TadLoop.prototype._onKeydown = function (e) {
        switch (e.key) {
            // Space / Enter on container itself (not a child element)
            case ' ':
            case 'Enter':
                if (e.target === this.el) {
                    e.preventDefault();
                    this.toggle();
                }
                break;
            // Arrow keys work anywhere inside the container while paused
            case 'ArrowLeft':
                if (this._animationPaused) {
                    e.preventDefault();
                    this._moveContent('left');
                }
                break;
            case 'ArrowRight':
                if (this._animationPaused) {
                    e.preventDefault();
                    this._moveContent('right');
                }
                break;
        }
    };

    /** Hover pause */
    TadLoop.prototype._onMouseEnter = function () {
        this._isHovered = true;
        if (!this._manuallyPaused) {
            this._wasPausedBeforeHover = this._animationPaused;
            this._animationPaused = true;
            if (this._rafId) cancelAnimationFrame(this._rafId);
        }
    };

    /** Hover resume */
    TadLoop.prototype._onMouseLeave = function () {
        var self = this;
        this._isHovered = false;
        if (
            !this._wasPausedBeforeHover &&
            !this._manuallyPaused &&
            !this.options.disableAnimation &&
            !this.options.reduceMotion
        ) {
            this._animationPaused = false;
            this._rafId = requestAnimationFrame(function () { self._animate(); });
        }
    };

    /**
     * SC 2.1.1 / 2.2.2: When keyboard focus moves inside the scrolling item area
     * (i.e. a link inside .item-wrap gains focus), pause the animation so the
     * user can reliably read and activate that link.
     */
    TadLoop.prototype._onFocusIn = function (e) {
        if (this._wrapper && this._wrapper.contains(e.target)) {
            if (!this._manuallyPaused && !this._isHovered) {
                this._focusPaused = true;
                this._animationPaused = true;
                if (this._rafId) cancelAnimationFrame(this._rafId);
                // Reflect paused state in toggle button (SC 4.1.2)
                this._updateControlState();
            }
        }
    };

    /**
     * Resume animation when focus leaves the item area entirely.
     * Uses setTimeout(0) to let the browser update activeElement first.
     */
    TadLoop.prototype._onFocusOut = function (e) {
        var self = this;
        if (!this._focusPaused) return;
        setTimeout(function () {
            if (self._destroyed) return;
            // Only resume if focus has truly left the scrolling items
            if (!self._wrapper || !self._wrapper.contains(document.activeElement)) {
                self._focusPaused = false;
                if (
                    !self._manuallyPaused &&
                    !self._isHovered &&
                    !self.options.disableAnimation &&
                    !self.options.reduceMotion
                ) {
                    self._animationPaused = false;
                    self._rafId = requestAnimationFrame(function () { self._animate(); });
                    self._updateControlState();
                }
            }
        }, 0);
    };

    TadLoop.prototype._onResize = function () {
        if (this.options.seamlessLoop) {
            this._calculateTotalWidth();
        }
    };

    TadLoop.prototype._moveContent = function (direction) {
        var amount = 20;
        if (direction === 'left') {
            this._offset += amount;
        } else {
            this._offset -= amount;
        }
        this._wrapper.style.transform = 'translateX(' + this._offset + 'px)';
    };

    // ─── Public API ──────────────────────────────────────────────────────────

    /**
     * Pause animation
     * @param {boolean} manual - true when triggered by user (button / API call)
     */
    TadLoop.prototype.pause = function (manual) {
        if (manual) this._manuallyPaused = true;
        this._animationPaused = true;
        if (this._rafId) cancelAnimationFrame(this._rafId);
        this.el.setAttribute('aria-label', this.options.ariaLabel + ' (paused)');
        this._updateControlState();
        if (typeof this.options.onPause === 'function') {
            this.options.onPause.call(this.el);
        }
    };

    /**
     * Resume animation
     * @param {boolean} manual - true when triggered by user (button / API call)
     */
    TadLoop.prototype.resume = function (manual) {
        var self = this;
        if (this.options.disableAnimation || this.options.reduceMotion) return;
        if (manual) {
            this._manuallyPaused = false;
            this._focusPaused = false;
        }
        if (!this._isHovered) {
            this._animationPaused = false;
            this._rafId = requestAnimationFrame(function () { self._animate(); });
        }
        this.el.setAttribute('aria-label', this.options.ariaLabel + ' (playing)');
        this._updateControlState();
        if (typeof this.options.onResume === 'function') {
            this.options.onResume.call(this.el);
        }
    };

    /** Toggle pause / resume */
    TadLoop.prototype.toggle = function () {
        if (this._animationPaused || this._manuallyPaused) {
            this.resume(true);
        } else {
            this.pause(true);
        }
    };

    /** @param {number} v velocity in pixels per frame */
    TadLoop.prototype.setVelocity = function (v) {
        this.options.velocity = v;
    };

    /** @param {boolean} forward true = right-to-left, false = left-to-right */
    TadLoop.prototype.setDirection = function (forward) {
        this.options.forward = forward;
    };

    /** Destroy instance and clean up all DOM mutations and event listeners */
    TadLoop.prototype.destroy = function () {
        this._destroyed = true;
        this._animationPaused = true;
        if (this._rafId) cancelAnimationFrame(this._rafId);

        // Remove event listeners
        this.el.removeEventListener('keydown',   this._boundHandlers.keydown);
        this.el.removeEventListener('focusin',   this._boundHandlers.focusin);
        this.el.removeEventListener('focusout',  this._boundHandlers.focusout);
        if (this.options.pauseOnHover) {
            this.el.removeEventListener('mouseenter', this._boundHandlers.mouseenter);
            this.el.removeEventListener('mouseleave', this._boundHandlers.mouseleave);
        }
        window.removeEventListener('resize', this._boundHandlers.resize);

        // Remove injected control bars
        if (this._topBar && this._topBar.parentNode) {
            this._topBar.parentNode.removeChild(this._topBar);
        }
        if (this._bottomBar && this._bottomBar.parentNode) {
            this._bottomBar.parentNode.removeChild(this._bottomBar);
        }

        // Remove cloned items
        if (this.options.seamlessLoop) {
            var clones = this._wrapper.querySelectorAll(
                this.options.childNode + '[aria-hidden="true"]'
            );
            clones.forEach(function (c) { c.parentNode.removeChild(c); });
        }

        // Remove ARIA attributes added by TadLoop
        this.el.removeAttribute('role');
        this.el.removeAttribute('aria-label');
        this.el.removeAttribute('aria-live');
        this.el.removeAttribute('tabindex');

        this._wrapper.style.transform = '';
    };

    return TadLoop;
});
