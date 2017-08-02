'use strict';

// Initialize app
var myApp = new Framework7({
    onAjaxStart: function(xhr) { myApp.showIndicator(); },
    onAjaxComplete: function(xhr) { myApp.hideIndicator(); }
});

var $$ = Dom7;

// Add view
var mainView = myApp.addView('.view-main', {
    dynamicNavbar: true,
    domCache: true
});

myApp.onPageInit('index', function(page) {

    //only albums
    $("#album0").justifiedGallery({
        margins: 3,
        captionSettings: {
            animationDuration: 500,
            visibleOpacity: 0.7,
            nonVisibleOpacity: 0.7
        }
    });

    $$('.password-modal0').on('click', function() {
        var csn = $$(this).data('csn');
        var pass = $$(this).hasClass('check_pass');
        if (!pass) {
            myApp.modalPassword('', '請輸入密碼', function(password) {
                $.post('pda.php', { op: 'check', csn: csn, passwd: password }, function(data) {
                    if (data.type == 'error') {
                        myApp.alert(data.text, '發生錯誤');
                    } else {
                        $$('.album' + csn).attr('href', 'pda.php?csn=' + csn).addClass('check_pass');
                        mainView.router.loadPage('pda.php?csn=' + csn);
                    }
                }, 'json');

            });
        }
    });

}).trigger();

myApp.onPageInit('cate', function(page) {

    var csn = page.query.csn;

    $$('.password-modal' + csn).on('click', function() {
        var ccsn = $$(this).data('csn');
        var pass = $$(this).hasClass('check_pass');
        if (!pass) {
            myApp.modalPassword('', '請輸入密碼', function(password) {
                $.post('pda.php', { op: 'check', csn: ccsn, passwd: password }, function(data) {
                    if (data.type == 'error') {
                        myApp.alert(data.text, '發生錯誤');
                    } else {
                        $$('.album' + ccsn).attr('href', 'pda.php?csn=' + ccsn).addClass('check_pass');
                        mainView.router.loadPage('pda.php?csn=' + ccsn);
                    }
                }, 'json');

            });
        }
    });

    $("#album" + csn).justifiedGallery({
        margins: 3,
        captionSettings: {
            animationDuration: 500,
            visibleOpacity: 0.7,
            nonVisibleOpacity: 0.7
        }
    });

    $("#photo" + csn).justifiedGallery({ margins: 3 });

    $$('.gallery360').on('click', function(event) {
        event.preventDefault();
        var url = $(this).data('src');
        $.fancybox.open({
            src: url,
            type: 'iframe'
        });
    });

    var loading = false;
    var lastIndex = $$('#photo' + csn + ' img').length;
    //var maxItems = 60;
    var itemsPerLoad = 10;
    var pageIndex = 1;

    if (lastIndex < itemsPerLoad) {
        myApp.detachInfiniteScroll($$('.cate' + csn + ' .infinite-scroll'));
        $$('.cate' + csn + ' .infinite-scroll-preloader').hide();
    }

    $$('.cate' + csn + ' .infinite-scroll').on('infinite', function() {

        if (loading) return;
        loading = true;

        setTimeout(function() {
            loading = false;

            $$.ajax({
                url: 'pda.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    op: 'load_more',
                    n: itemsPerLoad,
                    p: pageIndex,
                    csn: csn
                },
                success: function(data) {
                    if (data.length > 0) {
                        $$('#load-area' + csn).append("<div class='load" + pageIndex + "' style='margin-top:-3px;'>" + data + "</div>");
                        $('.load' + pageIndex).justifiedGallery({ margins: 3 });
                        pageIndex++;
                    } else {
                        myApp.detachInfiniteScroll($$('.cate' + csn + ' .infinite-scroll'));
                        $$('.cate' + csn + ' .infinite-scroll-preloader').hide();
                        return;
                    }
                },
                error: function(data) {
                    //console.log("error");
                }
            });

        }, 1000);
    });

});
