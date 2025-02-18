(function($) {
    // 用來存儲圖示的陣列
    let icons = [];
    let initialized = false;
    let settings = {};
    let basePath = '';

    // 從文字檔讀取圖示名稱並初始化選擇器
    function initializeIconPicker(path = '', options = {}) {
        // 如果已經初始化過，直接返回
        if (initialized) {
            return Promise.resolve();
        }

        // 預設選項
        const defaultOptions = {
            showIconName: true  // 預設顯示圖示名稱
        };

        // 合併選項
        settings = $.extend({}, defaultOptions, options);
        basePath = path.endsWith('/') ? path : path + '/';

        // 使用 Promise 來處理非同步載入
        return new Promise((resolve, reject) => {
            // 讀取免費圖示
            $.get(basePath + 'free.txt', function(freeData) {
                const freeIcons = freeData.split(',').map(name => ({
                    name: name.trim(),
                    type: 'fas'
                }));

                // 讀取品牌圖示
                $.get(basePath + 'brands.txt', function(brandData) {
                    const brandIcons = brandData.split(',').map(name => ({
                        name: name.trim(),
                        type: 'fab'
                    }));

                    // 合併兩種圖示
                    icons = [...freeIcons, ...brandIcons];

                    // 建立選擇器 HTML
                    const pickerHtml = `
                        <div class="icon-picker-container" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%);
                            background:white; padding:20px; border:1px solid #ccc; box-shadow:0 0 10px rgba(0,0,0,0.1); z-index:1000; min-width:400px;">
                            <div class="icon-picker-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                <div class="icon-picker-search" style="flex-grow:1; margin-right:10px;">
                                    <input type="text" placeholder="搜尋圖示..." style="width:100%; padding:5px;">
                                </div>
                                <div class="icon-display-toggle" style="white-space:nowrap;">
                                    <label style="display:flex; align-items:center;">
                                        <input type="checkbox" ${settings.showIconName ? 'checked' : ''} style="margin-right:5px;">
                                        顯示名稱
                                    </label>
                                </div>
                            </div>
                            <div class="icon-picker-icons" style="display:grid; grid-template-columns:repeat(5,1fr); gap:10px; max-height:300px; overflow-y:auto;">
                                ${icons.map(icon => `
                                    <div class="icon-item" data-icon="${icon.name}" data-type="${icon.type}"
                                        style="padding:10px; text-align:center; cursor:pointer; border:1px solid #eee;">
                                        <i class="${icon.type} fa-${icon.name}" style="font-size:20px;"></i>
                                        <div class="icon-name" style="font-size:12px; margin-top:5px; ${!settings.showIconName ? 'display:none;' : ''}">${icon.name}</div>
                                    </div>
                                `).join('')}
                            </div>
                            <div class="icon-picker-close" style="text-align:right; margin-top:10px;">
                                <button style="padding:5px 10px;">關閉</button>
                            </div>
                        </div>
                        <div class="icon-picker-backdrop" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0;
                            background:rgba(0,0,0,0.5); z-index:999;"></div>
                    `;

                    // 加入選擇器到 body
                    if (!$('.icon-picker-container').length) {
                        $('body').append(pickerHtml);
                    }

                    // 綁定事件
                    bindEvents();
                    initialized = true;
                    resolve();
                }).fail(reject);
            }).fail(reject);
        });
    }

    // 綁定所有事件
    function bindEvents() {
        const $picker = $('.icon-picker-container');
        const $backdrop = $('.icon-picker-backdrop');
        let $currentInput = null;

        // 切換顯示名稱
        $('.icon-display-toggle input').off('change').on('change', function() {
            const showNames = $(this).prop('checked');
            $('.icon-name').toggle(showNames);
        });

        // 搜尋功能
        $('.icon-picker-search input').off('input').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.icon-picker-icons .icon-item').each(function() {
                const $item = $(this);
                const iconName = $item.find('.icon-name').text().toLowerCase();
                if (iconName.includes(searchTerm)) {
                    $item.show();
                } else {
                    $item.hide();
                }
            });
        });

        // 選擇圖示
        $('.icon-item').off('click').on('click', function() {
            if ($currentInput) {
                const iconName = $(this).attr('data-icon');
                const iconType = $(this).attr('data-type');
                if (iconName && iconType) {
                    $currentInput.val(`${iconType} fa-${iconName}`);
                    closePicker();
                }
            }
        });

        // 關閉選擇器
        function closePicker() {
            $picker.hide();
            $backdrop.hide();
            // 清空搜尋框
            $('.icon-picker-search input').val('');
            // 重置搜尋結果，顯示所有圖示
            $('.icon-picker-icons .icon-item').show();
            $currentInput = null;
        }

        // 綁定關閉按鈕和背景點擊
        $('.icon-picker-close button, .icon-picker-backdrop').off('click').on('click', closePicker);

        // 使用事件委派來處理 icon-picker-input 的 focus 事件
        $(document).off('focus.iconPicker', '.icon-picker-input').on('focus.iconPicker', '.icon-picker-input', function() {
            $currentInput = $(this);
            $picker.show();
            $backdrop.show();
        });

        // 防止點擊選擇器時關閉
        $picker.off('click').on('click', function(e) {
            e.stopPropagation();
        });
    }

    // 插件定義
    $.fn.iconPicker = function(path = '', options = {}) {
        // 標記這些輸入框
        this.addClass('icon-picker-input');

        // 初始化選擇器（如果需要）
        if (!initialized) {
            initializeIconPicker(path, options);
        }

        return this;
    };

    // 新增重新初始化方法
    $.fn.iconPicker.reinitialize = function() {
        if (initialized && basePath) {
            bindEvents();
        }
    };
})(jQuery);