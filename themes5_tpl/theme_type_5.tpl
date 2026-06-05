

<div id="xoops_theme_content_zone" class="row g-0">
    <{if $xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <!-- 若是有左、右區塊 -->
        <div id="xoops_theme_left_zone" class="<{if $lb_width=="auto"}>col-lg<{else}>col-xl-<{$lb_width|default:''}><{/if}> order-2 order-xl-1">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}> order-1 order-xl-2" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" class="<{if $rb_width=="auto"}>col-lg<{else}>col-xl-<{$rb_width|default:''}><{/if}> order-3 order-xl-3">
            <div id="xoops_theme_right"  style="<{$rightBlocks|default:''}>">
                <a accesskey="B"  href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{elseif $xoBlocks.canvas_left|default:null and !$xoBlocks.canvas_right|default:null}>
        <!-- 若是只有左區塊 -->
        <{if $rb_width=="auto" and $lb_width=="auto"}>
            <{assign var="center_width" value=9}>
        <{elseif $rb_width!="auto" and $cb_width!="auto"}>
            <{assign var="center_width" value=$cb_width+$rb_width}>
        <{elseif $lb_width!="auto"}>
            <{assign var="center_width" value=12-$lb_width}>
        <{else}>
            <{assign var="center_width" value=$cb_width|default:''}>
        <{/if}>

        <div id="xoops_theme_left_zone" class="<{if $lb_width=="auto"}>col-lg<{else}>col-xl-<{$lb_width|default:''}><{/if}> order-2 order-xl-1">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_center_zone" class="col-xl-<{$center_width|default:''}> order-1 order-xl-2" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{elseif !$xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <!-- 若是只有右區塊 -->
        <{if $rb_width=="auto" and $lb_width=="auto"}>
            <{assign var="center_width" value=9}>
        <{elseif $lb_width!="auto" and $cb_width!="auto"}>
            <{assign var="center_width" value=$cb_width+$lb_width}>
        <{elseif $rb_width!="auto"}>
            <{assign var="center_width" value=12-$rb_width}>
        <{else}>
            <{assign var="center_width" value=$cb_width|default:''}>
        <{/if}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$center_width|default:''}> order-1 order-xl-1" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" class="<{if $rb_width=="auto"}>col-lg<{else}>col-xl-<{$rb_width|default:''}><{/if}> order-2 order-xl-2">
            <div id="xoops_theme_right"  style="<{$rightBlocks|default:''}>">
                <a accesskey="B"  href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{else}>
        <div class="col-xl-12" style="<{$centerBlocks|default:''}>">
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
         * 1. 寬屏 (Desktop / xl 以上)：左 (Left) -> 中 (Center) -> 右 (Right)
         * 2. 窄屏 (Mobile / 1200px 以下)：中 (Center) -> 左 (Left) -> 右 (Right)
         */
        
        // 記錄目前的螢幕類別，避免重複操作 DOM
        let isLastDesktop = null;

        function adjustTabOrder(e) {
            const container = document.getElementById('xoops_theme_content_zone');
            if (!container) return;

            const left = document.getElementById('xoops_theme_left_zone');
            const center = document.getElementById('xoops_theme_center_zone');
            const right = document.getElementById('xoops_theme_right_zone');

            // 判斷是否為 xl 以上的寬屏 (1200px 為 Bootstrap 5 的 xl 斷點)
            const isDesktop = e ? e.matches : window.matchMedia('(min-width: 1200px)').matches;

            // 如果寬度分類沒有改變，就不要觸發 DOM 操作，避免手機版 Chrome 因虛擬鍵盤彈出觸發 resize 導致輸入框失去焦點
            if (isLastDesktop === isDesktop) return;
            isLastDesktop = isDesktop;

            if (isDesktop) {
                // 桌機版：左 -> 中 -> 右
                if (left && center) {
                    container.insertBefore(left, center);
                }
                if (center && right) {
                    container.insertBefore(center, right);
                } else if (left && right) {
                    container.insertBefore(left, right);
                }
            } else {
                // 行動版：中 -> 左 -> 右 (優先顯示主內容)
                if (center && left) {
                    container.insertBefore(center, left);
                }
                if (left && right) {
                    container.insertBefore(left, right);
                } else if (center && right) {
                    container.insertBefore(center, right);
                }
            }
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
