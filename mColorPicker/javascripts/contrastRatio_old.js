/**
 * 計算兩個顏色之間的對比度，並顯示在指定元素中
 * @param {string} displayElementId - 用於顯示對比度的元素ID
 * @param {string} targetColorId - 目標顏色輸入框的ID (必填)
 * @param {string} nowColorId - 當前活動元素顏色輸入框的ID (可選，如果不提供則使用當前活動元素)
 */
function ContrastRatio(displayElementId, targetColorId, nowColorId) {
    // 檢查必填參數
    if (!displayElementId || !targetColorId) {
        console.error('ContrastRatio: displayElementId 和 targetColorId 是必填參數');
        return;
    }

    // 將十六進制顏色轉換為RGB
    function hexToRgb(hex) {
        // 處理空值或transparent
        if (!hex) return null;
        if (hex.toLowerCase() === 'transparent') {
            return { r: 255, g: 255, b: 255, a: 0 }; // 完全透明
        }

        // 確保有 # 前綴
        if (hex.charAt(0) !== '#') {
            hex = '#' + hex;
        }

        // 處理8位十六進制顏色 (#RRGGBBAA)
        var hasAlpha = false;
        var alpha = 1;
        if (hex.length === 9) {
            hasAlpha = true;
            alpha = parseInt(hex.substr(7, 2), 16) / 255;
            hex = hex.substr(0, 7); // 移除alpha部分
        }

        // 擴展簡寫形式 (#RGB) 到完整形式 (#RRGGBB)
        const shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
        hex = hex.replace(shorthandRegex, function(m, r, g, b) {
            return r + r + g + g + b + b;
        });

        const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        if (result) {
            return {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16),
                a: hasAlpha ? alpha : 1
            };
        }
        return null;
    }

    // 混合半透明顏色與背景色 (假設背景為白色)
    function blendWithBackground(color) {
        if (!color) return { r: 255, g: 255, b: 255, a: 1 }; // 默認為白色
        if (color.a === 1) return color; // 如果不是半透明，直接返回

        // 白色背景
        const bg = {r: 255, g: 255, b: 255};

        // 混合公式: result = (1 - alpha) * background + alpha * foreground
        return {
            r: Math.round((1 - color.a) * bg.r + color.a * color.r),
            g: Math.round((1 - color.a) * bg.g + color.a * color.g),
            b: Math.round((1 - color.a) * bg.b + color.a * color.b),
            a: 1 // 混合後的顏色是不透明的
        };
    }

    // RGB對象轉回十六進制顏色
    function rgbToHex(rgb) {
        if (!rgb) return '#000000';
        if (rgb.a === 0) return 'transparent';

        function componentToHex(c) {
            var hex = c.toString(16);
            return hex.length === 1 ? "0" + hex : hex;
        }

        return "#" + componentToHex(rgb.r) + componentToHex(rgb.g) + componentToHex(rgb.b);
    }

    // 計算相對亮度
    function getLuminance(color) {
        if (!color) return 0;

        // 將RGB值轉換為相對亮度
        let r = color.r / 255;
        let g = color.g / 255;
        let b = color.b / 255;

        r = r <= 0.03928 ? r / 12.92 : Math.pow((r + 0.055) / 1.055, 2.4);
        g = g <= 0.03928 ? g / 12.92 : Math.pow((g + 0.055) / 1.055, 2.4);
        b = b <= 0.03928 ? b / 12.92 : Math.pow((b + 0.055) / 1.055, 2.4);

        // 計算相對亮度
        return 0.2126 * r + 0.7152 * g + 0.0722 * b;
    }

    // 獲取顏色值
    let bgColorHex, textColorHex;

    // 如果提供了nowColorId，使用該元素的值
    if (nowColorId) {
        bgColorHex = $('#' + nowColorId).val() || '#ffffff';
    }
    // 否則使用當前活動元素的值
    else {
        bgColorHex = $(document.activeElement).val() || '#ffffff';
    }

    // 使用提供的targetColorId
    textColorHex = $('#' + targetColorId).val() || '#000000';

    const $displayElement = $('#' + displayElementId);

    if (bgColorHex && textColorHex && $displayElement.length) {
        // 轉換為RGB並處理透明度
        let bgRgb = hexToRgb(bgColorHex);
        let textRgb = hexToRgb(textColorHex);

        // 如果有透明度，與白色背景混合
        if (bgRgb && bgRgb.a < 1) {
            bgRgb = blendWithBackground(bgRgb);
        }
        if (textRgb && textRgb.a < 1) {
            textRgb = blendWithBackground(textRgb);
        }

        // 計算對比度
        const bgLuminance = getLuminance(bgRgb);
        const textLuminance = getLuminance(textRgb);

        const ratio = (Math.max(bgLuminance, textLuminance) + 0.05) /
                     (Math.min(bgLuminance, textLuminance) + 0.05);

        // 設置對比度顯示 - 修改為只顯示小數點後一位
        const ratioText = ratio.toFixed(1) + ':1';
        $displayElement.text(ratioText);

        // 根據對比度值設置顏色
        if (parseFloat(ratio) < 4.5) {
            $displayElement.css('color', '#fc4c4e').css('font-size', '0.825rem');
        } else {
            $displayElement.css('color', '#0f69ad').css('font-size', '0.825rem');
        }

        // 調試信息 - 可以在控制台查看處理後的顏色值
        console.log('Background:', bgColorHex, '→', rgbToHex(bgRgb));
        console.log('Text:', textColorHex, '→', rgbToHex(textRgb));
        console.log('Contrast Ratio:', ratioText);
    }
}

