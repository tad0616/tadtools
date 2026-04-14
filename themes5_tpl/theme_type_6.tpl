<div id="xoops_theme_content_zone" class="row g-0">
    <!-- 若是有左、右區塊 -->
    <{if $xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width|default:''}> order-2 order-xl-1">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域1">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-<{$rb_width|default:''}> order-3 order-xl-2">
            <div id="xoops_theme_right"  style="<{$rightBlocks|default:''}>">
                <a accesskey="B" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域2">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}> order-1 order-xl-3" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{elseif $xoBlocks.canvas_left|default:null and !$xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width|default:''}> order-1 order-xl-2">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域1">:::</a>
                <{if $xoBlocks.canvas_left|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
                <{/if}>

                <{if $xoBlocks.canvas_right|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
                <{/if}>
            </div>
        </div>

        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}> order-2 order-xl-1" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

    <{elseif !$xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}>" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-<{$lb_width|default:''}>">
            <div id="xoops_theme_right" style="<{$rightBlocks|default:''}>">
                <a accesskey="B" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域2">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
            </div>
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
        function adjustTabOrder() {
            const container = document.getElementById('xoops_theme_content_zone');
            if (!container) return;

            const zones = Array.from(container.children).filter(el => el.id && el.id.endsWith('_zone'));
            if (zones.length <= 1) return;

            const isDesktop = window.matchMedia('(min-width: 1200px)').matches;

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

        window.addEventListener('resize', adjustTabOrder);
        document.addEventListener('DOMContentLoaded', adjustTabOrder);
        adjustTabOrder();
    })();
</script>

