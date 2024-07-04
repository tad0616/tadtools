// Init default alert classes

// CKEDITOR.config.widgetbootstrapAlert_alertTypes = {
//     'alert-danger': 'Danger',
//     'alert-info': 'Info',
//     'alert-warning': 'Warning',
//     'alert-success': 'Success'
// };

CKEDITOR.plugins.add( 'widgetbootstrap', {
    requires: 'widget',

    // icons: 'widgetbootstrapLeftCol,widgetbootstrapRightCol,widgetbootstrapTwoCol,widgetbootstrapThreeCol,widgetbootstrapFourCol,widgetbootstrapSixCol,widgetbootstrapPdfP,widgetbootstrapPdfL',
    icons: 'widgetbootstrapLeftCol,widgetbootstrapRightCol,widgetbootstrapTwoCol,widgetbootstrapThreeCol,widgetbootstrapFourCol,widgetbootstrapSixCol',

    init: function( editor ) {

        // Configurable settings
        //var allowedWidget = editor.config.widgetbootstrap_allowedWidget != undefined ? editor.config.widgetbootstrap_allowedFull :
        //    'p h2 h3 h4 h5 h6 span br ul ol li strong em img[!src,alt,width,height]';
        var allowedFull = editor.config.widgetbootstrap_allowedFull != undefined ? editor.config.widgetbootstrap_allowedFull :
            'p a div span h2 h3 h4 h5 h6 section article iframe object embed strong b i em cite pre blockquote small sub sup code ul ol li dl dt dd table thead tbody th tr td img caption mediawrapper br[href,src,target,width,height,colspan,span,alt,name,title,class,id,data-options]{text-align,float,margin}(*);'
        //var allowedText = editor.config.widgetbootstrap_allowedText != undefined ? editor.config.widgetbootstrap_allowedFull :
        //    'p span br ul ol li strong em';

        allowedWidget = allowedFull;
        //allowedText = allowedWidget;

        var showButtons = editor.config.widgetbootstrapShowButtons != undefined ? editor.config.widgetbootstrapShowButtons : true;

        // Define the widgets
        editor.widgets.add( 'widgetbootstrapLeftCol', {

            button: showButtons ? '新增 1:2 雙欄' : undefined,

            template:
                '<div class="row two-col-left">' +
                    '<div class="col-sm-4 span4 col-sidebar"><img src="https://fakeimg.pl/300x250/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /></div>' +
                    '<div class="col-sm-8 span8 col-main"><p>輸入內容</p></div>' +
                '</div>',

            editables: {
                col1: {
                    selector: '.col-sidebar',
                    allowedContent: allowedWidget
                },
                col2: {
                    selector: '.col-main',
                    allowedContent: allowedWidget
                }
            },

            allowedContent: allowedFull,

            upcast: function( element ) {
                return element.name == 'div' && element.hasClass( 'two-col-left' );
            }

        } );

        editor.widgets.add( 'widgetbootstrapRightCol', {

            button: showButtons ? '新增 2:1 雙欄' : undefined,

            template:
                '<div class="row two-col-right">' +
                    '<div class="col-sm-8 span8 col-main"><p>輸入內容</p></div>' +
                    '<div class="col-sm-4 span4 col-sidebar"><img src="https://fakeimg.pl/300x250/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /></div>' +
                '</div>',

            editables: {
                col1: {
                    selector: '.col-sidebar',
                    allowedContent: allowedWidget
                },
                col2: {
                    selector: '.col-main',
                    allowedContent: allowedWidget
                }
            },

            allowedContent: allowedFull,

            upcast: function( element ) {
                return element.name == 'div' && element.hasClass( 'two-col-right' );
            }

        } );

        editor.widgets.add( 'widgetbootstrapTwoCol', {
            button: showButtons ? '新增 2 欄' : undefined,
            template:
                '<div class="row two-col">' +
                    '<div class="col-sm-6 span6 coln-1"><img src="https://fakeimg.pl/500x280/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入內容</p></div>' +
                    '<div class="col-sm-6 span6 coln-2"><img src="https://fakeimg.pl/500x280/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入內容</p></div>' +
                '</div>',
            editables: {
                col1: {
                    selector: '.coln-1',
                    allowedContent: allowedWidget
                },
                col2: {
                    selector: '.coln-2',
                    allowedContent: allowedWidget
                }
            },
            allowedContent: allowedFull,
            upcast: function( element ) {
                return element.name == 'div' && element.hasClass( 'two-col' );
            }
        } );

        editor.widgets.add( 'widgetbootstrapThreeCol', {

            button: showButtons ? '新增 3 欄' : undefined,

            template:
                '<div class="row three-col">' +
                    '<div class="col-sm-4 span4 coln-1"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-4 span4 coln-2"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-4 span4 coln-3"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                '</div>',

            editables: {
                col1: {
                    selector: '.coln-1',
                    allowedContent: allowedWidget
                },
                col2: {
                    selector: '.coln-2',
                    allowedContent: allowedWidget
                },
                col3: {
                    selector: '.coln-3',
                    allowedContent: allowedWidget
                }
            },

            allowedContent: allowedFull,

            upcast: function( element ) {
                return element.name == 'div' && element.hasClass( 'three-col' );
            }

        } );

        editor.widgets.add( 'widgetbootstrapFourCol', {

            button: showButtons ? '新增 4 欄' : undefined,

            template:
                '<div class="row four-col">' +
                    '<div class="col-sm-3 span3 coln-1"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-3 span3 coln-2"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-3 span3 coln-3"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-3 span3 coln-4"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                '</div>',

            editables: {
                col1: {
                    selector: '.coln-1',
                    allowedContent: allowedWidget
                },
                col2: {
                    selector: '.coln-2',
                    allowedContent: allowedWidget
                },
                col3: {
                    selector: '.coln-3',
                    allowedContent: allowedWidget
                },
                col4: {
                    selector: '.coln-4',
                    allowedContent: allowedWidget
                }
            },

            allowedContent: allowedFull,

            upcast: function( element ) {
                return element.name == 'div' && element.hasClass( 'four-col' );
            }

        } );

        editor.widgets.add( 'widgetbootstrapSixCol', {

            button: showButtons ? '新增 6 欄' : undefined,

            template:
                '<div class="row six-col">' +
                    '<div class="col-sm-2 span2 coln-1"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-2 span2 coln-2"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-2 span2 coln-3"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-2 span2 coln-4"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-2 span2 coln-5"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-2 span2 coln-6"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                '</div>',

            editables: {
                col1: {
                    selector: '.coln-1',
                    allowedContent: allowedWidget
                },
                col2: {
                    selector: '.coln-2',
                    allowedContent: allowedWidget
                },
                col3: {
                    selector: '.coln-3',
                    allowedContent: allowedWidget
                },
                col4: {
                    selector: '.coln-4',
                    allowedContent: allowedWidget
                },
                col5: {
                    selector: '.coln-5',
                    allowedContent: allowedWidget
                },
                col6: {
                    selector: '.coln-6',
                    allowedContent: allowedWidget
                }
            },

            allowedContent: allowedFull,

            upcast: function( element ) {
                return element.name == 'div' && element.hasClass( 'six-col' );
            }

        } );

        // Append the widget's styles when in the CKEditor edit page,
        // added for better user experience.
        // Assign or append the widget's styles depending on the existing setup.
        if (typeof editor.config.contentsCss == 'object') {
            editor.config.contentsCss.push(CKEDITOR.getUrl(this.path + 'contents.css'));
        }

        else {
            editor.config.contentsCss = [editor.config.contentsCss, CKEDITOR.getUrl(this.path + 'contents.css')];
        }

    }

} );