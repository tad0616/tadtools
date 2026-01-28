/**
 * TadMenu - 垂直三層選單元件
 * 符合 WCAG 2.2 AAA 無障礙規範
 * @version 1.5.0
 */

class TadMenu {
    // ========================================
    // 內建配色方案
    // ========================================
    static themes = {
        'ocean-blue': {
            name: '海洋藍',
            level1: { textColor: '#1e3a5f', bgColor: '#e8f4fc', hoverBg: '#d0e8f7', fontSize: '1.1em' },
            level2: { textColor: '#2c5282', bgColor: '#f0f7fc', hoverBg: '#dceefb', fontSize: '1em' },
            level3: { textColor: '#3d6a99', bgColor: '#ffffff', hoverBg: '#e8f4fc', fontSize: '0.95em' },
            accent: '#0077cc',
            highlight: { bgColor: '#fff3cd', borderColor: '#ffc107' },
            borderColor: '#b3d7f0'
        },
        'forest-green': {
            name: '森林綠',
            level1: { textColor: '#1d4a3a', bgColor: '#e6f5ed', hoverBg: '#d1ebde', fontSize: '1.1em' },
            level2: { textColor: '#2d6a4f', bgColor: '#f0faf5', hoverBg: '#ddf2e6', fontSize: '1em' },
            level3: { textColor: '#40916c', bgColor: '#ffffff', hoverBg: '#e6f5ed', fontSize: '0.95em' },
            accent: '#2d9a5d',
            highlight: { bgColor: '#d4edda', borderColor: '#28a745' },
            borderColor: '#b7e1c9'
        },
        'warm-orange': {
            name: '暖陽橘',
            level1: { textColor: '#7c4a03', bgColor: '#fff4e6', hoverBg: '#ffe8cc', fontSize: '1.1em' },
            level2: { textColor: '#9a5d0a', bgColor: '#fffaf2', hoverBg: '#ffefd9', fontSize: '1em' },
            level3: { textColor: '#b36b12', bgColor: '#ffffff', hoverBg: '#fff4e6', fontSize: '0.95em' },
            accent: '#e67e22',
            highlight: { bgColor: '#ffe5b4', borderColor: '#e67e22' },
            borderColor: '#ffd7a8'
        },
        'elegant-purple': {
            name: '優雅紫',
            level1: { textColor: '#4a1d6a', bgColor: '#f3e8fa', hoverBg: '#e8d5f5', fontSize: '1.1em' },
            level2: { textColor: '#5e3580', bgColor: '#f9f2fc', hoverBg: '#efe0f7', fontSize: '1em' },
            level3: { textColor: '#7b4a9e', bgColor: '#ffffff', hoverBg: '#f3e8fa', fontSize: '0.95em' },
            accent: '#8e44ad',
            highlight: { bgColor: '#e8d5f5', borderColor: '#8e44ad' },
            borderColor: '#d8c1eb'
        },
        'tech-dark': {
            name: '科技黑',
            level1: { textColor: '#e8e8e8', bgColor: '#1a1a2e', hoverBg: '#252542', fontSize: '1.1em' },
            level2: { textColor: '#d0d0d0', bgColor: '#16213e', hoverBg: '#1f3156', fontSize: '1em' },
            level3: { textColor: '#b8b8b8', bgColor: '#0f0f1a', hoverBg: '#1a1a2e', fontSize: '0.95em' },
            accent: '#00d4ff',
            highlight: { bgColor: '#1f3156', borderColor: '#00d4ff' },
            borderColor: '#2a2a45'
        },
        'sakura-pink': {
            name: '櫻花粉',
            level1: { textColor: '#8b4a5e', bgColor: '#fdf2f4', hoverBg: '#fce4e8', fontSize: '1.1em' },
            level2: { textColor: '#a05670', bgColor: '#fef7f8', hoverBg: '#fdeef1', fontSize: '1em' },
            level3: { textColor: '#b86b82', bgColor: '#ffffff', hoverBg: '#fdf2f4', fontSize: '0.95em' },
            accent: '#e84a7f',
            highlight: { bgColor: '#fce4e8', borderColor: '#e84a7f' },
            borderColor: '#f7cfd8'
        },
        'classic-gray': {
            name: '經典灰',
            level1: { textColor: '#2d3436', bgColor: '#f5f6f7', hoverBg: '#e8eaec', fontSize: '1.1em' },
            level2: { textColor: '#4a4f52', bgColor: '#fafbfc', hoverBg: '#eef0f2', fontSize: '1em' },
            level3: { textColor: '#636e72', bgColor: '#ffffff', hoverBg: '#f5f6f7', fontSize: '0.95em' },
            accent: '#5a6c7d',
            highlight: { bgColor: '#e8eaec', borderColor: '#5a6c7d' },
            borderColor: '#d9dbdd'
        },
        'amber-gold': {
            name: '琥珀金',
            level1: { textColor: '#5c4813', bgColor: '#faf6e9', hoverBg: '#f5edd3', fontSize: '1.1em' },
            level2: { textColor: '#7a621c', bgColor: '#fcfaf2', hoverBg: '#f8f2de', fontSize: '1em' },
            level3: { textColor: '#967826', bgColor: '#ffffff', hoverBg: '#faf6e9', fontSize: '0.95em' },
            accent: '#d4a017',
            highlight: { bgColor: '#f5edd3', borderColor: '#d4a017' },
            borderColor: '#eee3b9'
        },
        'bootstrap-light': {
            name: '雅致白',
            level1: { textColor: '#212529', bgColor: '#ffffff', hoverBg: '#f8f9fa', fontSize: '1.1em' },
            level2: { textColor: '#212529', bgColor: '#f8f9fa', hoverBg: '#e9ecef', fontSize: '1em' },
            level3: { textColor: '#495057', bgColor: '#ffffff', hoverBg: '#f8f9fa', fontSize: '0.95em' },
            accent: '#6c757d',
            highlight: { bgColor: '#e9ecef', borderColor: '#6c757d' },
            borderColor: '#dee2e6'
        }
    };

