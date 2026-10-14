(function ($) {
    'use strict';

    function removeBootstrapTableRowTabStops(table) {
        $(table)
            .children('tbody')
            .children('tr')
            .removeAttr('tabindex');
    }

    $(function () {
        // 修正頁面載入時已經存在的 Bootstrap Table。
        $('table[data-toggle="table"]').each(function () {
            removeBootstrapTableRowTabStops(this);
        });
    });

    // 修正搜尋、排序、分頁、重新整理後產生的資料列。
    $(document)
        .off('post-body.bs.table.removeRowTabStops')
        .on(
            'post-body.bs.table.removeRowTabStops',
            'table[data-toggle="table"]',
            function () {
                removeBootstrapTableRowTabStops(this);
            }
        );
})(jQuery);
