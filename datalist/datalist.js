(function ($) {
    $.fn.datalist = function (height, auto) {
        auto = auto || true;
        height = height || '200px';
        if (!isNaN(height)) height += 'px';

        this.each(function () {
            var $input = $(this);
            var $datalist = $('#' + $input.attr('list'));

            if ($datalist.length) {
                var options = $datalist.find('option').map(function () {
                    return $(this).val();
                }).get();

                $input.removeAttr('list');
                $datalist.remove();
                
                $input.autocomplete({
                    source: options,
                    minLength: 0,
                    delay: 0
                }).autocomplete('widget').css({
                    'max-height': height,
                    'overflow-y': 'auto',
                    'overflow-x': 'hidden', // prevent horizontal scrollbar
                    'z-index': '9999'
                });

                if (auto) $input.click(function () {
                    $input.autocomplete('search', '');

                    $input.autocomplete('widget').find('li').each(function () {
                        if ($(this).text() === $input.val()) {
                            $(this).css('font-weight', 'bold');
                            return false;
                        }
                    });
                });

                // Close menu when scrolling a parent element 
                $input.parents().add(document).scroll(function () {
                    $input.autocomplete('close');
                });
            }
        });
    };
})(jQuery);
