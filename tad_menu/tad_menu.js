/**
 * TadMenu - 垂直三層選單元件
 * 符合 WCAG 2.2 AAA 無障礙規範
 * @version 1.6.0
 * 修正：手機版點擊選單後自動捲動到主內容區
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
        },

        'aaa-ocean-blue': {
            name: '海洋藍 AAA',
            level1: { textColor: '#0b1d3a', bgColor: '#f0f8ff', hoverBg: '#dff0fc', fontSize: '1.1em' },
            level2: { textColor: '#122b55', bgColor: '#f7fbff', hoverBg: '#e5f2fd', fontSize: '1em' },
            level3: { textColor: '#193870', bgColor: '#ffffff', hoverBg: '#f0f8ff', fontSize: '0.95em' },
            accent: '#005fa3',
            highlight: { bgColor: '#fff5cc', borderColor: '#7a5c00' },
            borderColor: '#bcd7f0'
        },
        'aaa-forest-green': {
            name: '森林綠 AAA',
            level1: { textColor: '#0c2a1e', bgColor: '#edf8f2', hoverBg: '#d8f0e3', fontSize: '1.1em' },
            level2: { textColor: '#1a4535', bgColor: '#f5fbf8', hoverBg: '#e3f5ec', fontSize: '1em' },
            level3: { textColor: '#1e5c45', bgColor: '#ffffff', hoverBg: '#edf8f2', fontSize: '0.95em' },
            accent: '#1a7a45',
            highlight: { bgColor: '#c8f0d8', borderColor: '#0e6633' },
            borderColor: '#a8dfc2'
        },
        'aaa-warm-orange': {
            name: '暖陽橘 AAA',
            level1: { textColor: '#3d1f00', bgColor: '#fff7ee', hoverBg: '#ffe8cc', fontSize: '1.1em' },
            level2: { textColor: '#5a3000', bgColor: '#fffbf5', hoverBg: '#fff0d9', fontSize: '1em' },
            level3: { textColor: '#7a4500', bgColor: '#ffffff', hoverBg: '#fff7ee', fontSize: '0.95em' },
            accent: '#b84500',
            highlight: { bgColor: '#ffe8cc', borderColor: '#8a3300' },
            borderColor: '#ffd0a0'
        },
        'aaa-elegant-purple': {
            name: '優雅紫 AAA',
            level1: { textColor: '#260a40', bgColor: '#f7f0fd', hoverBg: '#ecdafc', fontSize: '1.1em' },
            level2: { textColor: '#380f5c', bgColor: '#fbf5fe', hoverBg: '#f3e8fd', fontSize: '1em' },
            level3: { textColor: '#4a1878', bgColor: '#ffffff', hoverBg: '#f7f0fd', fontSize: '0.95em' },
            accent: '#6b1fa0',
            highlight: { bgColor: '#ecdafc', borderColor: '#4a1878' },
            borderColor: '#d5b5f0'
        },
        'aaa-tech-dark': {
            name: '科技黑 AAA',
            level1: { textColor: '#f0f0f0', bgColor: '#0d0d22', hoverBg: '#1a1a38', fontSize: '1.1em' },
            level2: { textColor: '#e8e8e8', bgColor: '#101028', hoverBg: '#1c1c3f', fontSize: '1em' },
            level3: { textColor: '#d8d8d8', bgColor: '#08080f', hoverBg: '#0d0d22', fontSize: '0.95em' },
            accent: '#00c4ee',
            highlight: { bgColor: '#1a1a38', borderColor: '#00c4ee' },
            borderColor: '#252545'
        },
        'aaa-sakura-pink': {
            name: '櫻花粉 AAA',
            level1: { textColor: '#500f25', bgColor: '#fef5f7', hoverBg: '#fce6eb', fontSize: '1.1em' },
            level2: { textColor: '#6b1832', bgColor: '#fef9fa', hoverBg: '#fdeef2', fontSize: '1em' },
            level3: { textColor: '#861e3d', bgColor: '#ffffff', hoverBg: '#fef5f7', fontSize: '0.95em' },
            accent: '#c8004a',
            highlight: { bgColor: '#fce6eb', borderColor: '#861e3d' },
            borderColor: '#f5c5d2'
        },
        'aaa-classic-gray': {
            name: '經典灰 AAA',
            level1: { textColor: '#1a1e20', bgColor: '#f8f9fa', hoverBg: '#ebedee', fontSize: '1.1em' },
            level2: { textColor: '#282d30', bgColor: '#fcfcfd', hoverBg: '#eef0f1', fontSize: '1em' },
            level3: { textColor: '#38403a', bgColor: '#ffffff', hoverBg: '#f8f9fa', fontSize: '0.95em' },
            accent: '#3d4f5c',
            highlight: { bgColor: '#e8eaec', borderColor: '#3d4f5c' },
            borderColor: '#d0d3d5'
        },
        'aaa-amber-gold': {
            name: '琥珀金 AAA',
            level1: { textColor: '#2a1c05', bgColor: '#fdf9ee', hoverBg: '#f8f0d5', fontSize: '1.1em' },
            level2: { textColor: '#3e2a08', bgColor: '#fefcf5', hoverBg: '#fbf5df', fontSize: '1em' },
            level3: { textColor: '#543a0c', bgColor: '#ffffff', hoverBg: '#fdf9ee', fontSize: '0.95em' },
            accent: '#9e6f00',
            highlight: { bgColor: '#f5eccf', borderColor: '#7a5500' },
            borderColor: '#ead8a0'
        },
        'aaa-bootstrap-light': {
            name: '雅致白 AAA',
            level1: { textColor: '#111315', bgColor: '#ffffff', hoverBg: '#f3f4f5', fontSize: '1.1em' },
            level2: { textColor: '#1a1e22', bgColor: '#f5f6f7', hoverBg: '#e8eaec', fontSize: '1em' },
            level3: { textColor: '#2c3338', bgColor: '#ffffff', hoverBg: '#f5f6f7', fontSize: '0.95em' },
            accent: '#2c3e50',
            highlight: { bgColor: '#e8eaec', borderColor: '#2c3e50' },
            borderColor: '#ced2d6'
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

        // 為每個實例創建唯一ID，用於樣式隔離
        this.instanceId = `tadmenu-${Math.random().toString(36).substr(2, 9)}`;
        this.container.dataset.tadmenuInstance = this.instanceId;

        this.options = {
            jsonPath: options.jsonPath || 'menu-data.json',
            animationDuration: options.animationDuration || 300,
            onReady: options.onReady || null,
            defaultExpand: options.defaultExpand || [],
            defaultExpandTo: options.defaultExpandTo || null,
            highlightDuration: options.highlightDuration || 3000,
            theme: options.theme || null,
            enableCache: options.enableCache !== false,
            cacheExpiry: options.cacheExpiry || 30 * 60 * 1000,
            showBorder: options.showBorder || false,
            borderRadius: options.borderRadius || false,
            showAmount: options.showAmount || 0,
            enableTabNavigation: options.enableTabNavigation !== false,
            mainContentId: options.mainContentId || null,
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
            let data = this.loadFromCache();
            let fromCache = !!data;

            if (!data) {
                data = await this.loadJSON(this.options.jsonPath);
                if (this.options.enableCache) {
                    this.saveToCache(data);
                }
            }

            let menuItems = data.menuItems;

            if (this.options.theme) {
                menuItems = this.applyTheme(menuItems, this.options.theme);
            }

            this.render(menuItems);
            this.injectThemeStyles();
            this.bindEvents();
            this.setupAccessibility();

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

    getCacheKey() {
        return `tadmenu_cache_${btoa(this.options.jsonPath)}`;
    }

    loadFromCache() {
        if (!this.options.enableCache) return null;
        try {
            const cacheKey = this.getCacheKey();
            const cached = sessionStorage.getItem(cacheKey);
            if (!cached) return null;
            const { data, timestamp } = JSON.parse(cached);
            const now = Date.now();
            if (now - timestamp > this.options.cacheExpiry) {
                sessionStorage.removeItem(cacheKey);
                return null;
            }
            return data;
        } catch (e) {
            return null;
        }
    }

    saveToCache(data) {
        try {
            const cacheKey = this.getCacheKey();
            const cacheData = { data: data, timestamp: Date.now() };
            sessionStorage.setItem(cacheKey, JSON.stringify(cacheData));
        } catch (e) {
            console.warn('[TadMenu] Unable to cache menu data:', e);
        }
    }

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

    /**
     * 判斷目前選用的主題是否為 AAA 無障礙等級主題。
     * 判斷規則：
     *   - 字串主題：key 以 "aaa-" 開頭（如 'aaa-ocean-blue'）
     *   - 物件主題：name 屬性包含 "AAA"（如 { name: '自訂 AAA', ... }）
     * @returns {boolean}
     */
    isAaaTheme() {
        const theme = this.options.theme;
        if (!theme) return false;
        if (typeof theme === 'string') {
            return theme.startsWith('aaa-');
        }
        if (typeof theme === 'object' && theme !== null) {
            return typeof theme.name === 'string' && theme.name.includes('AAA');
        }
        return false;
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

        const styleId = `tadmenu-theme-styles-${this.instanceId}`;
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
        const instanceSelector = `[data-tadmenu-instance="${this.instanceId}"]`;

        let borderStyles = '';
        if (showBorder) {
            borderStyles = `
                ${instanceSelector} .tadmenu {
                    border: 1px solid ${borderColor};
                    border-radius: ${borderRadius};
                    overflow: hidden;
                }
                ${instanceSelector} .tadmenu-item[data-level="1"] > .tadmenu-link {
                    border-bottom: 1px solid ${borderColor};
                }
                ${instanceSelector} .tadmenu-item[data-level="1"]:last-child > .tadmenu-link {
                    border-bottom: none;
                }
                ${instanceSelector} .tadmenu-item[data-level="2"] > .tadmenu-link {
                    border-bottom: 1px solid ${borderColor};
                }
                ${instanceSelector} .tadmenu-item[data-level="2"]:last-child > .tadmenu-link {
                    border-bottom: none;
                }
                ${instanceSelector} .tadmenu-item[data-level="3"] > .tadmenu-link {
                    border-bottom: 1px solid ${borderColor};
                }
                ${instanceSelector} .tadmenu-item[data-level="3"]:last-child > .tadmenu-link {
                    border-bottom: none;
                }
                ${instanceSelector} .tadmenu-submenu-2 {
                    border-top: 1px solid ${borderColor};
                }
                ${instanceSelector} .tadmenu-submenu-3 {
                    border: 1px solid ${borderColor};
                    border-radius: 6px;
                    overflow: hidden;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }
            `;
        }

        styleEl.textContent = `
            ${instanceSelector} .tadmenu-item[data-level="1"] > .tadmenu-link:hover,
            ${instanceSelector} .tadmenu-item[data-level="1"] > .tadmenu-link:focus {
                background-color: ${theme.level1.hoverBg} !important;
            }
            ${instanceSelector} .tadmenu-item[data-level="2"] > .tadmenu-link:hover,
            ${instanceSelector} .tadmenu-item[data-level="2"] > .tadmenu-link:focus {
                background-color: ${theme.level2.hoverBg} !important;
            }
            ${instanceSelector} .tadmenu-item[data-level="3"] > .tadmenu-link:hover,
            ${instanceSelector} .tadmenu-item[data-level="3"] > .tadmenu-link:focus {
                background-color: ${theme.level3.hoverBg} !important;
            }
            ${borderStyles}
        `;
    }

    // ========================================
    // 渲染
    // ========================================

    render(menuItems) {
        const nav = document.createElement('nav');
        nav.setAttribute('aria-label', '主選單');
        nav.className = 'tadmenu';

        const ul = this.buildMenuLevel(menuItems, 1);
        nav.appendChild(ul);
        this.container.innerHTML = '';
        this.container.appendChild(nav);
    }

    buildMenuLevel(items, level) {
        const ul = document.createElement('ul');
        ul.setAttribute('role', level === 1 ? 'menubar' : 'menu');

        const displayItems = (this.options.showAmount > 0 && level === 1)
            ? items.slice(0, this.options.showAmount)
            : items;

        displayItems.forEach(item => {
            const li = this.buildMenuItem(item, level);
            ul.appendChild(li);
        });

        return ul;
    }

    buildMenuItem(item, level) {
        const li = document.createElement('li');
        li.className = 'tadmenu-item';
        li.dataset.id = item.id || '';
        li.dataset.level = level;
        li.setAttribute('role', 'none');

        const hasChildren = item.children && item.children.length > 0;

        if (hasChildren) {
            const btn = this.buildToggleButton(item, level);
            li.appendChild(btn);

            if (level < 3) {
                const subUl = this.buildMenuLevel(item.children, level + 1);
                subUl.className = level === 1 ? 'tadmenu-submenu-2' : 'tadmenu-submenu-3-inline';
                li.appendChild(subUl);
            } else {
                const floatUl = this.buildMenuLevel(item.children, level + 1);
                floatUl.className = 'tadmenu-submenu-3';
                floatUl.style.display = 'none';
                document.body.appendChild(floatUl);
                li.dataset.floatMenuId = this.instanceId + '-' + (item.id || Math.random().toString(36).substr(2, 9));
                floatUl.dataset.floatMenuId = li.dataset.floatMenuId;
            }
        } else {
            const a = this.buildLink(item, level);
            li.appendChild(a);
        }

        return li;
    }

    buildToggleButton(item, level) {
        const btn = document.createElement('button');
        btn.className = 'tadmenu-link';
        btn.setAttribute('type', 'button');
        btn.setAttribute('aria-expanded', 'false');
        btn.setAttribute('aria-haspopup', level < 3 ? 'true' : 'true');

        if (item.bgColor) btn.style.backgroundColor = item.bgColor;
        if (item.textColor) btn.style.color = item.textColor;
        if (item.fontSize) btn.style.fontSize = item.fontSize;

        btn.innerHTML = this.buildLinkInner(item, true);
        return btn;
    }

    buildLink(item, level) {
        const a = document.createElement('a');
        a.className = 'tadmenu-link';
        a.href = item.link || '#';
        a.setAttribute('role', 'menuitem');

        // 「另開新視窗」標示策略：
        //   AAA 主題 → 文字直接顯示於選項後，符合 WCAG 2.4.4 / 3.2.4 AAA 要求
        //   一般主題 → 維持寫入 title 屬性（原有行為）
        let newWindowLabel = '';
        if (item.newWindow) {
            a.setAttribute('target', '_blank');
            a.setAttribute('rel', 'noopener noreferrer');

            const extPart = (item.ext && typeof item.ext === 'string' && item.ext.trim() !== '')
                ? `（${item.ext.toUpperCase()}格式）`
                : '';

            if (this.isAaaTheme()) {
                // AAA 主題：僅保留格式資訊在 title（若有），
                // 「另開新視窗」改為顯示於連結文字後
                if (extPart) {
                    a.setAttribute('title', extPart);
                }
                newWindowLabel = `另開新視窗${extPart}`;
            } else {
                // 非 AAA 主題：沿用原本 title 屬性的方式
                a.setAttribute('title', `另開新視窗${extPart}`);
            }
        }

        if (item.bgColor) a.style.backgroundColor = item.bgColor;
        if (item.textColor) a.style.color = item.textColor;
        if (item.fontSize) a.style.fontSize = item.fontSize;

        a.innerHTML = this.buildLinkInner(item, false, newWindowLabel);
        return a;
    }

    /**
     * 產生選單項目連結的內部 HTML。
     * @param {object}  item           — 選單項目資料
     * @param {boolean} hasArrow       — 是否顯示展開箭頭（展開按鈕用）
     * @param {string}  [newWindowLabel=''] — AAA 主題時顯示於文字後的「另開新視窗」說明
     */
    buildLinkInner(item, hasArrow, newWindowLabel = '') {
        let html = '';
        if (item.icon) {
            html += `<span class="tadmenu-icon" aria-hidden="true"><i class="${item.icon}"></i></span>`;
        }
        html += `<span class="tadmenu-text">${item.text || ''}</span>`;
        if (newWindowLabel) {
            // ★ AAA 主題：「另開新視窗」說明文字直接顯示於連結文字後，
            //   讓螢幕報讀器與視覺使用者均能立即獲知此行為，
            //   避免資訊僅藏於 title 屬性而被忽略（WCAG 2.4.4 AAA）。
            //   外層 span 使用 class 以便 CSS 控制樣式（縮小字體、弱化色彩等）。
            html += `<span class="tadmenu-new-window" aria-label="，${newWindowLabel}">` +
                    `<span aria-hidden="true">（${newWindowLabel}）</span>` +
                    `</span>`;
        }
        if (hasArrow) {
            html += `<span class="tadmenu-arrow" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>`;
        }
        return html;
    }

    // ========================================
    // 事件綁定
    // ========================================

    bindEvents() {
        // 點擊事件
        this.container.addEventListener('click', (e) => {
            const menuLink = e.target.closest('.tadmenu-link');
            if (!menuLink) return;

            const menuItem = menuLink.closest('.tadmenu-item');
            if (!menuItem) return;

            const level = parseInt(menuItem.dataset.level || '1');
            const hasSubmenu2 = menuItem.querySelector(':scope > .tadmenu-submenu-2');
            const hasSubmenu3Inline = menuItem.querySelector(':scope > .tadmenu-submenu-3-inline');
            const floatMenuId = menuItem.dataset.floatMenuId;

            if (hasSubmenu2) {
                e.preventDefault();
                this._toggleSubmenu2(menuItem, hasSubmenu2);
            } else if (hasSubmenu3Inline) {
                e.preventDefault();
                this._toggleSubmenu3Inline(menuItem, hasSubmenu3Inline);
            } else if (floatMenuId) {
                e.preventDefault();
                this._toggleFloatMenu(menuItem, floatMenuId, menuLink);
            } else {
                // ── 末端連結：無子選單，執行導航 ──────────────────
                this._handleLeafNavigation(e, menuLink);
            }
        });

        // 鍵盤事件
        if (this.options.enableTabNavigation) {
            this.container.addEventListener('keydown', (e) => {
                this._handleKeydown(e);
            });
        }

        // 點擊外部關閉浮動選單
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.tadmenu-submenu-3') && !e.target.closest('.tadmenu-submenu-3-inline') && !e.target.closest('.tadmenu-item')) {
                this._closeAllFloatMenus();
                this._closeAllInlineLevel3Menus();
            }
        });

        // 視窗捲動時關閉浮動選單
        window.addEventListener('scroll', () => {
            this._closeAllFloatMenus();
            this._closeAllInlineLevel3Menus();
        }, { passive: true });

        // 視窗大小改變時關閉浮動選單
        window.addEventListener('resize', () => {
            this._closeAllFloatMenus();
            this._closeAllInlineLevel3Menus();
        }, { passive: true });

        // 處理跨頁跳轉後的焦點恢復（手機版專用）
        this._handlePostNavigationFocus();
    }

    // ========================================
    // ★ 核心修正：末端連結導航處理
    // ========================================

    /**
     * 處理末端連結（無子選單）的點擊導航
     * 修正手機版焦點停留在選單問題
     * @param {Event} e - 點擊事件
     * @param {HTMLElement} menuLink - 被點擊的連結元素
     */
    _handleLeafNavigation(e, menuLink) {
        const isMobile = window.matchMedia('(max-width: 768px)').matches;
        const mainContentEl = this.options.mainContentId
            ? document.getElementById(this.options.mainContentId)
            : null;

        const href = menuLink.tagName === 'A'
            ? (menuLink.getAttribute('href') || '')
            : '';

        const isHashOnly = href === '#' || href === '';
        const isAnchorOnly = href.startsWith('#') && href.length > 1;
        const isCrossPage = !isHashOnly && !isAnchorOnly;

        // ── 情境一：純錨點（同頁跳轉，如 #section1）──────────
        if (isAnchorOnly) {
            e.preventDefault();
            const targetEl = document.querySelector(href);
            if (targetEl) {
                // 確保目標元素可被聚焦
                if (!targetEl.hasAttribute('tabindex')) {
                    targetEl.setAttribute('tabindex', '-1');
                }
                // 先捲動，再設焦點（符合 WCAG 2.4.11）
                targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                setTimeout(() => {
                    targetEl.focus({ preventScroll: true });
                }, 300);
            }
            return;
        }

        // ── 情境二：跨頁連結（手機版）────────────────────────
        if (isMobile && isCrossPage) {
            // 設置旗標，讓目標頁面載入後自動捲到主內容
            try {
                sessionStorage.setItem('tadmenu_scroll_to_main', '1');
                if (this.options.mainContentId) {
                    sessionStorage.setItem('tadmenu_main_content_id', this.options.mainContentId);
                }
            } catch (err) {
                console.warn('[TadMenu] sessionStorage not available:', err);
            }
            // 讓瀏覽器自然跳轉，不阻止預設行為
            return;
        }

        // ── 情境三：桌面版 或 非跨頁 ─────────────────────────
        if (mainContentEl) {
            if (!mainContentEl.hasAttribute('tabindex')) {
                mainContentEl.setAttribute('tabindex', '-1');
            }

            if (isMobile) {
                // 手機版同頁導航：捲動到主內容頂部後設焦點
                mainContentEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                setTimeout(() => {
                    mainContentEl.focus({ preventScroll: true });
                }, 300);
            } else {
                // 桌面版：只移焦點，不強制捲動（使用者可自行控制視圖）
                mainContentEl.focus({ preventScroll: true });
            }
        } else {
            // 沒有設定 mainContentId：手機版移除選單焦點
            if (isMobile) {
                menuLink.blur();
                // 嘗試捲動到頁面主要內容區域
                const possibleMain = document.querySelector('main, [role="main"], #main, .main-content');
                if (possibleMain) {
                    possibleMain.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }
    }

    // ========================================
    // ★ 跨頁跳轉後的焦點恢復（手機版專用）
    // ========================================

    /**
     * 偵測 sessionStorage 旗標，在新頁面載入後
     * 自動捲動到主內容區並設定焦點
     * 解決手機版跨頁跳轉後焦點停在選單的問題
     */
    _handlePostNavigationFocus() {
        const isMobile = window.matchMedia('(max-width: 768px)').matches;
        if (!isMobile) return;

        let flagValue = null;
        let savedMainId = null;

        try {
            flagValue = sessionStorage.getItem('tadmenu_scroll_to_main');
            savedMainId = sessionStorage.getItem('tadmenu_main_content_id');
        } catch (err) {
            return;
        }

        if (!flagValue) return;

        // 清除旗標，避免重複執行
        try {
            sessionStorage.removeItem('tadmenu_scroll_to_main');
            sessionStorage.removeItem('tadmenu_main_content_id');
        } catch (err) { /* 忽略 */ }

        // 決定主內容元素：優先用儲存的 ID，其次用當前設定，最後自動偵測
        const mainId = savedMainId || this.options.mainContentId;
        const mainContentEl = mainId
            ? document.getElementById(mainId)
            : document.querySelector('main, [role="main"], #main, .main-content');

        if (!mainContentEl) return;

        // 等待頁面完全渲染後執行（使用 requestAnimationFrame 確保 DOM 穩定）
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                if (!mainContentEl.hasAttribute('tabindex')) {
                    mainContentEl.setAttribute('tabindex', '-1');
                }
                // 先捲動到主內容頂部
                mainContentEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // 等捲動動畫完成後再設焦點（避免焦點被捲動打斷）
                setTimeout(() => {
                    mainContentEl.focus({ preventScroll: true });
                }, 350);
            });
        });
    }

    // ========================================
    // 子選單展開/收合
    // ========================================

    _toggleSubmenu2(menuItem, submenu) {
        const isExpanded = menuItem.classList.contains('tadmenu-expanded');
        const btn = menuItem.querySelector(':scope > .tadmenu-link');

        if (isExpanded) {
            this._collapseSubmenu2(menuItem, submenu, btn);
        } else {
            this._expandSubmenu2(menuItem, submenu, btn);
        }
    }

    _expandSubmenu2(menuItem, submenu, btn) {
        menuItem.classList.add('tadmenu-expanded');
        if (btn) btn.setAttribute('aria-expanded', 'true');

        // 計算實際高度並設定
        submenu.style.maxHeight = '0';
        submenu.style.display = 'block';
        const scrollHeight = submenu.scrollHeight;
        submenu.style.maxHeight = scrollHeight + 'px';

        // 動畫結束後設為 none 讓子選單可自由展開
        setTimeout(() => {
            if (menuItem.classList.contains('tadmenu-expanded')) {
                submenu.style.maxHeight = 'none';
                submenu.classList.add('tadmenu-open');
            }
        }, this.options.animationDuration);

        // Tab 導航：展開後，直接子層連結加入 Tab 順序
        if (this.options.enableTabNavigation) {
            submenu.querySelectorAll(':scope > .tadmenu-item > .tadmenu-link').forEach(link => {
                link.setAttribute('tabindex', '0');
            });
        }
    }

    _collapseSubmenu2(menuItem, submenu, btn) {
        menuItem.classList.remove('tadmenu-expanded');
        if (btn) btn.setAttribute('aria-expanded', 'false');
        submenu.classList.remove('tadmenu-open');

        // 先設定固定高度，再動畫到 0
        submenu.style.maxHeight = submenu.scrollHeight + 'px';
        requestAnimationFrame(() => {
            submenu.style.maxHeight = '0';
        });

        setTimeout(() => {
            submenu.style.display = '';
        }, this.options.animationDuration);

        // Tab 導航：收合後，所有子層連結移出 Tab 順序
        if (this.options.enableTabNavigation) {
            submenu.querySelectorAll('.tadmenu-link').forEach(link => {
                link.setAttribute('tabindex', '-1');
            });
        }
    }

    _toggleSubmenu3Inline(menuItem, submenu) {
        const isExpanded = menuItem.classList.contains('tadmenu-expanded');
        const btn = menuItem.querySelector(':scope > .tadmenu-link');
        const isMobile = window.matchMedia('(max-width: 768px)').matches;

        if (isExpanded) {
            // 收合
            menuItem.classList.remove('tadmenu-expanded');
            if (btn) btn.setAttribute('aria-expanded', 'false');
            submenu.style.display = 'none';
            // 重設浮動定位
            submenu.style.position = '';
            submenu.style.top = '';
            submenu.style.left = '';
            // Tab 導航：移出 Tab 順序
            if (this.options.enableTabNavigation) {
                submenu.querySelectorAll('.tadmenu-link').forEach(link => {
                    link.setAttribute('tabindex', '-1');
                });
            }
        } else {
            // 先關閉其他已開啟的第三層選單
            this._closeAllInlineLevel3Menus();

            // 展開
            menuItem.classList.add('tadmenu-expanded');
            if (btn) btn.setAttribute('aria-expanded', 'true');
            submenu.style.display = 'block';

            if (!isMobile) {
                // 桌面版：浮動定位於觸發元素右側
                const rect = btn.getBoundingClientRect();
                submenu.style.top = rect.top + 'px';
                submenu.style.left = (rect.right + 8) + 'px';

                // 邊界檢測：確保不超出視窗
                requestAnimationFrame(() => {
                    const menuRect = submenu.getBoundingClientRect();
                    if (menuRect.right > window.innerWidth) {
                        submenu.style.left = (rect.left - menuRect.width - 8) + 'px';
                    }
                    if (menuRect.bottom > window.innerHeight) {
                        submenu.style.top = (rect.bottom - menuRect.height) + 'px';
                    }
                });
            }

            // Tab 導航：加入 Tab 順序
            if (this.options.enableTabNavigation) {
                submenu.querySelectorAll(':scope > .tadmenu-item > .tadmenu-link').forEach(link => {
                    link.setAttribute('tabindex', '0');
                });
            }
        }
    }

    _closeAllInlineLevel3Menus() {
        if (!this.container) return;
        this.container.querySelectorAll('.tadmenu-submenu-3-inline').forEach(submenu => {
            if (submenu.style.display !== 'none') {
                submenu.style.display = 'none';
                submenu.style.position = '';
                submenu.style.top = '';
                submenu.style.left = '';
                if (this.options.enableTabNavigation) {
                    submenu.querySelectorAll('.tadmenu-link').forEach(link => {
                        link.setAttribute('tabindex', '-1');
                    });
                }
                const parentItem = submenu.closest('.tadmenu-item');
                if (parentItem) {
                    parentItem.classList.remove('tadmenu-expanded');
                    const parentBtn = parentItem.querySelector(':scope > .tadmenu-link');
                    if (parentBtn) parentBtn.setAttribute('aria-expanded', 'false');
                }
            }
        });
    }

    _toggleFloatMenu(menuItem, floatMenuId, triggerEl) {
        const floatMenu = document.querySelector(`.tadmenu-submenu-3[data-float-menu-id="${floatMenuId}"]`);
        if (!floatMenu) return;

        const isVisible = floatMenu.style.display !== 'none';

        // 先關閉所有浮動選單
        this._closeAllFloatMenus();

        if (!isVisible) {
            this._openFloatMenu(menuItem, floatMenu, triggerEl);
        }
    }

    _openFloatMenu(menuItem, floatMenu, triggerEl) {
        const rect = triggerEl.getBoundingClientRect();
        const btn = menuItem.querySelector(':scope > .tadmenu-link');

        floatMenu.style.display = 'block';
        floatMenu.style.top = rect.top + 'px';
        floatMenu.style.left = rect.right + 8 + 'px';

        // 邊界檢測：確保不超出視窗
        requestAnimationFrame(() => {
            const menuRect = floatMenu.getBoundingClientRect();
            if (menuRect.right > window.innerWidth) {
                floatMenu.style.left = (rect.left - menuRect.width - 8) + 'px';
            }
            if (menuRect.bottom > window.innerHeight) {
                floatMenu.style.top = (rect.bottom - menuRect.height) + 'px';
            }
        });

        menuItem.classList.add('tadmenu-expanded');
        if (btn) btn.setAttribute('aria-expanded', 'true');
        this.activeLevel3 = floatMenu;
        this.activeLevel3Parent = menuItem;
    }

    _closeAllFloatMenus() {
        document.querySelectorAll('.tadmenu-submenu-3').forEach(menu => {
            menu.style.display = 'none';
        });
        if (this.activeLevel3Parent) {
            this.activeLevel3Parent.classList.remove('tadmenu-expanded');
            const btn = this.activeLevel3Parent.querySelector(':scope > .tadmenu-link');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        }
        this.activeLevel3 = null;
        this.activeLevel3Parent = null;
    }

    // ========================================
    // 鍵盤導航
    // ========================================

    _handleKeydown(e) {
        const menuLink = e.target.closest('.tadmenu-link');
        if (!menuLink) return;

        const menuItem = menuLink.closest('.tadmenu-item');
        if (!menuItem) return;

        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                this._focusNextItem(menuItem);
                break;
            case 'ArrowUp':
                e.preventDefault();
                this._focusPrevItem(menuItem);
                break;
            case 'ArrowRight':
                e.preventDefault();
                this._focusFirstChild(menuItem);
                break;
            case 'ArrowLeft':
            case 'Escape':
                e.preventDefault();
                this._focusParent(menuItem);
                break;
            case 'Home':
                e.preventDefault();
                this._focusFirstInGroup(menuItem);
                break;
            case 'End':
                e.preventDefault();
                this._focusLastInGroup(menuItem);
                break;
            case 'Enter':
            case ' ':
                if (menuLink.tagName === 'BUTTON') {
                    e.preventDefault();
                    menuLink.click();
                }
                break;
        }
    }

    _focusNextItem(menuItem) {
        const siblings = Array.from(menuItem.parentElement.children);
        const idx = siblings.indexOf(menuItem);
        const next = siblings[idx + 1];
        if (next) {
            const link = next.querySelector(':scope > .tadmenu-link');
            if (link) link.focus();
        }
    }

    _focusPrevItem(menuItem) {
        const siblings = Array.from(menuItem.parentElement.children);
        const idx = siblings.indexOf(menuItem);
        const prev = siblings[idx - 1];
        if (prev) {
            const link = prev.querySelector(':scope > .tadmenu-link');
            if (link) link.focus();
        }
    }

    _focusFirstChild(menuItem) {
        const submenu = menuItem.querySelector(':scope > .tadmenu-submenu-2, :scope > .tadmenu-submenu-3-inline');
        if (submenu) {
            const firstLink = submenu.querySelector('.tadmenu-link');
            if (firstLink) {
                // 若子選單未展開，先展開
                if (!menuItem.classList.contains('tadmenu-expanded')) {
                    menuItem.querySelector(':scope > .tadmenu-link').click();
                }
                setTimeout(() => firstLink.focus(), 50);
            }
        }
    }

    _focusParent(menuItem) {
        const parentUl = menuItem.parentElement;
        if (!parentUl) return;
        const parentItem = parentUl.closest('.tadmenu-item');
        if (parentItem) {
            const parentLink = parentItem.querySelector(':scope > .tadmenu-link');
            if (parentLink) {
                parentLink.focus();
                // 收合子選單
                const submenu = parentItem.querySelector(':scope > .tadmenu-submenu-2, :scope > .tadmenu-submenu-3-inline');
                if (submenu && parentItem.classList.contains('tadmenu-expanded')) {
                    parentLink.click();
                }
            }
        }
    }

    _focusFirstInGroup(menuItem) {
        const first = menuItem.parentElement.querySelector(':scope > .tadmenu-item > .tadmenu-link');
        if (first) first.focus();
    }

    _focusLastInGroup(menuItem) {
        const items = menuItem.parentElement.querySelectorAll(':scope > .tadmenu-item > .tadmenu-link');
        if (items.length > 0) items[items.length - 1].focus();
    }

    // ========================================
    // 無障礙設定
    // ========================================

    setupAccessibility() {
        const nav = this.container.querySelector('.tadmenu');
        if (!nav) return;

        // 設定所有按鈕的 ARIA 屬性
        nav.querySelectorAll('button.tadmenu-link').forEach(btn => {
            if (!btn.hasAttribute('aria-expanded')) {
                btn.setAttribute('aria-expanded', 'false');
            }
        });

        // 設定所有連結的 role
        nav.querySelectorAll('a.tadmenu-link').forEach(a => {
            if (!a.hasAttribute('role')) {
                a.setAttribute('role', 'menuitem');
            }
        });

        // Tab 鍵導航：第一層所有項目可被 Tab 到；子層在展開後才加入 Tab 順序
        if (this.options.enableTabNavigation) {
            // 第一層連結：tabindex=0（可直接 Tab 到）
            const level1Links = nav.querySelectorAll('.tadmenu-item[data-level="1"] > .tadmenu-link');
            level1Links.forEach(link => link.setAttribute('tabindex', '0'));
            // 第二、三層連結：tabindex=-1（預設隱藏，展開時才改為 0）
            const deeperLinks = nav.querySelectorAll(
                '.tadmenu-item[data-level="2"] > .tadmenu-link, .tadmenu-item[data-level="3"] > .tadmenu-link'
            );
            deeperLinks.forEach(link => link.setAttribute('tabindex', '-1'));
        }
    }

    // ========================================
    // 公開 API
    // ========================================

    /**
     * 展開指定 ID 的選單項目
     * @param {string} id
     */
    expand(id) {
        const item = this.container.querySelector(`.tadmenu-item[data-id="${id}"]`);
        if (!item) return;
        const submenu = item.querySelector(':scope > .tadmenu-submenu-2, :scope > .tadmenu-submenu-3-inline');
        if (submenu && !item.classList.contains('tadmenu-expanded')) {
            const btn = item.querySelector(':scope > .tadmenu-link');
            if (btn) btn.click();
        }
    }

    /**
     * 收合指定 ID 的選單項目
     * @param {string} id
     */
    collapse(id) {
        const item = this.container.querySelector(`.tadmenu-item[data-id="${id}"]`);
        if (!item) return;
        const submenu = item.querySelector(':scope > .tadmenu-submenu-2, :scope > .tadmenu-submenu-3-inline');
        if (submenu && item.classList.contains('tadmenu-expanded')) {
            const btn = item.querySelector(':scope > .tadmenu-link');
            if (btn) btn.click();
        }
    }

    /**
     * 展開到指定 ID（展開所有父層）
     * @param {string} id
     * @param {boolean} highlight - 是否高亮顯示目標項目
     */
    expandTo(id, highlight = false) {
        const targetItem = this.container.querySelector(`.tadmenu-item[data-id="${id}"]`);
        if (!targetItem) return;

        // 找出所有父層並展開
        let parent = targetItem.parentElement;
        while (parent && parent !== this.container) {
            if (parent.classList.contains('tadmenu-item')) {
                const submenu = parent.querySelector(':scope > .tadmenu-submenu-2, :scope > .tadmenu-submenu-3-inline');
                if (submenu && !parent.classList.contains('tadmenu-expanded')) {
                    const btn = parent.querySelector(':scope > .tadmenu-link');
                    if (btn) btn.click();
                }
            }
            parent = parent.parentElement;
        }

        // 高亮顯示目標項目
        if (highlight) {
            this.highlight(id);
        }
    }

    /**
     * 高亮顯示指定 ID 的選單項目
     * @param {string} id
     */
    highlight(id) {
        const item = this.container.querySelector(`.tadmenu-item[data-id="${id}"]`);
        if (!item) return;

        const link = item.querySelector(':scope > .tadmenu-link');
        if (!link) return;

        const theme = this.currentTheme;
        const highlightBg = theme ? theme.highlight.bgColor : '#fff3cd';
        const highlightBorder = theme ? theme.highlight.borderColor : '#ffc107';

        const originalBg = link.style.backgroundColor;
        link.style.backgroundColor = highlightBg;
        link.style.borderLeft = `4px solid ${highlightBorder}`;
        link.style.transition = 'background-color 0.3s ease';

        setTimeout(() => {
            link.style.backgroundColor = originalBg;
            link.style.borderLeft = '';
        }, this.options.highlightDuration);

        // 捲動到可見區域
        link.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /**
     * 取得目前展開的項目 ID 列表
     * @returns {string[]}
     */
    getExpandedIds() {
        const expanded = this.container.querySelectorAll('.tadmenu-item.tadmenu-expanded');
        return Array.from(expanded).map(item => item.dataset.id).filter(Boolean);
    }

    /**
     * 全部收合
     */
    collapseAll() {
        const expandedItems = this.container.querySelectorAll('.tadmenu-item.tadmenu-expanded');
        expandedItems.forEach(item => {
            const btn = item.querySelector(':scope > .tadmenu-link');
            if (btn) btn.click();
        });
        this._closeAllFloatMenus();
    }

    /**
     * 全部展開（第一層）
     */
    expandAll() {
        const level1Items = this.container.querySelectorAll('.tadmenu-item[data-level="1"]');
        level1Items.forEach(item => {
            const submenu = item.querySelector(':scope > .tadmenu-submenu-2');
            if (submenu && !item.classList.contains('tadmenu-expanded')) {
                const btn = item.querySelector(':scope > .tadmenu-link');
                if (btn) btn.click();
            }
        });
    }

    /**
     * 動態更新選單資料
     * @param {string} jsonPath - 新的 JSON 路徑
     */
    async reload(jsonPath = null) {
        if (jsonPath) {
            this.options.jsonPath = jsonPath;
        }
        TadMenu.clearCache(this.options.jsonPath);
        await this.init();
    }

    /**
     * 銷毀實例，清除事件與 DOM
     */
    destroy() {
        // 清除注入的樣式
        const styleEl = document.getElementById(`tadmenu-theme-styles-${this.instanceId}`);
        if (styleEl) styleEl.remove();

        // 清除浮動選單
        document.querySelectorAll('.tadmenu-submenu-3').forEach(menu => menu.remove());

        // 清除容器內容
        this.container.innerHTML = '';
        this.container.removeAttribute('data-tadmenu-instance');
    }
}