<div id="xoops_theme_content_zone" class="row g-0">
    <!-- 若是有左區塊 -->
    <{if $xoBlocks.canvas_left|default:null}>
        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width|default:''}> order-2 order-xl-1">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
                <{if $xoBlocks.canvas_left|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
                <{/if}>
            </div>
        </div>

        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}> order-1 order-xl-2 flex-grow-1" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-xl-12" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>

<!-- 根據寬度動態調整區塊的 DOM 順序，以修正鍵盤焦點 (Tab) 的導覽順序 -->
<script type="text/javascript">
    (function() {
        /**
         * 調整 Tab 焦點順序的邏輯：
         * 依據元件目前的 order (行動版) 或 order-xl (桌機版) 類別進行 DOM 重新排序
         */

        // 記錄目前的螢幕類別，避免重複操作 DOM
        let isLastDesktop = null;

        function adjustTabOrder(e) {
            const container = document.getElementById('xoops_theme_content_zone');
            if (!container) return;

            const zones = Array.from(container.children).filter(el => el.id && el.id.endsWith('_zone'));
            if (zones.length <= 1) return;

            const isDesktop = e ? e.matches : window.matchMedia('(min-width: 1200px)').matches;

            // 如果寬度分類沒有改變，就不要觸發 DOM 操作，避免手機版 Chrome 因虛擬鍵盤彈出觸發 resize 導致輸入框失去焦點
            if (isLastDesktop === isDesktop) return;
            isLastDesktop = isDesktop;

            zones.sort((a, b) => {
                const getOrder = (el) => {
                    const classes = Array.from(el.classList);
                    if (isDesktop) {
                        const xlOrder = classes.find(c => c.startsWith('order-xl-'));
                        if (xlOrder) return parseInt(xlOrder.replace('order-xl-', ''));
                    }
                    const order = classes.find(c => c.startsWith('order-') && !c.startsWith('order-xl-'));
                    if (order) return parseInt(order.replace('order-', ''));
                    return 0; // 預設
                };
                return getOrder(a) - getOrder(b);
            });

            // 按排序後的結果重新插入 DOM
            zones.forEach(zone => container.appendChild(zone));
        }

        const mediaQuery = window.matchMedia('(min-width: 1200px)');

        // 監聽媒體查詢的變更事件，只有在跨越 1200px 斷點時才觸發，這在手機上彈出虛擬鍵盤時不會被觸發
        if (mediaQuery.addEventListener) {
            mediaQuery.addEventListener('change', adjustTabOrder);
        } else if (mediaQuery.addListener) {
            mediaQuery.addListener(adjustTabOrder);
        }

        document.addEventListener('DOMContentLoaded', function() {
            adjustTabOrder(mediaQuery);
        });

        // 立即執行一次
        adjustTabOrder(mediaQuery);
    })();
</script>


<{if $xoBlocks.canvas_left|default:null}>
    <div id="xoops_theme_right_zone" class="row g-0">
        <a accesskey="B" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到下方區域">:::</a>
        <div class="col-xl-<{$rb_width|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBottom.tpl"}>
        </div>
        <div style="clear: both;"></div>
    </div>
<{/if}>