// 存儲顏色對的關聯關係
var contrastRatioPairs = [];

/**
 * 設置顏色對的關聯關係，用於在顏色選擇器內部移動時更新對比度
 * @param {Array} pairs - 顏色對數組，格式為 [{display: 'displayId', color1: 'color1Id', color2: 'color2Id'}, ...]
 */
function setupContrastRatioPairs(pairs) {
    // contrastRatioPairs = pairs || [];
    contrastRatioPairs = contrastRatioPairs.concat(pairs || []);

    // 如果已經設置了顏色對，則覆蓋mColorPicker的setInputColor方法
    if (contrastRatioPairs.length > 0 && $.fn.mColorPicker) {
        var originalSetInputColor = $.fn.mColorPicker.setInputColor;
        $.fn.mColorPicker.setInputColor = function(id, color) {
            // 調用原始函數
            originalSetInputColor.apply(this, arguments);

            // 檢查是否需要更新對比度
            for (var i = 0; i < contrastRatioPairs.length; i++) {
                var pair = contrastRatioPairs[i];
                if (id === pair.color1 || id === pair.color2) {
                    ContrastRatio(pair.display, pair.color2, pair.color1);
                }
            }
        };

        // 覆蓋colorPicked方法，確保在顏色選擇後也能正確計算對比度
        var originalColorPicked = $.fn.mColorPicker.colorPicked;
        $.fn.mColorPicker.colorPicked = function(id) {
            // 調用原始函數
            originalColorPicked.apply(this, arguments);

            // 延遲執行，確保值已經更新
            setTimeout(function() {
                // 檢查是否需要更新對比度
                for (var i = 0; i < contrastRatioPairs.length; i++) {
                    var pair = contrastRatioPairs[i];
                    if (id === pair.color1 || id === pair.color2) {
                        ContrastRatio(pair.display, pair.color2, pair.color1);
                    }
                }

                // 更新所有相關的對比度顯示
                updateAllContrastRatios();
            }, 50);
        };
    }
}

/**
 * 更新所有已配置的對比度顯示
 */
function updateAllContrastRatios() {
    for (var i = 0; i < contrastRatioPairs.length; i++) {
        var pair = contrastRatioPairs[i];
        if ($('#' + pair.display).length && $('#' + pair.color1).length && $('#' + pair.color2).length) {
            ContrastRatio(pair.display, pair.color2, pair.color1);
        }
    }
}

// 在文檔加載完成後設置事件監聽
$(document).ready(function() {
    // 確保頁面完全加載後再計算對比度
    setTimeout(function() {
        updateAllContrastRatios();
    }, 100);

    // 為mColorPicker添加事件，當顏色選擇器更新時觸發對比度計算
    $(document).on('colorpicked', '.mColorPicker', function() {
        var id = $(this).attr('id');

        // 延遲執行，確保值已經更新
        setTimeout(function() {
            // 更新所有相關的對比度顯示
            updateAllContrastRatios();
        }, 50);
    });

    // 監聽顏色輸入框的值變化
    $('.color-picker').on('change', function() {
        // 延遲執行，確保值已經更新
        setTimeout(function() {
            // 更新所有相關的對比度顯示
            updateAllContrastRatios();
        }, 50);
    });
});