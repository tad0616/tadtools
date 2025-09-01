/**
 * MarqueeWidget - 多功能跑馬燈套件
 * 版本: 1.0.0
 * 作者: AI Assistant
 *
 * 功能特色:
 * - 支援四個方向滾動 (上下左右)
 * - 支援文字、圖片、HTML內容
 * - 滑鼠懸停自動暫停
 * - 內容溢出智慧處理
 * - 單一內容來回移動
 * - 可動態更新內容和方向
 * - https://claude.ai/public/artifacts/c65cbd0c-2dfc-4153-b8c4-58c191cab956
 */

(function(global, factory) {
    // UMD (Universal Module Definition) 支援
    if (typeof exports === 'object' && typeof module !== 'undefined') {
        // CommonJS
        module.exports = factory();
    } else if (typeof define === 'function' && define.amd) {
        // AMD
        define(factory);
    } else {
        // Browser globals
        global.MarqueeWidget = factory();
    }
}(typeof self !== 'undefined' ? self : this, function() {
    'use strict';

    class MarqueeWidget {
        constructor(containerId, options = {}) {
            this.container = typeof containerId === 'string'
                ? document.getElementById(containerId)
                : containerId;

            if (!this.container) {
                throw new Error('找不到指定的容器元素');
            }

            this.containerId = this.container.id || 'marquee-' + Date.now();
            this.options = {
                direction: options.direction || 'right', // left, right, up, down
                speed: options.speed || 50, // pixels per second
                pauseOnHover: options.pauseOnHover !== false,
                items: options.items || [],
                gap: options.gap || 20, // gap between items
                autoStart: options.autoStart !== false,
                loop: options.loop !== false,
                className: options.className || '',
                ...options
            };

            this.isRunning = false;
            this.isPaused = false;
            this.animationId = null;
            this.wrapper = null;
            this.currentPosition = 0;
            this.isOverflowMode = false;
            this.overflowPhase = 'normal';
            this.isSingleItem = false;
            this.bounceDirection = 1;
            this.callbacks = {
                onStart: options.onStart || null,
                onStop: options.onStop || null,
                onPause: options.onPause || null,
                onResume: options.onResume || null,
                onDirectionChange: options.onDirectionChange || null
            };

            this.init();
        }

        init() {
            this.setupContainer();
            this.createWrapper();
            this.renderItems();
            this.setupEventListeners();

            if (this.options.autoStart) {
                this.start();
            }
        }

        setupContainer() {
            this.container.style.position = 'relative';
            this.container.style.overflow = 'hidden';

            // 添加默認樣式類
            if (!this.container.classList.contains('marquee-container')) {
                this.container.classList.add('marquee-container');
            }

            if (this.options.className) {
                this.container.classList.add(this.options.className);
            }
        }

        createWrapper() {
            if (this.wrapper) {
                this.wrapper.remove();
            }

            this.wrapper = document.createElement('div');
            this.wrapper.className = 'marquee-wrapper';
            this.wrapper.style.position = 'absolute';
            this.wrapper.style.whiteSpace = 'nowrap';
            this.wrapper.style.display = 'flex';
            this.wrapper.style.alignItems = 'center';

            if (this.options.direction === 'up' || this.options.direction === 'down') {
                this.wrapper.style.flexDirection = 'column';
                this.wrapper.style.alignItems = 'flex-start';
            }

            this.container.appendChild(this.wrapper);
        }

        renderItems() {
            this.wrapper.innerHTML = '';
            this.isSingleItem = this.options.items.length === 1;

            if (this.options.items.length === 0) {
                console.warn('MarqueeWidget: 沒有提供任何項目內容');
                return;
            }

            this.options.items.forEach((item, index) => {
                const element = this.createItemElement(item, index);
                this.wrapper.appendChild(element);

                // Add gap except for last item in single item mode
                if (index < this.options.items.length - 1 || !this.isSingleItem) {
                    const gap = document.createElement('div');
                    gap.className = 'marquee-gap';
                    gap.style.width = this.options.direction === 'left' || this.options.direction === 'right'
                        ? this.options.gap + 'px' : '100%';
                    gap.style.height = this.options.direction === 'up' || this.options.direction === 'down'
                        ? this.options.gap + 'px' : '100%';
                    this.wrapper.appendChild(gap);
                }
            });

            // For continuous scrolling, duplicate items
            if (!this.isSingleItem && this.options.loop) {
                const originalItems = this.wrapper.cloneNode(true);
                originalItems.classList.add('marquee-duplicate');
                this.wrapper.appendChild(originalItems);
            }

            this.resetPosition();
        }

        createItemElement(item, index) {
            const element = document.createElement(item.link ? 'a' : 'div');
            element.className = 'marquee-item';
            element.style.display = 'inline-block';
            element.setAttribute('data-index', index);

            if (item.link) {
                element.href = item.link;
                element.target = item.target || '_blank';
                element.rel = item.rel || 'noopener noreferrer';
            }

            if (item.type === 'text') {
                element.textContent = item.content;
            } else if (item.type === 'image') {
                const img = document.createElement('img');
                img.src = item.content;
                img.alt = item.alt || `Image ${index + 1}`;
                img.style.maxHeight = '100%';
                img.style.verticalAlign = 'middle';

                // 添加圖片加載錯誤處理
                img.onerror = () => {
                    console.warn(`MarqueeWidget: 圖片載入失敗 - ${item.content}`);
                    img.style.display = 'none';
                };

                element.appendChild(img);

                if (item.text) {
                    const span = document.createElement('span');
                    span.textContent = item.text;
                    span.style.marginLeft = '8px';
                    element.appendChild(span);
                }
            } else if (item.type === 'html') {
                element.innerHTML = item.content;
            }

            // 添加自定義樣式
            if (item.style) {
                Object.assign(element.style, item.style);
            }

            // 添加自定義類名
            if (item.className) {
                element.classList.add(item.className);
            }

            return element;
        }

        setupEventListeners() {
            if (this.options.pauseOnHover) {
                this.container.addEventListener('mouseenter', this.handleMouseEnter.bind(this));
                this.container.addEventListener('mouseleave', this.handleMouseLeave.bind(this));
            }

            // 添加觸摸事件支援 (移動設備)
            if ('ontouchstart' in window) {
                this.container.addEventListener('touchstart', this.handleMouseEnter.bind(this));
                this.container.addEventListener('touchend', this.handleMouseLeave.bind(this));
            }
        }

        handleMouseEnter() {
            this.pause();
            this.container.classList.add('marquee-paused');
            this.triggerCallback('onPause');
        }

        handleMouseLeave() {
            this.resume();
            this.container.classList.remove('marquee-paused');
            this.triggerCallback('onResume');
        }

        resetPosition() {
            if (!this.wrapper) return;

            const containerRect = this.container.getBoundingClientRect();

            switch (this.options.direction) {
                case 'left':
                    this.currentPosition = containerRect.width;
                    this.wrapper.style.left = this.currentPosition + 'px';
                    this.wrapper.style.top = '50%';
                    this.wrapper.style.transform = 'translateY(-50%)';
                    break;
                case 'right':
                    this.currentPosition = -this.wrapper.offsetWidth;
                    this.wrapper.style.left = this.currentPosition + 'px';
                    this.wrapper.style.top = '50%';
                    this.wrapper.style.transform = 'translateY(-50%)';
                    break;
                case 'up':
                    this.currentPosition = containerRect.height;
                    this.wrapper.style.top = this.currentPosition + 'px';
                    this.wrapper.style.left = '50%';
                    this.wrapper.style.transform = 'translateX(-50%)';
                    break;
                case 'down':
                    this.currentPosition = -this.wrapper.offsetHeight;
                    this.wrapper.style.top = this.currentPosition + 'px';
                    this.wrapper.style.left = '50%';
                    this.wrapper.style.transform = 'translateX(-50%)';
                    break;
            }

            this.isOverflowMode = false;
            this.overflowPhase = 'normal';
            this.bounceDirection = 1;
        }

        animate() {
            if (!this.isRunning) {
                return;
            }

            if (this.isPaused) {
                this.animationId = requestAnimationFrame(() => this.animate());
                return;
            }

            const containerRect = this.container.getBoundingClientRect();
            const wrapperRect = this.wrapper.getBoundingClientRect();
            const deltaTime = 16; // approximately 60fps
            const moveDistance = (this.options.speed * deltaTime) / 1000;

            if (this.isSingleItem) {
                this.animateSingleItem(containerRect, wrapperRect, moveDistance);
            } else {
                this.animateMultipleItems(containerRect, wrapperRect, moveDistance);
            }

            this.animationId = requestAnimationFrame(() => this.animate());
        }

        animateSingleItem(containerRect, wrapperRect, moveDistance) {
            const isVertical = this.options.direction === 'up' || this.options.direction === 'down';
            const containerSize = isVertical ? containerRect.height : containerRect.width;
            const wrapperSize = isVertical ? wrapperRect.height : wrapperRect.width;
            const maxPosition = containerSize - wrapperSize;

            if (wrapperSize <= containerSize) {
                // 如果內容小於容器，則來回移動
                if (isVertical) {
                    this.currentPosition += moveDistance * this.bounceDirection *
                        (this.options.direction === 'up' ? -1 : 1);

                    if (this.currentPosition <= 0) {
                        this.currentPosition = 0;
                        this.bounceDirection = -this.bounceDirection;
                    } else if (this.currentPosition >= maxPosition) {
                        this.currentPosition = maxPosition;
                        this.bounceDirection = -this.bounceDirection;
                    }

                    this.wrapper.style.top = this.currentPosition + 'px';
                } else {
                    this.currentPosition += moveDistance * this.bounceDirection *
                        (this.options.direction === 'left' ? -1 : 1);

                    if (this.currentPosition <= -wrapperSize + containerSize) {
                        this.currentPosition = -wrapperSize + containerSize;
                        this.bounceDirection = -this.bounceDirection;
                    } else if (this.currentPosition >= 0) {
                        this.currentPosition = 0;
                        this.bounceDirection = -this.bounceDirection;
                    }

                    this.wrapper.style.left = this.currentPosition + 'px';
                }
            } else {
                // 如果內容大於容器，則循環滾動
                this.animateMultipleItems(containerRect, wrapperRect, moveDistance);
            }
        }

        animateMultipleItems(containerRect, wrapperRect, moveDistance) {
            // Check for overflow condition
            if ((this.options.direction === 'up' || this.options.direction === 'down') &&
                wrapperRect.width > containerRect.width && !this.isOverflowMode) {
                this.handleOverflow();
                return;
            }

            switch (this.options.direction) {
                case 'left':
                    this.currentPosition -= moveDistance;
                    if (this.currentPosition <= -this.wrapper.offsetWidth / 2) {
                        this.currentPosition = containerRect.width;
                    }
                    this.wrapper.style.left = this.currentPosition + 'px';
                    break;
                case 'right':
                    this.currentPosition += moveDistance;
                    if (this.currentPosition >= containerRect.width) {
                        this.currentPosition = -this.wrapper.offsetWidth / 2;
                    }
                    this.wrapper.style.left = this.currentPosition + 'px';
                    break;
                case 'up':
                    this.currentPosition -= moveDistance;
                    if (this.currentPosition <= -this.wrapper.offsetHeight / 2) {
                        this.currentPosition = containerRect.height;
                    }
                    this.wrapper.style.top = this.currentPosition + 'px';
                    break;
                case 'down':
                    this.currentPosition += moveDistance;
                    if (this.currentPosition >= containerRect.height) {
                        this.currentPosition = -this.wrapper.offsetHeight / 2;
                    }
                    this.wrapper.style.top = this.currentPosition + 'px';
                    break;
            }
        }

        handleOverflow() {
            this.isOverflowMode = true;
            const containerRect = this.container.getBoundingClientRect();
            const moveDistance = (this.options.speed * 16) / 1000;

            switch (this.overflowPhase) {
                case 'normal':
                    this.currentPosition -= moveDistance;
                    this.wrapper.style.left = this.currentPosition + 'px';

                    if (this.currentPosition <= -(this.wrapper.offsetWidth - containerRect.width)) {
                        this.overflowPhase = 'waiting';
                        setTimeout(() => {
                            this.overflowPhase = 'reset';
                        }, 1000);
                    }
                    break;
                case 'waiting':
                    break;
                case 'reset':
                    this.isOverflowMode = false;
                    this.overflowPhase = 'normal';
                    this.resetPosition();
                    break;
            }
        }

        // 公共 API 方法
        start() {
            if (this.isRunning) return this;

            this.isRunning = true;
            this.animate();
            this.triggerCallback('onStart');
            return this;
        }

        stop() {
            if (!this.isRunning) return this;

            this.isRunning = false;
            if (this.animationId) {
                cancelAnimationFrame(this.animationId);
                this.animationId = null;
            }
            this.triggerCallback('onStop');
            return this;
        }

        pause() {
            if (!this.isRunning || this.isPaused) return this;

            this.isPaused = true;
            return this;
        }

        resume() {
            if (!this.isRunning || !this.isPaused) return this;

            this.isPaused = false;
            return this;
        }

        changeDirection(direction) {
            if (!['left', 'right', 'up', 'down'].includes(direction)) {
                console.warn('MarqueeWidget: 無效的方向參數:', direction);
                return this;
            }

            const wasRunning = this.isRunning;
            this.stop();
            this.options.direction = direction;
            this.createWrapper();
            this.renderItems();

            if (wasRunning) {
                this.start();
            }

            this.triggerCallback('onDirectionChange', direction);
            return this;
        }

        updateItems(items) {
            if (!Array.isArray(items)) {
                console.warn('MarqueeWidget: items 必須是陣列');
                return this;
            }

            const wasRunning = this.isRunning;
            this.stop();
            this.options.items = items;
            this.renderItems();

            if (wasRunning) {
                this.start();
            }

            return this;
        }

        setSpeed(speed) {
            if (typeof speed !== 'number' || speed <= 0) {
                console.warn('MarqueeWidget: 速度必須是正數');
                return this;
            }

            this.options.speed = speed;
            return this;
        }

        getOptions() {
            return { ...this.options };
        }

        getStatus() {
            return {
                isRunning: this.isRunning,
                isPaused: this.isPaused,
                direction: this.options.direction,
                speed: this.options.speed,
                itemCount: this.options.items.length,
                isSingleItem: this.isSingleItem
            };
        }

        triggerCallback(callbackName, ...args) {
            if (this.callbacks[callbackName] && typeof this.callbacks[callbackName] === 'function') {
                try {
                    this.callbacks[callbackName].call(this, ...args);
                } catch (error) {
                    console.error(`MarqueeWidget callback error (${callbackName}):`, error);
                }
            }
        }

        destroy() {
            this.stop();

            // 移除事件監聽器
            if (this.options.pauseOnHover) {
                this.container.removeEventListener('mouseenter', this.handleMouseEnter);
                this.container.removeEventListener('mouseleave', this.handleMouseLeave);
            }

            // 移除 DOM 元素
            if (this.wrapper) {
                this.wrapper.remove();
                this.wrapper = null;
            }

            // 清理類名
            this.container.classList.remove('marquee-container', 'marquee-paused');
            if (this.options.className) {
                this.container.classList.remove(this.options.className);
            }

            // 清理屬性
            this.container = null;
            this.options = null;
            this.callbacks = null;

            return null;
        }

        // 靜態方法
        static createDefaultCSS() {
            if (document.getElementById('marquee-widget-css')) return;

            const css = `
                .marquee-container {
                    position: relative;
                    overflow: hidden;
                    background: #f8f9fa;
                    border: 1px solid #dee2e6;
                    border-radius: 4px;
                }

                .marquee-container:hover {
                    background: #e9ecef;
                }

                .marquee-container.marquee-paused {
                    background: #fff3cd;
                    border-color: #ffeaa7;
                }

                .marquee-wrapper {
                    will-change: transform;
                }

                .marquee-item {
                    display: inline-block;
                    padding: 8px 12px;
                    text-decoration: none;
                    color: inherit;
                    transition: color 0.2s ease;
                    vertical-align: middle;
                }

                .marquee-item:hover {
                    color: #007bff;
                }

                .marquee-item img {
                    max-height: 100%;
                    vertical-align: middle;
                }
            `;

            const style = document.createElement('style');
            style.id = 'marquee-widget-css';
            style.textContent = css;
            document.head.appendChild(style);
        }
    }

    // 自動添加默認 CSS
    if (typeof document !== 'undefined') {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                MarqueeWidget.createDefaultCSS();
            });
        } else {
            MarqueeWidget.createDefaultCSS();
        }
    }

    return MarqueeWidget;
}));