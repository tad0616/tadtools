'use strict';

// Initialize app
var myApp = new Framework7({
    pushState: true,
    //pushStateSeparator: ''
    onAjaxStart: function(xhr) { myApp.showIndicator(); },
    onAjaxComplete: function(xhr) { myApp.hideIndicator(); }
});

// If we need to use custom DOM library, let's save it to $$ variable:
var $$ = Dom7;

// Add view
var mainView = myApp.addView('.view-main', {
    dynamicNavbar: true,
    //domCache: true
});

myApp.onPageInit('index', function(page) {

    var loading = false;
    var lastIndex = $$('.index .list-block.index-list li').length;
    //var maxItems = 60;
    var itemsPerLoad = 10;
    var pageIndex = 1;

    if (lastIndex < itemsPerLoad) {
        myApp.detachInfiniteScroll($$('.index .infinite-scroll'));
        $$('.index .infinite-scroll-preloader').hide();
    }

    // Attach 'infinite' event handler
    $$('.index .infinite-scroll').on('infinite', function() {

        // Exit, if loading in progress
        if (loading) return;

        // Set loading flag
        loading = true;

        // Emulate 1s loading
        setTimeout(function() {
            // Reset loading flag
            loading = false;

            $$.ajax({
                url: 'pda.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    op: 'load_more',
                    n: itemsPerLoad,
                    p: pageIndex
                },
                success: function(data) {
                    if (data.length > 0) {
                        $$('.index .list-block.index-list ul').append(data);
                        myApp.initImagesLazyLoad('.index .list-block.index-list img.lazy');
                        pageIndex++;
                        lastIndex = $$('.index .list-block.index-list li').length;
                    } else {
                        myApp.detachInfiniteScroll($$('.index .infinite-scroll'));
                        $$('.index .infinite-scroll-preloader').hide();
                        return;
                    }
                },
                error: function(data) {
                    //console.log("error");
                }
            });

        }, 1000);
    });

    // Pull to refresh content
    var ptrContent = $$('.index .pull-to-refresh-content');

    // Add 'refresh' listener on it
    ptrContent.on('refresh', function(e) {

        // Emulate 2s loading
        setTimeout(function() {

            $$.ajax({
                url: 'pda.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    op: 'load_more',
                    n: itemsPerLoad,
                    p: 0
                },
                success: function(data) {
                    $$('.index .list-block.index-list ul').html(data);
                    myApp.initImagesLazyLoad('.index .list-block.index-list img.lazy');
                    pageIndex = 1;
                    if (lastIndex >= itemsPerLoad) {
                        myApp.attachInfiniteScroll($$('.index .infinite-scroll'));
                        $$('.index .infinite-scroll-preloader').show();
                    }
                },
                error: function(data) {
                    //console.log("error");
                }
            });

            // When loading done, we need to reset it
            myApp.pullToRefreshDone();
        }, 2000);

    });
}).trigger();

myApp.onPageInit('category', function(page) {
    myApp.closePanel();

    var loading = false;
    var ncsn = page.query.ncsn;
    var lastIndex = $$('.category' + ncsn + ' .list-block.cate-list li').length;
    //var maxItems = 60;
    var itemsPerLoad = 10;
    var pageIndex = 1;

    if (lastIndex < itemsPerLoad) {
        myApp.detachInfiniteScroll($$('.category' + ncsn + ' .infinite-scroll'));
        $$('.category' + ncsn + ' .infinite-scroll-preloader').hide();
    }

    // Attach 'infinite' event handler
    $$('.category' + ncsn + ' .infinite-scroll').on('infinite', function() {

        // Exit, if loading in progress
        if (loading) return;

        // Set loading flag
        loading = true;

        // Emulate 1s loading
        setTimeout(function() {
            // Reset loading flag
            loading = false;

            $$.ajax({
                url: 'pda.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    op: 'load_more',
                    n: itemsPerLoad,
                    p: pageIndex,
                    ncsn: ncsn
                },
                success: function(data) {
                    if (data.length > 0) {
                        $$('.category' + ncsn + ' .list-block.cate-list ul').append(data);
                        myApp.initImagesLazyLoad('.category' + ncsn + ' .list-block.cate-list img.lazy');
                        pageIndex++;
                        lastIndex = $$('.category' + ncsn + ' .list-block.cate-list li').length;
                    } else {
                        myApp.detachInfiniteScroll($$('.category' + ncsn + ' .infinite-scroll'));
                        $$('.category' + ncsn + ' .infinite-scroll-preloader').hide();
                        return;
                    }
                },
                error: function(data) {
                    //console.log("error");
                }
            });

        }, 1000);
    });

    // Pull to refresh content
    var ptrContent = $$('.category' + ncsn + ' .pull-to-refresh-content');

    // Add 'refresh' listener on it
    ptrContent.on('refresh', function(e) {

        // Emulate 2s loading
        setTimeout(function() {

            $$.ajax({
                url: 'pda.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    op: 'load_more',
                    n: itemsPerLoad,
                    p: 0,
                    ncsn: ncsn
                },
                success: function(data) {
                    $$('.category' + ncsn + ' .list-block.cate-list ul').html(data);
                    $$('.category' + ncsn + ' .list-block.cate-list img.lazy').trigger('lazy');
                    pageIndex = 1;
                    if (lastIndex >= itemsPerLoad) {
                        myApp.attachInfiniteScroll($$('.category' + ncsn + ' .infinite-scroll'));
                        $$('.category' + ncsn + ' .infinite-scroll-preloader').show();
                    }
                },
                error: function(data) {
                    //console.log("error");
                }
            });

            // When loading done, we need to reset it
            myApp.pullToRefreshDone();
        }, 2000);

    });
});

myApp.onPageInit('newspaper', function(page) {
    myApp.closePanel();
});