    // ========================================
    // 靜態方法
    // ========================================

    static getThemes() {
        return TadMenu.themes;
    }

    static getThemeList() {
        return Object.entries(TadMenu.themes).map(([key, theme]) => ({
            key,
            name: theme.name
        }));
    }

    static registerTheme(key, theme) {
        if (!theme.level1 || !theme.level2 || !theme.level3) {
            console.error('[TadMenu] Theme must include level1, level2, and level3 settings.');
            return;
        }
        TadMenu.themes[key] = {
            name: theme.name || key,
            ...theme,
            highlight: theme.highlight || { bgColor: '#fff3cd', borderColor: '#ffc107' },
            borderColor: theme.borderColor || '#dee2e6'
        };
    }

    /**
     * 清除指定或所有選單快取
     * @param {string} jsonPath - 指定 JSON 路徑，不傳則清除所有
     */
    static clearCache(jsonPath = null) {
        if (jsonPath) {
            const cacheKey = `tadmenu_cache_${btoa(jsonPath)}`;
            sessionStorage.removeItem(cacheKey);
        } else {
            Object.keys(sessionStorage).forEach(key => {
                if (key.startsWith('tadmenu_cache_')) {
                    sessionStorage.removeItem(key);
                }
            });
        }
    }

    // ========================================
    // 建構函式
    // ========================================
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        if (!this.container) {
            console.error(`[TadMenu] Container with id "${containerId}" not found.`);
            return;
        }

        this.options = {
            jsonPath: options.jsonPath || 'menu-data.json',
            animationDuration: options.animationDuration || 300,
            onReady: options.onReady || null,
            defaultExpand: options.defaultExpand || [],
            defaultExpandTo: options.defaultExpandTo || null,
            highlightDuration: options.highlightDuration || 3000,
            theme: options.theme || null,
            enableCache: options.enableCache !== false,  // 預設啟用快取
            cacheExpiry: options.cacheExpiry || 30 * 60 * 1000,  // 快取過期時間（預設 30 分鐘）
            showBorder: options.showBorder || true,  // 預設不顯示外框
            borderRadius: options.borderRadius || '6px',  // 預設圓角大小
            ...options
        };

