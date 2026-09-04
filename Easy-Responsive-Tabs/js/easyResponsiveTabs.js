// Easy Responsive Tabs Plugin
// Author: Samson.Onna <Email : samson3d@gmail.com>
// Modified for WCAG 2.3 AAA compliance with keyboard navigation
// Fixed Tab key navigation order - Tab1Title → Tab1Content → Tab2Title → Tab2Content...

// jQuery 4.0+ compatibility shim — restores .bind() and the
// click/focus/blur/keydown/resize event shorthand methods that
// jQuery 4.0 removed, so the code below (originally written for
// older jQuery) keeps working unchanged. Only applies when the
// method is missing, so it's safe alongside jQuery < 4.0 too.
(function ($) {
    "use strict";
    if (!$) { return; }
    $.fn.bind = $.fn.bind || function (types, data, fn) { return this.on(types, null, data, fn); };
    $.each(("blur focus focusin focusout resize scroll click dblclick " +
        "mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave " +
        "change select submit keydown keypress keyup contextmenu").split(" "), function (i, name) {
        if (!$.fn[name]) {
            $.fn[name] = function (data, fn) {
                return arguments.length > 0 ? this.on(name, null, data, fn) : this.trigger(name);
            };
        }
    });
})(jQuery);

(function ($) {
    $.fn.extend({
        easyResponsiveTabs: function (options) {
            //Set the default values, use comma to separate the settings, example:
            var defaults = {
                type: 'default', //default, vertical, accordion;
                width: 'auto',
                fit: true,
                closed: false,
                tabidentify: '',
                activetab_bg: 'white',
                inactive_bg: '#d0d2d4',
                active_border_color: '#20356e',
                active_content_border_color: '#661414',
                activate: function () {
                }
            };
            //Variables
            options = $.extend(defaults, options);
            var opt = options, jtype = opt.type, jfit = opt.fit, jwidth = opt.width, vtabs = 'vertical', accord = 'accordion';
            var hash = window.location.hash;
            var historyApi = !!(window.history && history.replaceState);

            //Events
            $(this).bind('tabactivate', function (e, currentTab) {
                if (typeof options.activate === 'function') {
                    options.activate.call(currentTab, e);
                }
            });

            //Main function
            this.each(function () {
                var $respTabs = $(this);
                var $respTabsList = $respTabs.find('ul.resp-tabs-list.' + options.tabidentify);
                var respTabsId = $respTabs.attr('id');

                // 確保容器有一個role="tablist"
                $respTabsList.attr('role', 'tablist');

                $respTabs.find('ul.resp-tabs-list.' + options.tabidentify + ' li').addClass('resp-tab-item').addClass(options.tabidentify);
                $respTabs.css({
                    'display': 'block',
                    'width': jwidth
                });

                if (options.type == 'vertical') {
                    $respTabsList.css('margin-top', '3px');
                }

                $respTabs.find('.resp-tabs-container.' + options.tabidentify).css('border-color', options.active_content_border_color);
                $respTabs.find('.resp-tabs-container.' + options.tabidentify + ' > div').addClass('resp-tab-content').addClass(options.tabidentify);
                jtab_options();

                //Properties Function
                function jtab_options() {
                    if (jtype == vtabs) {
                        $respTabs.addClass('resp-vtabs').addClass(options.tabidentify);
                    }
                    if (jfit === true) {
                        $respTabs.css({ width: '100%', margin: '0px' });
                    }
                    if (jtype == accord) {
                        $respTabs.addClass('resp-easy-accordion').addClass(options.tabidentify);
                        $respTabs.find('.resp-tabs-list').css('display', 'none');
                    }
                }

                // 統一判斷目前是否為手風琴顯示模式
                function isAccordionMode() {
                    return jtype == accord || !$respTabsList.is(':visible');
                }

                //Assigning the h2 markup to accordion title
                var $tabItemh2;
                $respTabs.find('.resp-tab-content.' + options.tabidentify).before("<h2 class='resp-accordion " + options.tabidentify + "'><span class='resp-arrow'></span></h2>");

                $respTabs.find('.resp-tab-content.' + options.tabidentify).prev("h2").css({
                    'background-color': options.inactive_bg,
                    'border-color': options.active_border_color
                });

                var itemCount = 0;
                $respTabs.find('.resp-accordion').each(function () {
                    $tabItemh2 = $(this);
                    var $tabItem = $respTabs.find('.resp-tab-item:eq(' + itemCount + ')');
                    var $accItem = $respTabs.find('.resp-accordion:eq(' + itemCount + ')');
                    $accItem.append($tabItem.html());
                    $accItem.data($tabItem.data());
                    $tabItemh2.attr('aria-controls', options.tabidentify + '_tab_item-' + itemCount);
                    $tabItemh2.attr('data-tab-index', itemCount); // 添加索引標記

                    // 手風琴標題設定
                    $tabItemh2.attr({
                        'role': 'button',
                        'tabindex': '0',
                        'aria-haspopup': 'true',
                        'aria-expanded': 'false'
                    });

                    itemCount++;
                });

                //Assigning the 'aria-controls' to Tab items
                var count = 0, $tabContent;
                $respTabs.find('.resp-tab-item').each(function () {
                    var $tabItem = $(this);
                    $tabItem.attr('aria-controls', options.tabidentify + '_tab_item-' + count);
                    $tabItem.attr('data-tab-index', count); // 添加索引標記
                    $tabItem.attr('role', 'tab');
                    $tabItem.attr('aria-selected', 'false');
                    $tabItem.attr('tabindex', '0');
                    $tabItem.css({
                        'background-color': options.inactive_bg,
                        'border-color': 'none'
                    });

                    count++;
                });

                //Assigning the 'aria-labelledby' attr to tab-content
                var tabcount = 0;
                $respTabs.find('.resp-tab-content.' + options.tabidentify).each(function () {
                    $tabContent = $(this);
                    $tabContent.attr('aria-labelledby', options.tabidentify + '_tab_item-' + tabcount);
                    $tabContent.attr('data-content-index', tabcount); // 添加索引標記
                    $tabContent.attr('role', 'tabpanel');
                    $tabContent.attr('aria-hidden', 'true');
                    $tabContent.attr('tabindex', '0'); // 保持可被 Tab 訪問（供交錯順序使用）
                    $tabContent.css({
                        'border-color': options.active_border_color
                    });
                    tabcount++;
                });

                // Show correct content area
                var tabNum = 0;
                if (hash !== '') {
                    var matches = hash.match(new RegExp(respTabsId + "([0-9]+)"));
                    if (matches !== null && matches.length === 2) {
                        tabNum = parseInt(matches[1], 10) - 1;
                        if (tabNum > count) {
                            tabNum = 0;
                        }
                    }
                }

                // 管理可聚焦狀態
                function updateTabSequence() {
                    var inAccordion = isAccordionMode();

                    if (inAccordion) {
                        // 手風琴模式：禁用桌面 tabs；啟用 accordion 標題與所有內容
                        $respTabs.find('.resp-tab-item.' + options.tabidentify).attr('tabindex', '-1');
                        $respTabs.find('.resp-accordion.' + options.tabidentify).attr('tabindex', '0');
                    } else {
                        // 頁籤模式：啟用桌面 tabs；禁用 accordion 標題
                        $respTabs.find('.resp-tab-item.' + options.tabidentify).attr('tabindex', '0');
                        $respTabs.find('.resp-accordion.' + options.tabidentify).attr('tabindex', '-1');
                    }

                    // 所有內容都可聚焦，交錯順序由自訂 Tab 導航控制
                    $respTabs.find('.resp-tab-content.' + options.tabidentify).attr('tabindex', '0');
                }

                // 取得容器內所有可聚焦的元素 (新增的輔助函式)
                function getFocusables($container) {
                    return $container.find('a[href], button, input, textarea, select, details, [tabindex]:not([tabindex="-1"])').filter(function () {
                        return $(this).is(':visible') && !$(this).is(':disabled');
                    });
                }

                // 交錯 Tab 導航（含 Shift+Tab），支援內容區域內的焦點元素
                function handleInterleavedTabNavigation(e) {
                    if (e.keyCode !== 9) {
                        return;
                    }

                    var inAccordion = isAccordionMode();
                    var $titles = inAccordion
                        ? $respTabs.find('.resp-accordion.' + options.tabidentify)
                        : $respTabs.find('.resp-tab-item.' + options.tabidentify);
                    var $contents = $respTabs.find('.resp-tab-content.' + options.tabidentify);

                    var currentEl = e.target;
                    var isShift = e.shiftKey;

                    var titleIndex = $titles.index(currentEl);
                    var isInsideContent = false;
                    var contentIndex = -1;

                    var $parentContent = $(currentEl).closest('.resp-tab-content.' + options.tabidentify);
                    if ($parentContent.length && $parentContent.closest($respTabs).length) {
                        isInsideContent = true;
                        contentIndex = $contents.index($parentContent);
                    }

                    if (titleIndex !== -1) {
                        // 狀態 1：目前焦點在「標題」上
                        var $targetTab = $titles.eq(titleIndex);

                        if (!isShift) {
                            // Tab: 往後導航
                            if (inAccordion && !$targetTab.hasClass('resp-tab-active')) {
                                // 💡 關鍵修改：手風琴模式且未展開時，不攔截，讓瀏覽器原生 Tab 走到下一個標題
                                return;
                            }

                            e.preventDefault();
                            // 頁籤模式，或手風琴模式且已展開：進入內容區域
                            if (!$targetTab.hasClass('resp-tab-active')) {
                                activateTab($targetTab);
                            }
                            $contents.eq(titleIndex).focus();
                        } else {
                            // Shift+Tab: 往前導航
                            if (titleIndex > 0) {
                                var $prevTab = $titles.eq(titleIndex - 1);

                                if (inAccordion && !$prevTab.hasClass('resp-tab-active')) {
                                    // 💡 關鍵修改：手風琴模式且上一個未展開時，不攔截，讓瀏覽器原生 Shift+Tab 走到上一個標題
                                    return;
                                }

                                e.preventDefault();
                                if (!$prevTab.hasClass('resp-tab-active')) {
                                    activateTab($prevTab);
                                }
                                var $prevContent = $contents.eq(titleIndex - 1);
                                var $focusables = getFocusables($prevContent);
                                if ($focusables.length > 0) {
                                    $focusables.last().focus();
                                } else {
                                    $prevContent.focus();
                                }
                            }
                            // 若為第一個標題，則不攔截，讓瀏覽器原生處理（離開元件）
                        }
                    } else if (isInsideContent) {
                        // 狀態 2：目前焦點在「內容區域」內（或內容區域本身）
                        var $focusables = getFocusables($parentContent);
                        var isFirst = false;
                        var isLast = false;

                        if ($focusables.length === 0) {
                            // 內容區沒有其他可聚焦元素
                            isFirst = (currentEl === $parentContent[0]);
                            isLast = (currentEl === $parentContent[0]);
                        } else {
                            // 判斷是否在邊界元素上
                            isFirst = (currentEl === $parentContent[0] || currentEl === $focusables[0]);
                            isLast = (currentEl === $focusables[$focusables.length - 1]);
                        }

                        if (!isShift && isLast) {
                            // Tab 且在最後一個元素: 移動到下一個標題
                            if (contentIndex < $titles.length - 1) {
                                e.preventDefault();
                                $titles.eq(contentIndex + 1).focus();
                            }
                            // 若為最後一個內容區域，則不攔截，讓瀏覽器原生處理（離開元件）
                        } else if (isShift && isFirst) {
                            // Shift+Tab 且在第一個元素: 移動到對應的標題
                            e.preventDefault();
                            $titles.eq(contentIndex).focus();
                        }
                    }
                }

                //Active correct tab
                var $activeTab = $($respTabs.find('.resp-tab-item.' + options.tabidentify)[tabNum]);
                $activeTab.addClass('resp-tab-active').css({
                    'background-color': options.activetab_bg,
                    'border-color': options.active_border_color
                }).attr('aria-selected', 'true').attr('tabindex', '0');

                //keep closed if option = 'closed' or option is 'accordion' and the element is in accordion mode
                if (options.closed !== true && !(options.closed === 'accordion' && !$respTabsList.is(':visible')) && !(options.closed === 'tabs' && $respTabsList.is(':visible'))) {
                    var $activeAccordion = $($respTabs.find('.resp-accordion.' + options.tabidentify)[tabNum]);
                    $activeAccordion.addClass('resp-tab-active').css({
                        'background-color': options.activetab_bg + ' !important',
                        'border-color': options.active_border_color,
                        'background': 'none'
                    }).attr('aria-selected', 'true').attr('aria-expanded', 'true');

                    var $activeContent = $($respTabs.find('.resp-tab-content.' + options.tabidentify)[tabNum]);
                    $activeContent.addClass('resp-tab-content-active').addClass(options.tabidentify).attr('style', 'display:block').css({
                        'background-color': options.activetab_bg,
                        'border-color': options.active_border_color
                    }).attr('aria-hidden', 'false').attr('tabindex', '0');
                }

                // 激活頁籤的函數
                function activateTab($tab) {
                    var $tabAria = $tab.attr('aria-controls');

                    // 重設所有頁籤的選中狀態
                    $respTabs.find("[role=tab]").attr('aria-selected', 'false').removeClass('resp-tab-active').css({
                        'background-color': options.inactive_bg,
                        'border-color': 'none'
                    });

                    // 重設所有手風琴按鈕的展開狀態
                    $respTabs.find("[role=button]").attr('aria-expanded', 'false').removeClass('resp-tab-active').css({
                        'background-color': options.inactive_bg,
                        'border-color': 'none'
                    });

                    // 隱藏所有內容區域 (加入 stop 停止動畫，並清除 resp-accordion-closed)
                    $respTabs.find('.resp-tab-content.' + options.tabidentify)
                        .stop(true, true)
                        .removeClass('resp-tab-content-active resp-accordion-closed')
                        .attr('aria-hidden', 'true')
                        .removeAttr('style');

                    // 激活當前頁籤
                    var $activeElements = $respTabs.find("[aria-controls=" + $tabAria + "]");
                    $activeElements.addClass('resp-tab-active').css({
                        'background-color': options.activetab_bg,
                        'border-color': options.active_border_color
                    });

                    // 根據元素類型設定不同的 aria 屬性
                    $respTabs.find("[aria-controls=" + $tabAria + "][role=tab]").attr('aria-selected', 'true');
                    $respTabs.find("[aria-controls=" + $tabAria + "][role=button]").attr('aria-expanded', 'true');

                    // 顯示對應的內容區域 (確保移除 resp-accordion-closed)
                    var $activeContent = $respTabs.find('.resp-tab-content[aria-labelledby=' + $tabAria + '].' + options.tabidentify);
                    $activeContent
                        .addClass('resp-tab-content-active')
                        .removeClass('resp-accordion-closed')
                        .attr('aria-hidden', 'false')
                        .attr('style', 'display:block')
                        .css({
                            'background-color': options.activetab_bg,
                            'border-color': options.active_border_color
                        });

                    // 更新可聚焦狀態
                    updateTabSequence();

                    //Update Browser History
                    if (historyApi) {
                        var currentHash = window.location.hash;
                        var tabAriaParts = $tabAria.split('tab_item-');
                        var newHash = respTabsId + (parseInt(tabAriaParts[1], 10) + 1).toString();
                        if (currentHash !== "") {
                            var re = new RegExp(respTabsId + "[0-9]+");
                            if (currentHash.match(re) !== null) {
                                newHash = currentHash.replace(re, newHash);
                            } else {
                                newHash = currentHash + "|" + newHash;
                            }
                        } else {
                            newHash = '#' + newHash;
                        }

                        history.replaceState(null, null, newHash);
                    }

                    //Trigger tab activation event
                    $tab.trigger('tabactivate', $tab);
                }

                // 處理手風琴收合的特殊情況
                function handleAccordionClick($tab) {
                    if ($tab.hasClass('resp-accordion') && $tab.hasClass('resp-tab-active')) {
                        var $activeContent = $respTabs.find('.resp-tab-content-active.' + options.tabidentify);

                        // 停止任何進行中的動畫，避免與 activateTab 衝突
                        $activeContent.stop(true, true).slideUp('fast', function () {
                            $(this).addClass('resp-accordion-closed').attr('aria-hidden', 'true');
                        });

                        // 移除標題的 active 狀態
                        $tab.removeClass('resp-tab-active').css({
                            'background-color': options.inactive_bg,
                            'border-color': 'none'
                        }).attr('aria-selected', 'false').attr('aria-expanded', 'false');

                        // 確實移除內容的 active 狀態，避免狀態殘留
                        $activeContent.removeClass('resp-tab-content-active');

                        updateTabSequence();
                        return true;
                    }
                    return false;
                }

                //Tab Click action & Keyboard event
                $respTabs.find("[role=tab], [role=button]").each(function () {
                    var $currentTab = $(this);

                    // 點擊事件處理
                    $currentTab.click(function () {
                        var $clicked = $(this);

                        if (handleAccordionClick($clicked)) {
                            return false;
                        }

                        activateTab($clicked);
                        return false;
                    });

                    // 焦點事件處理
                    $currentTab.focus(function () {
                        $(this).css('outline', '2px solid #005fcc');
                    });

                    $currentTab.blur(function () {
                        $(this).css('outline', 'none');
                    });

                    // 鍵盤事件處理
                    $currentTab.keydown(function (e) {
                        // 先處理 Tab 交錯導航
                        if (e.keyCode === 9) {
                            handleInterleavedTabNavigation(e);
                            return;
                        }

                        var $focusedTab = $(this);
                        var inAccordion = isAccordionMode();
                        var $allTabs = inAccordion ?
                            $respTabs.find('.resp-accordion.' + options.tabidentify) :
                            $respTabs.find('.resp-tab-item.' + options.tabidentify);

                        switch (e.keyCode) {
                            case 13: // Enter
                            case 32: // Space
                                e.preventDefault();
                                if (!handleAccordionClick($focusedTab)) {
                                    activateTab($focusedTab);
                                }
                                break;

                            case 37: // 左箭頭
                            case 38: // 上箭頭
                                e.preventDefault();
                                var currentIndex = $allTabs.index($focusedTab);
                                var $prevTab = currentIndex === 0 ? $allTabs.last() : $allTabs.eq(currentIndex - 1);

                                if ($prevTab.length) {
                                    activateTab($prevTab);
                                    $prevTab.focus();
                                }
                                break;

                            case 39: // 右箭頭
                            case 40: // 下箭頭
                                e.preventDefault();
                                var currentIdx = $allTabs.index($focusedTab);
                                var $nextTab = currentIdx === $allTabs.length - 1 ? $allTabs.first() : $allTabs.eq(currentIdx + 1);

                                if ($nextTab.length) {
                                    activateTab($nextTab);
                                    $nextTab.focus();
                                }
                                break;

                            case 36: // Home
                                e.preventDefault();
                                var $firstTab = $allTabs.first();
                                if ($firstTab.length) {
                                    activateTab($firstTab);
                                    $firstTab.focus();
                                }
                                break;

                            case 35: // End
                                e.preventDefault();
                                var $lastTab = $allTabs.last();
                                if ($lastTab.length) {
                                    activateTab($lastTab);
                                    $lastTab.focus();
                                }
                                break;
                        }
                    });
                });

                // 處理內容區域的焦點樣式與 Tab 交錯導航
                $respTabs.find('.resp-tab-content')
                    .focus(function () {
                        $(this).css('outline', '2px solid #005fcc');
                    })
                    .blur(function () {
                        $(this).css('outline', 'none');
                    })
                    .keydown(function (e) {
                        if (e.keyCode === 9) {
                            handleInterleavedTabNavigation(e);
                        }
                    });

                // 初始化可聚焦狀態
                updateTabSequence();

                //Window resize function
                $(window).resize(function () {
                    $respTabs.find('.resp-accordion-closed').removeAttr('style');
                    updateTabSequence();
                });
            });
        }
    });
})(jQuery);