myApp.onPageInit('month', function(page) {
    myApp.closePanel();
});

myApp.onPageInit('member', function(page) {
    myApp.closePanel();
    var title = $$('.logout .item-title').text();
    $$('.logout').on('click', function() {
        myApp.confirm('Are you sure you want to log out?', title, function() {
            location.href = "pda.php?op=logout";
        });
    });
});

myApp.onPageInit('show', function(page) {
    //start single page
    var param = location.search;
    if (param.length > 0) {
        $('.left .back').removeClass('back').addClass('external');
    }
    //內文按鈕樣式替換
    $$('#news-read-check .btn').removeClass('btn btn-primary btn-large').addClass('button button-big button-fill color-orange external');
    $$('#news-toolbar .btn-group').removeClass('btn-group').addClass('buttons-row');
    //內文外連處理
    $$('#news-content').find('a').addClass('external').attr('target', '_blank');
    //功能按鈕樣式替換
    $$('#news-toolbar .btn').removeClass('btn btn-default btn-xs').addClass('button external');
    //prefix_tag連結
    $$('#news-info .label').addClass('external');
    //附檔顯示問題
    $$('#news-attach .thumbnail').css('display', 'block').addClass('external');
    //附檔fancybox plugin
    $('#news-attach .fancybox_nsn').fancybox({
        fitToView: true,
        width: '640',
        height: '480',
        autoSize: false,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none'
    });
    //facebook comment plugin
    if ($('#fb-root').length > 0) {
        $('#fb-root').detach();
        $.ajaxSetup({ cache: true });
        $.getScript('//connect.facebook.net/zh_TW/sdk.js', function() {
            FB.init({
                xfbml: true,
                appId: '199288920104939',
                version: 'v2.3'
            });
        });
    }
    //social share button
    var source_id = $$('#news-title').data('id');
    var source_url = $$('#news-title').data('url');
    var source_title = $$('#news-title h1').text();
    $$('.share-picker').on('click', function() {
        var popupHTML = "<div class='popup popup-social-share'>" +
            "<div class='content-block'><div class='social-share'>" +
            "<a href='https://twitter.com/share?url=" + source_url + "' class='sh-twitter external'><i class='icon ion-social-twitter'></i></a>" +
            "<a href='https://www.facebook.com/sharer.php?u=" + source_url + "' class='sh-facebook external'><i class='icon ion-social-facebook'></i></a>" +
            "<a href='https://plus.google.com/share?url=" + source_url + "' class='sh-google-plus external'><i class='icon ion-social-googleplus'></i></a>" +
            "<a href='mailto:?subject=" + source_title + "&body=" + source_url + "' class='sh-email external'><i class='icon ion-android-mail'></i></a>" +
            "</div></div>" +
            "<div class='list-block'>" +
            "<ul><li><a href='#' class='item-link list-button close-popup'>Cancel</a></li></ul>" +
            "</div></div>";
        myApp.popup(popupHTML);
    });
    //刪除功能
    $$('#news-toolbar .button').eq(-3).attr('href', '#').removeClass('external').on('click', function() {
        myApp.confirm('Are you sure you want to delete?', source_title, function() {
            location.href = "pda.php?op=delete_tad_news&nsn=" + source_id;
        });
    });
}).trigger();


myApp.onPageInit('mynews', function(page) {

    var loading = false;
    var lastIndex = $$('.mynews .list-block.mynews-list li').length;
    //var maxItems = 60;
    var itemsPerLoad = 10;
    var pageIndex = 1;

    if (lastIndex < itemsPerLoad) {
        myApp.detachInfiniteScroll($$('.mynews .infinite-scroll'));
        $$('.mynews .infinite-scroll-preloader').hide();
    }

    // Attach 'infinite' event handler
    $$('.mynews .infinite-scroll').on('infinite', function() {

        // Exit, if loading in progress
        if (loading) return;

        // Set loading flag
        loading = true;

        // Emulate 1s loading
        setTimeout(function() {
            // Reset loading flag
            loading = false;

            $$.ajax({
                url: 'pda.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    op: 'mynews_load_more',
                    n: itemsPerLoad,
                    p: pageIndex
                },
                success: function(data) {
                    if (data.length > 0) {
                        $$('.mynews .list-block.mynews-list ul').append(data);
                        myApp.initImagesLazyLoad('.mynews .list-block.mynews-list img.lazy');
                        pageIndex++;
                        lastIndex = $$('.mynews .list-block.mynews-list li').length;
                    } else {
                        myApp.detachInfiniteScroll($$('.mynews .infinite-scroll'));
                        $$('.mynews .infinite-scroll-preloader').hide();
                        return;
                    }
                },
                error: function(data) {
                    //console.log("error");
                }
            });

        }, 1000);
    });

    // Pull to refresh content
    var ptrContent = $$('.mynews .pull-to-refresh-content');

    // Add 'refresh' listener on it
    ptrContent.on('refresh', function(e) {

        // Emulate 2s loading
        setTimeout(function() {

            $$.ajax({
                url: 'pda.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    op: 'mynews_load_more',
                    n: itemsPerLoad,
                    p: 0
                },
                success: function(data) {
                    $$('.mynews .list-block.mynews-list ul').html(data);
                    myApp.initImagesLazyLoad('.mynews .list-block.mynews-list img.lazy');
                    pageIndex = 1;
                    if (lastIndex >= itemsPerLoad) {
                        myApp.attachInfiniteScroll($$('.mynews .infinite-scroll'));
                        $$('.mynews .infinite-scroll-preloader').show();
                    }
                },
                error: function(data) {
                    //console.log("error");
                }
            });

            // When loading done, we need to reset it
            myApp.pullToRefreshDone();
        }, 2000);

    });
});
