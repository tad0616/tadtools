// Easy Responsive Tabs Plugin
// Author: Samson.Onna <Email : samson3d@gmail.com>
// Modified for WCAG 2.3 AAA compliance with keyboard navigation
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
                inactive_bg: '#F5F5F5',
                active_border_color: '#c1c1c1',
                active_content_border_color: '#c1c1c1',
                activate: function () {
                }
            }
            //Variables
            var options = $.extend(defaults, options);
            var opt = options, jtype = opt.type, jfit = opt.fit, jwidth = opt.width, vtabs = 'vertical', accord = 'accordion';
            var hash = window.location.hash;
            var historyApi = !!(window.history && history.replaceState);

            //Events
            $(this).bind('tabactivate', function (e, currentTab) {
                if (typeof options.activate === 'function') {
                    options.activate.call(currentTab, e)
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

                if (options.type == 'vertical')
                    $respTabsList.css('margin-top', '3px');

                $respTabs.find('.resp-tabs-container.' + options.tabidentify).css('border-color', options.active_content_border_color);
                $respTabs.find('.resp-tabs-container.' + options.tabidentify + ' > div').addClass('resp-tab-content').addClass(options.tabidentify);
                jtab_options();

                //Properties Function
                function jtab_options() {
                    if (jtype == vtabs) {
                        $respTabs.addClass('resp-vtabs').addClass(options.tabidentify);
                    }
                    if (jfit == true) {
                        $respTabs.css({ width: '100%', margin: '0px' });
                    }
                    if (jtype == accord) {
                        $respTabs.addClass('resp-easy-accordion').addClass(options.tabidentify);
                        $respTabs.find('.resp-tabs-list').css('display', 'none');
                    }
                }

                // [修正1] 統一判斷目前是否為手風琴顯示模式
                // 純手風琴類型（jtype == accord）或響應式縮放導致頁籤列隱藏時，均視為手風琴模式
                function isAccordionMode() {
                    return jtype == accord || !$respTabsList.is(':visible');
                }

                //Assigning the h2 markup to accordion title
                var $tabItemh2;
                $respTabs.find('.resp-tab-content.' + options.tabidentify).before("<h2 class='resp-accordion " + options.tabidentify + "' role='tab'><span class='resp-arrow'></span></h2>");

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
                    $tabItemh2.attr('aria-controls', options.tabidentify + '_tab_item-' + (itemCount));
                    // [修正2] 所有手風琴標題預設 tabindex="0"，確保縮放後可被 Tab 鍵逐一聚焦
                    $tabItemh2.attr('tabindex', '0');
                    itemCount++;
                });

                //Assigning the 'aria-controls' to Tab items
                var count = 0,
                    $tabContent;
                $respTabs.find('.resp-tab-item').each(function () {
                    $tabItem = $(this);
                    $tabItem.attr('aria-controls', options.tabidentify + '_tab_item-' + (count));
                    $tabItem.attr('role', 'tab');
                    $tabItem.attr('aria-selected', 'false');
                    $tabItem.attr('tabindex', '-1'); // 頁籤模式：採用 roving tabindex，預設 -1
                    $tabItem.css({
                        'background-color': options.inactive_bg,
                        'border-color': 'none'
                    });

                    //Assigning the 'aria-labelledby' attr to tab-content
                    var tabcount = 0;
                    $respTabs.find('.resp-tab-content.' + options.tabidentify).each(function () {
                        $tabContent = $(this);
                        $tabContent.attr('aria-labelledby', options.tabidentify + '_tab_item-' + (tabcount));
                        $tabContent.attr('role', 'tabpanel');
                        $tabContent.attr('aria-hidden', 'true');
                        $tabContent.css({
                            'border-color': options.active_border_color
                        });
                        tabcount++;
                    });
                    count++;
                });

                // Show correct content area
                var tabNum = 0;
                if (hash != '') {
                    var matches = hash.match(new RegExp(respTabsId + "([0-9]+)"));
                    if (matches !== null && matches.length === 2) {
                        tabNum = parseInt(matches[1], 10) - 1;
                        if (tabNum > count) {
                            tabNum = 0;
                        }
                    }
                }

                //Active correct tab
                var $activeTab = $($respTabs.find('.resp-tab-item.' + options.tabidentify)[tabNum]);
                $activeTab.addClass('resp-tab-active').css({
                    'background-color': options.activetab_bg,
                    'border-color': options.active_border_color
                }).attr('aria-selected', 'true').attr('tabindex', '0'); // 頁籤模式：作用中頁籤 tabindex=0

                //keep closed if option = 'closed' or option is 'accordion' and the element is in accordion mode
                if (options.closed !== true && !(options.closed === 'accordion' && !$respTabsList.is(':visible')) && !(options.closed === 'tabs' && $respTabsList.is(':visible'))) {
                    $($respTabs.find('.resp-accordion.' + options.tabidentify)[tabNum]).addClass('resp-tab-active').css({
                        'background-color': options.activetab_bg + ' !important',
                        'border-color': options.active_border_color,
                        'background': 'none'
                    }).attr('aria-selected', 'true');
                    // 手風琴標題的 tabindex 已在上方統一設為 0，此處無需額外覆寫

                    var $activeContent = $($respTabs.find('.resp-tab-content.' + options.tabidentify)[tabNum]);
                    $activeContent.addClass('resp-tab-content-active').addClass(options.tabidentify).attr('style', 'display:block').css({
                        'background-color': options.activetab_bg,
                        'border-color': options.active_border_color
                    }).attr('aria-hidden', 'false');
                }

                // 激活頁籤的函數
                function activateTab($tab) {
                    var $tabAria = $tab.attr('aria-controls');

                    // 重設所有頁籤與手風琴的狀態
                    $respTabs.find("[role=tab]").attr({
                        'aria-selected': 'false',
                        'tabindex': '-1'
                    }).removeClass('resp-tab-active').css({
                        'background-color': options.inactive_bg,
                        'border-color': 'none'
                    });

                    // [修正3] 手風琴模式下，重設後將所有手風琴標題的 tabindex 還原為 0
                    // 確保 Tab 鍵仍可遍歷全部手風琴項目（accordion 不使用 roving tabindex 模式）
                    if (isAccordionMode()) {
                        $respTabs.find('.resp-accordion.' + options.tabidentify).attr('tabindex', '0');
                    }

                    // 隱藏所有內容區域
                    $respTabs.find('.resp-tab-content.' + options.tabidentify)
                        .removeClass('resp-tab-content-active')
                        .attr('aria-hidden', 'true')
                        .removeAttr('style');

                    // 激活當前頁籤（同時套用至對應的手風琴標題或頁籤項目）
                    $respTabs.find("[aria-controls=" + $tabAria + "]").addClass('resp-tab-active').css({
                        'background-color': options.activetab_bg,
                        'border-color': options.active_border_color
                    }).attr({
                        'aria-selected': 'true',
                        'tabindex': '0'
                    });

                    // 顯示對應的內容區域
                    $respTabs.find('.resp-tab-content[aria-labelledby = ' + $tabAria + '].' + options.tabidentify)
                        .addClass('resp-tab-content-active')
                        .attr('aria-hidden', 'false')
                        .attr('style', 'display:block')
                        .css({
                            'background-color': options.activetab_bg,
                            'border-color': options.active_border_color
                        });

                    //Update Browser History
                    if (historyApi) {
                        var currentHash = window.location.hash;
                        var tabAriaParts = $tabAria.split('tab_item-');
                        var newHash = respTabsId + (parseInt(tabAriaParts[1], 10) + 1).toString();
                        if (currentHash != "") {
                            var re = new RegExp(respTabsId + "[0-9]+");
                            if (currentHash.match(re) != null) {
                                newHash = currentHash.replace(re, newHash);
                            }
                            else {
                                newHash = currentHash + "|" + newHash;
                            }
                        }
                        else {
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
                        $respTabs.find('.resp-tab-content-active.' + options.tabidentify).slideUp('', function () {
                            $(this).addClass('resp-accordion-closed').attr('aria-hidden', 'true');
                        });
                        $tab.removeClass('resp-tab-active').css({
                            'background-color': options.inactive_bg,
                            'border-color': 'none'
                        }).attr('aria-selected', 'false');
                        return true;
                    }
                    return false;
                }

                //Tab Click action & Keyboard event
                $respTabs.find("[role=tab]").each(function () {
                    var $currentTab = $(this);

                    // 點擊事件處理
                    $currentTab.click(function () {
                        var $currentTab = $(this);

                        if (handleAccordionClick($currentTab)) {
                            return false;
                        }

                        activateTab($currentTab);
                        return false;
                    });

                    // 鍵盤事件處理
                    $currentTab.keydown(function(e) {
                        var $currentTab = $(this);

                        // [修正4] 使用 isAccordionMode() 動態判斷目前顯示模式
                        // 修正原本僅依賴 jtype == accord 的靜態判斷，使響應式縮放場景也能正確導航
                        var inAccordion = isAccordionMode();
                        var $tabList, $firstTab, $lastTab, index, $prevTab, $nextTab;

                        if (inAccordion) {
                            // 手風琴模式：以 h2.resp-accordion 清單為導航目標
                            $tabList = $respTabs.find('.resp-accordion.' + options.tabidentify);
                        } else {
                            // 頁籤模式：以 li.resp-tab-item 清單為導航目標
                            $tabList = $respTabs.find('.resp-tab-item.' + options.tabidentify);
                        }

                        $firstTab = $tabList.first();
                        $lastTab = $tabList.last();
                        index = $tabList.index($currentTab);

                        if (index >= 0) {
                            $prevTab = index === 0 ? $lastTab : $tabList.eq(index - 1);
                            $nextTab = index === $tabList.length - 1 ? $firstTab : $tabList.eq(index + 1);
                        }

                        switch (e.keyCode) {
                            case 13: // Enter
                            case 32: // Space
                                e.preventDefault();
                                // [修正5] 鍵盤觸發時同樣需要呼叫 handleAccordionClick
                                // 修正原本僅有點擊才能收合，Enter/Space 無法收合已展開的手風琴項目
                                if (!handleAccordionClick($currentTab)) {
                                    activateTab($currentTab);
                                }
                                break;

                            case 37: // 左箭頭
                            case 38: // 上箭頭
                                e.preventDefault();
                                if ($prevTab) {
                                    $prevTab.focus();
                                    // 頁籤模式：移動焦點即自動切換；手風琴模式：僅移動焦點，需 Enter/Space 展開
                                    if (!inAccordion) {
                                        activateTab($prevTab);
                                    }
                                }
                                break;

                            case 39: // 右箭頭
                            case 40: // 下箭頭
                                e.preventDefault();
                                if ($nextTab) {
                                    $nextTab.focus();
                                    if (!inAccordion) {
                                        activateTab($nextTab);
                                    }
                                }
                                break;

                            case 36: // Home
                                e.preventDefault();
                                $firstTab.focus();
                                if (!inAccordion) {
                                    activateTab($firstTab);
                                }
                                break;

                            case 35: // End
                                e.preventDefault();
                                $lastTab.focus();
                                if (!inAccordion) {
                                    activateTab($lastTab);
                                }
                                break;
                        }
                    });
                });

                // 處理頁籤的焦點樣式
                $respTabs.find('.resp-tab-item').focus(function() {
                    $(this).css('outline', '1px dashed #000');
                }).blur(function() {
                    $(this).css('outline', 'none');
                });

                // 處理手風琴的焦點樣式
                $respTabs.find('.resp-accordion').focus(function() {
                    $(this).css('outline', '1px dashed #000');
                }).blur(function() {
                    $(this).css('outline', 'none');
                });

                //Window resize function
                $(window).resize(function () {
                    $respTabs.find('.resp-accordion-closed').removeAttr('style');

                    // [修正6] 視窗縮放（含頁面放大/縮小）時，同步更新 tabindex
                    // 切換至手風琴模式時，所有手風琴標題 tabindex=0（可逐一 Tab 聚焦）
                    // 切換回頁籤模式時，採用 roving tabindex，僅作用中頁籤 tabindex=0
                    if (isAccordionMode()) {
                        $respTabs.find('.resp-tab-item.' + options.tabidentify).attr('tabindex', '-1');
                        $respTabs.find('.resp-accordion.' + options.tabidentify).attr('tabindex', '0');
                    } else {
                        $respTabs.find('.resp-tab-item.' + options.tabidentify).attr('tabindex', '-1');
                        $respTabs.find('.resp-tab-item.resp-tab-active.' + options.tabidentify).attr('tabindex', '0');
                        $respTabs.find('.resp-accordion.' + options.tabidentify).attr('tabindex', '-1');
                    }
                });
            });
        }
    });
})(jQuery);