        this.currentTheme = null;
        this.activeLevel3 = null;
        this.activeLevel3Parent = null;
        this.isReady = false;
        this.init();
    }

    // ========================================
    // 初始化
    // ========================================
    async init() {
        try {
            // 優先從快取載入
            let data = this.loadFromCache();
            let fromCache = !!data;

            if (!data) {
                data = await this.loadJSON(this.options.jsonPath);
                // 儲存到快取
                if (this.options.enableCache) {
                    this.saveToCache(data);
                }
            }

            let menuItems = data.menuItems;

            // 套用配色方案
            if (this.options.theme) {
                menuItems = this.applyTheme(menuItems, this.options.theme);
            }

            this.render(menuItems);
            this.injectThemeStyles();
            this.bindEvents();
            this.setupAccessibility();

            // 如果是從快取載入，減少等待時間
            const waitTime = fromCache ? 0 : 1;

            requestAnimationFrame(() => {
                setTimeout(() => {
                    if (this.options.defaultExpand.length > 0) {
                        this.options.defaultExpand.forEach(id => {
                            this.expand(id);
                        });
                    }

                    if (this.options.defaultExpandTo) {
                        this.expandTo(this.options.defaultExpandTo, true);
                    }

                    this.isReady = true;
                    if (typeof this.options.onReady === 'function') {
                        this.options.onReady(this);
                    }
                }, waitTime);
            });

            // 背景更新快取（如果是從快取載入）
            if (fromCache && this.options.enableCache) {
                this.refreshCacheInBackground();
            }

        } catch (error) {
            console.error('[TadMenu] Failed to initialize menu:', error);
            this.container.innerHTML = '<p role="alert">選單載入失敗，請重新整理頁面。</p>';
        }
    }

    // ========================================
    // 快取機制
    // ========================================

    /**
     * 取得快取 key
     */
    getCacheKey() {
        return `tadmenu_cache_${btoa(this.options.jsonPath)}`;
    }

    /**
     * 從快取載入資料
     */
    loadFromCache() {
        if (!this.options.enableCache) return null;

        try {
            const cacheKey = this.getCacheKey();
            const cached = sessionStorage.getItem(cacheKey);

            if (!cached) return null;

            const { data, timestamp } = JSON.parse(cached);
            const now = Date.now();

            // 檢查是否過期
            if (now - timestamp > this.options.cacheExpiry) {
                sessionStorage.removeItem(cacheKey);
                return null;
            }

            return data;
        } catch (e) {
            return null;
        }
    }

    /**
     * 儲存資料到快取
     */
    saveToCache(data) {
        try {
            const cacheKey = this.getCacheKey();
            const cacheData = {
                data: data,
                timestamp: Date.now()
            };
            sessionStorage.setItem(cacheKey, JSON.stringify(cacheData));
        } catch (e) {
            // sessionStorage 可能已滿或被停用
            console.warn('[TadMenu] Unable to cache menu data:', e);
        }
    }

    /**
     * 背景更新快取
     */
    async refreshCacheInBackground() {
        try {
            const freshData = await this.loadJSON(this.options.jsonPath);
            this.saveToCache(freshData);
        } catch (e) {
            // 背景更新失敗不影響使用
        }
    }

    async loadJSON(path) {
        const response = await fetch(path);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    }

    // ========================================
    // 配色方案處理
    // ========================================

    resolveTheme(theme) {
        if (typeof theme === 'string') {
            return TadMenu.themes[theme] || TadMenu.themes['ocean-blue'];
        }
        if (typeof theme === 'object' && theme !== null) {
            return {
                name: theme.name || 'Custom',
                level1: { ...TadMenu.themes['ocean-blue'].level1, ...theme.level1 },
                level2: { ...TadMenu.themes['ocean-blue'].level2, ...theme.level2 },
                level3: { ...TadMenu.themes['ocean-blue'].level3, ...theme.level3 },
                accent: theme.accent || '#0077cc',
                highlight: { ...TadMenu.themes['ocean-blue'].highlight, ...theme.highlight },
                borderColor: theme.borderColor || '#dee2e6'
            };
        }
        return TadMenu.themes['ocean-blue'];
    }

    applyTheme(items, theme) {
        this.currentTheme = this.resolveTheme(theme);
        return this.applyThemeToItems(items, 1);
    }

    applyThemeToItems(items, level) {
        const levelKey = `level${Math.min(level, 3)}`;
        const colors = this.currentTheme[levelKey];

        return items.map(item => {
            const newItem = {
                ...item,
                textColor: colors.textColor,
                bgColor: colors.bgColor,
                fontSize: colors.fontSize
            };

            newItem._hoverBg = colors.hoverBg;
            newItem._level = level;

            if (item.children && item.children.length > 0) {
                newItem.children = this.applyThemeToItems(item.children, level + 1);
            }

            return newItem;
        });
    }

    injectThemeStyles() {
        if (!this.currentTheme) return;

        const styleId = 'tadmenu-theme-styles';
        let styleEl = document.getElementById(styleId);

        if (!styleEl) {
            styleEl = document.createElement('style');
            styleEl.id = styleId;
            document.head.appendChild(styleEl);
        }

        const theme = this.currentTheme;
        const showBorder = this.options.showBorder;
        const borderRadius = this.options.borderRadius;
        const borderColor = theme.borderColor;

        let borderStyles = '';
        if (showBorder) {
            borderStyles = `
        .tadmenu {
          border: 1px solid ${borderColor};
          border-radius: ${borderRadius};
          overflow: hidden;
        }

        .tadmenu-item[data-level="1"] > .tadmenu-link {
          border-bottom: 1px solid ${borderColor};
        }

        .tadmenu-item[data-level="1"]:last-child > .tadmenu-link {
          border-bottom: none;
        }

        .tadmenu-item[data-level="2"] > .tadmenu-link {
          border-bottom: 1px solid ${borderColor};
        }

        .tadmenu-item[data-level="2"]:last-child > .tadmenu-link {
          border-bottom: none;
        }

        .tadmenu-item[data-level="3"] > .tadmenu-link {
          border-bottom: 1px solid ${borderColor};
        }

        .tadmenu-item[data-level="3"]:last-child > .tadmenu-link {
          border-bottom: none;
        }

        .tadmenu-submenu-2 {
          border-top: 1px solid ${borderColor};
        }

        .tadmenu-submenu-3 {
          border: 1px solid ${borderColor};
          border-radius: 6px;
          overflow: hidden;
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
      `;
        }

        styleEl.textContent = `
      .tadmenu-item[data-level="1"] > .tadmenu-link:hover,
      .tadmenu-item[data-level="1"] > .tadmenu-link:focus {
        background-color: ${theme.level1.hoverBg} !important;
      }

      .tadmenu-item[data-level="2"] > .tadmenu-link:hover,
      .tadmenu-item[data-level="2"] > .tadmenu-link:focus {
        background-color: ${theme.level2.hoverBg} !important;
      }

      .tadmenu-item[data-level="3"] > .tadmenu-link:hover,
      .tadmenu-item[data-level="3"] > .tadmenu-link:focus {
        background-color: ${theme.level3.hoverBg} !important;
      }

      .tadmenu-item.tadmenu-expanded > .tadmenu-link {
        border-left-color: ${theme.accent} !important;
      }

      .tadmenu-highlight {
        background-color: ${theme.highlight.bgColor} !important;
        box-shadow: inset 4px 0 0 0 ${theme.highlight.borderColor},
                    0 0 8px rgba(0, 0, 0, 0.1) !important;
        animation: tadmenu-pulse 0.6s ease-in-out 3;
      }

      @keyframes tadmenu-pulse {
        0%, 100% {
          box-shadow: inset 4px 0 0 0 ${theme.highlight.borderColor},
                      0 0 8px rgba(0, 0, 0, 0.1);
        }
        50% {
          box-shadow: inset 4px 0 0 0 ${theme.highlight.borderColor},
                      0 0 16px rgba(0, 0, 0, 0.2);
        }
      }

      .tadmenu-item[data-level="1"] .tadmenu-arrow { color: ${theme.level1.textColor}; }
      .tadmenu-item[data-level="2"] .tadmenu-arrow { color: ${theme.level2.textColor}; }
      .tadmenu-item[data-level="3"] .tadmenu-arrow { color: ${theme.level3.textColor}; }

      @media (prefers-reduced-motion: reduce) {
        .tadmenu-highlight {
          animation: none !important;
        }
      }

      ${borderStyles}
    `;
    }

    setTheme(theme) {
        this.options.theme = theme;
        this.init();
    }

    getTheme() {
        return this.currentTheme;
    }

    /**
     * 設置是否顯示外框
     * @param {boolean} show - 是否顯示外框
     */
    setBorder(show) {
        this.options.showBorder = show;
        this.injectThemeStyles();
    }

    // ========================================
    // 渲染選單
    // ========================================
    render(items) {
        const nav = document.createElement('nav');
        nav.className = 'tadmenu';
        nav.setAttribute('aria-label', '主要導覽選單');

        const ul = this.createMenuLevel(items, 1);
        ul.setAttribute('role', 'menubar');
        ul.setAttribute('aria-label', '主選單');
        nav.appendChild(ul);

        this.container.innerHTML = '';
        this.container.appendChild(nav);
    }

    createMenuLevel(items, level) {
        const ul = document.createElement('ul');
        ul.setAttribute('role', level === 1 ? 'menubar' : 'menu');

        if (level === 2) {
            ul.className = 'tadmenu-submenu-2';
        } else if (level === 3) {
            ul.className = 'tadmenu-submenu-3';
        }

        items.forEach((item, index) => {
            const li = this.createMenuItem(item, level, index);
            ul.appendChild(li);
        });

        return ul;
    }

    createMenuItem(item, level, index) {
        const li = document.createElement('li');
        li.className = 'tadmenu-item';
        li.setAttribute('role', 'none');
        li.dataset.id = item.id;
        li.dataset.level = level;

        const hasChildren = item.children && item.children.length > 0;
        const isButton = hasChildren;

        const element = document.createElement(isButton ? 'button' : 'a');
        element.className = 'tadmenu-link';
        element.setAttribute('role', 'menuitem');

        if (item.textColor) element.style.color = item.textColor;
        if (item.bgColor) element.style.backgroundColor = item.bgColor;
        if (item.fontSize) element.style.fontSize = item.fontSize;

        if (item.icon) {
            const iconSpan = document.createElement('span');
            iconSpan.className = 'tadmenu-icon';
            iconSpan.setAttribute('aria-hidden', 'true');
            const icon = document.createElement('i');
            icon.className = item.icon;
            iconSpan.appendChild(icon);
            element.appendChild(iconSpan);
        }

        const textSpan = document.createElement('span');
        textSpan.className = 'tadmenu-text';
        textSpan.textContent = item.text;
        element.appendChild(textSpan);

        if (!isButton) {
            element.href = item.link || '#';
            if (item.newWindow) {
                element.target = '_blank';
                element.rel = 'noopener noreferrer';

                const newWindowIcon = document.createElement('span');
                newWindowIcon.className = 'tadmenu-new-window';
                newWindowIcon.setAttribute('aria-hidden', 'true');
                newWindowIcon.innerHTML = '<i class="fa-solid fa-arrow-up-right-from-square"></i>';
                element.appendChild(newWindowIcon);

                const srText = document.createElement('span');
                srText.className = 'tadmenu-sr-only';
                srText.textContent = '（在新視窗開啟）';
                element.appendChild(srText);
            }
        }

        if (hasChildren) {
            element.setAttribute('aria-expanded', 'false');
            element.setAttribute('aria-haspopup', 'true');

            const arrow = document.createElement('span');
            arrow.className = 'tadmenu-arrow';
            arrow.setAttribute('aria-hidden', 'true');
            arrow.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';
            element.appendChild(arrow);

            if (isButton) {
                element.type = 'button';
            }
        }

        element.tabIndex = (level === 1 && index === 0) ? 0 : -1;

        li.appendChild(element);

        if (hasChildren) {
            const submenu = this.createMenuLevel(item.children, level + 1);
            const submenuId = `tadmenu-submenu-${item.id}`;
            submenu.id = submenuId;
            element.setAttribute('aria-controls', submenuId);
            li.appendChild(submenu);
        }

        return li;
    }

    // ========================================
    // 事件綁定
    // ========================================
    bindEvents() {
        this.container.addEventListener('click', (e) => {
            const menuLink = e.target.closest('.tadmenu-link');
            if (!menuLink) return;

            const menuItem = menuLink.closest('.tadmenu-item');
            const submenu = menuItem.querySelector(':scope > ul');

            if (submenu) {
                e.preventDefault();
                this.toggleSubmenu(menuItem, submenu);
            } else if (menuLink.tagName === 'A' && menuLink.getAttribute('href').includes('#')) {
                // 處理帶有錨點的連結
                e.preventDefault();
                const href = menuLink.getAttribute('href');
                const hashPart = href.substring(href.indexOf('#'));
                
                // 檢查是否是同頁面錨點
                if (hashPart !== '#' && hashPart.length > 1) {
                    // 使用 setTimeout 確保導航後焦點能正確移動到錨點
                    setTimeout(() => {
                        // 先導航到頁面
                        window.location.href = href;
                        
                        // 然後嘗試找到錨點元素並滾動到該位置
                        try {
                            const targetElement = document.querySelector(hashPart);
                            if (targetElement) {
                                targetElement.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                                
                                // 可選：將焦點設置在錨點元素上
                                if (targetElement.tabIndex < 0) {
                                    targetElement.tabIndex = -1;
                                }
                                targetElement.focus({ preventScroll: true });
                            }
                        } catch (err) {
                            console.warn('[TadMenu] Error scrolling to anchor:', err);
                        }
                    }, 100);
                } else {
                    // 如果沒有特定錨點，正常導航
                    window.location.href = href;
                }
            }
        });

        this.container.addEventListener('keydown', (e) => {
            this.handleKeyboard(e);
        });

        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target) && this.activeLevel3) {
                this.closeLevel3();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.activeLevel3) {
                const parentLink = this.activeLevel3Parent?.querySelector(':scope > .tadmenu-link');
                this.closeLevel3();
                if (parentLink) parentLink.focus();
            }
        });

        window.addEventListener('resize', () => {
            if (this.activeLevel3 && window.innerWidth > 768) {
                this.positionLevel3(this.activeLevel3, this.activeLevel3Parent);
            }
        });

        window.addEventListener('scroll', () => {
            if (this.activeLevel3 && window.innerWidth > 768) {
                this.positionLevel3(this.activeLevel3, this.activeLevel3Parent);
            }
        }, true);
        
        // 監聽 hashchange 事件，處理從其他地方點擊的錨點連結
        window.addEventListener('hashchange', () => {
            const hash = window.location.hash;
            if (hash && hash !== '#') {
                try {
                    const targetElement = document.querySelector(hash);
                    if (targetElement) {
                        setTimeout(() => {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }, 100);
                    }
                } catch (err) {
                    console.warn('[TadMenu] Error handling hashchange:', err);
                }
            }
        });
    }

    // ========================================
    // 子選單控制
    // ========================================
    toggleSubmenu(menuItem, submenu) {
        const isLevel2 = submenu.classList.contains('tadmenu-submenu-2');
        const isLevel3 = submenu.classList.contains('tadmenu-submenu-3');
        const isExpanded = menuItem.classList.contains('tadmenu-expanded');

        if (isLevel2) {
            const siblings = menuItem.parentElement.querySelectorAll(':scope > .tadmenu-item.tadmenu-expanded');
            siblings.forEach(sibling => {
                if (sibling !== menuItem) {
                    this.closeSubmenuLevel2(sibling);
                }
            });

            if (isExpanded) {
                this.closeSubmenuLevel2(menuItem);
            } else {
                this.openSubmenuLevel2(menuItem, submenu);
            }
        } else if (isLevel3) {
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                if (isExpanded) {
                    this.closeSubmenuLevel3Mobile(menuItem, submenu);
                } else {
                    const otherLevel3Items = menuItem.closest('.tadmenu-submenu-2')
                        ?.querySelectorAll('.tadmenu-item.tadmenu-expanded');
                    otherLevel3Items?.forEach(item => {
                        const sub = item.querySelector(':scope > .tadmenu-submenu-3');
                        if (sub && item !== menuItem) {
                            this.closeSubmenuLevel3Mobile(item, sub);
                        }
                    });
                    this.openSubmenuLevel3Mobile(menuItem, submenu);
                }
            } else {
                if (this.activeLevel3 === submenu) {
                    this.closeLevel3();
                } else {
                    this.closeLevel3();
                    this.openLevel3(menuItem, submenu);
                }
            }
        }
    }

    openSubmenuLevel2(menuItem, submenu) {
        const menuLink = menuItem.querySelector(':scope > .tadmenu-link');
        menuItem.classList.add('tadmenu-expanded');
        menuLink.setAttribute('aria-expanded', 'true');

        submenu.style.maxHeight = submenu.scrollHeight + 'px';

        setTimeout(() => {
            if (menuItem.classList.contains('tadmenu-expanded')) {
                submenu.style.maxHeight = 'none';
                submenu.classList.add('tadmenu-open');
            }
        }, this.options.animationDuration);

        this.announceToScreenReader(`${menuLink.querySelector('.tadmenu-text').textContent} 選單已展開`);
    }

    closeSubmenuLevel2(menuItem) {
        const menuLink = menuItem.querySelector(':scope > .tadmenu-link');
        const submenu = menuItem.querySelector(':scope > .tadmenu-submenu-2');

        if (!submenu) return;

        if (this.activeLevel3 && menuItem.contains(this.activeLevel3)) {
            this.closeLevel3();
        }

        const expandedLevel3 = menuItem.querySelectorAll('.tadmenu-item.tadmenu-expanded');
        expandedLevel3.forEach(item => {
            const sub = item.querySelector(':scope > .tadmenu-submenu-3');
            if (sub) {
                this.closeSubmenuLevel3Mobile(item, sub);
            }
        });

        submenu.classList.remove('tadmenu-open');
        submenu.style.maxHeight = submenu.scrollHeight + 'px';
        submenu.offsetHeight;
        submenu.style.maxHeight = '0';

        menuItem.classList.remove('tadmenu-expanded');
        menuLink.setAttribute('aria-expanded', 'false');
    }

    openSubmenuLevel3Mobile(menuItem, submenu) {
        const menuLink = menuItem.querySelector(':scope > .tadmenu-link');
        menuItem.classList.add('tadmenu-expanded');
        menuLink.setAttribute('aria-expanded', 'true');
        submenu.classList.add('tadmenu-visible');
        submenu.style.maxHeight = submenu.scrollHeight + 'px';
    }

    closeSubmenuLevel3Mobile(menuItem, submenu) {
        const menuLink = menuItem.querySelector(':scope > .tadmenu-link');
        submenu.style.maxHeight = '0';
        submenu.classList.remove('tadmenu-visible');
        menuItem.classList.remove('tadmenu-expanded');
        menuLink.setAttribute('aria-expanded', 'false');
    }

    openLevel3(menuItem, submenu) {
        menuItem.classList.add('tadmenu-expanded');
        menuItem.querySelector(':scope > .tadmenu-link').setAttribute('aria-expanded', 'true');

        this.activeLevel3 = submenu;
        this.activeLevel3Parent = menuItem;

        this.positionLevel3(submenu, menuItem);
        submenu.classList.add('tadmenu-visible');

        const firstLink = submenu.querySelector('.tadmenu-link');
        if (firstLink) {
            firstLink.tabIndex = 0;
        }

        this.announceToScreenReader(`${menuItem.querySelector('.tadmenu-text').textContent} 子選單已開啟`);
    }

    closeLevel3() {
        if (!this.activeLevel3) return;

        const menuItem = this.activeLevel3Parent;
        if (menuItem) {
            menuItem.classList.remove('tadmenu-expanded');
            const menuLink = menuItem.querySelector(':scope > .tadmenu-link');
            if (menuLink) {
                menuLink.setAttribute('aria-expanded', 'false');
            }
        }

        this.activeLevel3.classList.remove('tadmenu-visible');
        this.activeLevel3 = null;
        this.activeLevel3Parent = null;
    }

    positionLevel3(submenu, menuItem) {
        if (window.innerWidth <= 768) return;

        const parentRect = menuItem.getBoundingClientRect();
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;

        submenu.style.left = '0px';
        submenu.style.top = '0px';

        const submenuRect = submenu.getBoundingClientRect();
        const submenuWidth = submenuRect.width;
        const submenuHeight = submenuRect.height;

        let left = parentRect.right + 4;
        if (left + submenuWidth > viewportWidth - 10) {
            left = parentRect.left - submenuWidth - 4;
            if (left < 10) {
                left = 10;
            }
        }

        let top = parentRect.top;
        if (top + submenuHeight > viewportHeight - 10) {
            top = viewportHeight - submenuHeight - 10;
            if (top < 10) {
                top = 10;
            }
        }

        submenu.style.left = `${left}px`;
        submenu.style.top = `${top}px`;
    }

    // ========================================
    // 鍵盤導航
    // ========================================
    handleKeyboard(e) {
        const currentItem = document.activeElement.closest('.tadmenu-item');
        if (!currentItem) return;

        const currentLink = currentItem.querySelector(':scope > .tadmenu-link');
        const parentUl = currentItem.parentElement;
        const items = Array.from(parentUl.querySelectorAll(':scope > .tadmenu-item > .tadmenu-link'));
        const currentIndex = items.indexOf(currentLink);

        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                this.focusItem(items, currentIndex + 1);
                break;

            case 'ArrowUp':
                e.preventDefault();
                this.focusItem(items, currentIndex - 1);
                break;

            case 'ArrowRight':
                e.preventDefault();
                const submenu = currentItem.querySelector(':scope > ul');
                if (submenu && !currentItem.classList.contains('tadmenu-expanded')) {
                    this.toggleSubmenu(currentItem, submenu);
                }
                setTimeout(() => {
                    const firstChildLink = currentItem.querySelector(':scope > ul > .tadmenu-item > .tadmenu-link');
                    if (firstChildLink && currentItem.classList.contains('tadmenu-expanded')) {
                        firstChildLink.tabIndex = 0;
                        firstChildLink.focus();
                    }
                }, 50);
                break;

            case 'ArrowLeft':
                e.preventDefault();
                if (currentItem.classList.contains('tadmenu-expanded')) {
                    const sub = currentItem.querySelector(':scope > ul');
                    if (sub) this.toggleSubmenu(currentItem, sub);
                } else {
                    const parentItem = currentItem.parentElement.closest('.tadmenu-item');
                    if (parentItem) {
                        const parentLink = parentItem.querySelector(':scope > .tadmenu-link');
                        parentLink.tabIndex = 0;
                        parentLink.focus();
                    }
                }
                break;

            case 'Enter':
            case ' ':
                if (currentLink.tagName === 'BUTTON') {
                    e.preventDefault();
                    currentLink.click();
                }
                break;

            case 'Home':
                e.preventDefault();
                this.focusItem(items, 0);
                break;

            case 'End':
                e.preventDefault();
                this.focusItem(items, items.length - 1);
                break;
        }
    }

    focusItem(items, index) {
        if (index < 0) index = items.length - 1;
        if (index >= items.length) index = 0;

        items.forEach((item, i) => {
            item.tabIndex = i === index ? 0 : -1;
        });

        items[index].focus();
    }

    // ========================================
    // 無障礙功能
    // ========================================
    setupAccessibility() {
        if (!document.getElementById('tadmenu-live-region')) {
            const liveRegion = document.createElement('div');
            liveRegion.id = 'tadmenu-live-region';
            liveRegion.className = 'tadmenu-sr-only';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            document.body.appendChild(liveRegion);
        }
    }

    announceToScreenReader(message) {
        const liveRegion = document.getElementById('tadmenu-live-region');
        if (liveRegion) {
            liveRegion.textContent = '';
            setTimeout(() => {
                liveRegion.textContent = message;
            }, 100);
        }
    }

    // ========================================
    // 公開 API 方法
    // ========================================

    expand(itemId) {
        const item = this.container.querySelector(`[data-id="${itemId}"]`);
        if (item) {
            const submenu = item.querySelector(':scope > ul');
            if (submenu && !item.classList.contains('tadmenu-expanded')) {
                this.toggleSubmenu(item, submenu);
            }
        }
    }

    expandTo(itemId, highlight = true) {
        const targetItem = this.container.querySelector(`[data-id="${itemId}"]`);
        if (!targetItem) {
            console.warn(`[TadMenu] Item "${itemId}" not found.`);
            return;
        }

        const parentsToExpand = [];
        let current = targetItem.parentElement.closest('.tadmenu-item');

        while (current) {
            parentsToExpand.unshift(current);
            current = current.parentElement.closest('.tadmenu-item');
        }

        const expandParents = () => {
            return new Promise((resolve) => {
                if (parentsToExpand.length === 0) {
                    resolve();
                    return;
                }

                let index = 0;
                const expandNext = () => {
                    if (index >= parentsToExpand.length) {
                        resolve();
                        return;
                    }

                    const parent = parentsToExpand[index];
                    const submenu = parent.querySelector(':scope > ul');

                    if (submenu && !parent.classList.contains('tadmenu-expanded')) {
                        this.toggleSubmenu(parent, submenu);
                    }

                    index++;
                    setTimeout(expandNext, this.options.animationDuration + 50);
                };

                expandNext();
            });
        };

        expandParents().then(() => {
            setTimeout(() => {
                if (highlight) {
                    this.highlight(itemId);
                }

                const targetLink = targetItem.querySelector(':scope > .tadmenu-link');
                if (targetLink) {
                    targetLink.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 100);
        });
    }

    highlight(itemId, duration = null) {
        const targetItem = this.container.querySelector(`[data-id="${itemId}"]`);
        if (!targetItem) {
            console.warn(`[TadMenu] Item "${itemId}" not found.`);
            return;
        }

        const targetLink = targetItem.querySelector(':scope > .tadmenu-link');
        if (!targetLink) return;

        this.clearHighlight();

        targetLink.classList.add('tadmenu-highlight');

        const highlightDuration = duration !== null ? duration : this.options.highlightDuration;

        if (highlightDuration > 0) {
            setTimeout(() => {
                targetLink.classList.remove('tadmenu-highlight');
            }, highlightDuration);
        }

        this.announceToScreenReader(`已定位到 ${targetLink.querySelector('.tadmenu-text').textContent}`);
    }

    clearHighlight() {
        this.container.querySelectorAll('.tadmenu-highlight').forEach(el => {
            el.classList.remove('tadmenu-highlight');
        });
    }

    collapseAll() {
        this.closeLevel3();
        const expanded = this.container.querySelectorAll('.tadmenu-submenu-2');
        expanded.forEach(submenu => {
            const menuItem = submenu.closest('.tadmenu-item');
            if (menuItem?.classList.contains('tadmenu-expanded')) {
                this.closeSubmenuLevel2(menuItem);
            }
        });
    }

    /**
     * 強制重新載入選單（清除快取）
     */
    async reload() {
        TadMenu.clearCache(this.options.jsonPath);
        await this.init();
    }

    destroy() {
        this.container.innerHTML = '';
        const liveRegion = document.getElementById('tadmenu-live-region');
        if (liveRegion) liveRegion.remove();
        const themeStyles = document.getElementById('tadmenu-theme-styles');
        if (themeStyles) themeStyles.remove();
    }
}

if (typeof module !== 'undefined' && module.exports) {
    module.exports = TadMenu;
}