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
                    '<div class="col-sm-4 span4 col-sidebar img-box-1-5"><img src="https://fakeimg.pl/300x250/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /></div>' +
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
                    '<div class="col-sm-4 span4 col-sidebar img-box-1-5"><img src="https://fakeimg.pl/300x250/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /></div>' +
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
                    '<div class="col-sm-6 span6 coln-1 img-box-1-5"><img src="https://fakeimg.pl/500x280/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入內容</p></div>' +
                    '<div class="col-sm-6 span6 coln-2 img-box-1-5"><img src="https://fakeimg.pl/500x280/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入內容</p></div>' +
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
                    '<div class="col-sm-4 span4 coln-1 img-box-2"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-4 span4 coln-2 img-box-2"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-4 span4 coln-3 img-box-2"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
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
                    '<div class="col-sm-3 span3 coln-1 img-box-3"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-3 span3 coln-2 img-box-3"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-3 span3 coln-3 img-box-3"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-3 span3 coln-4 img-box-3"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
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
                    '<div class="col-sm-2 span2 coln-1 img-box-4"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-2 span2 coln-2 img-box-4"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-2 span2 coln-3 img-box-4"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-2 span2 coln-4 img-box-4"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-2 span2 coln-5 img-box-4"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
                    '<div class="col-sm-2 span2 coln-6 img-box-4"><img src="https://fakeimg.pl/400x225/?retina=1&font=noto&text=%E6%94%BE%E7%BD%AE%E5%9C%96%E7%89%87" class="img-responsive img-fluid" /><p>輸入文字</p></div>' +
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

        // editor.widgets.add( 'widgetbootstrapPdfP', {
        //     button: showButtons ? '嵌入直式PDF' : undefined,
        //     template:
        //     '<div class="pdf-col">' +
        //         '<div class="embed-responsive embed-responsive-210by297 ratio ratio-210by297 coln-pdf">' +
        //             '<link href="https://campus-xoops.tn.edu.tw/modules/tad_blocks/type/pdf/embed-responsive.css" rel="stylesheet">' +
        //             '<iframe title="嵌入直式PDF" class="embed-responsive-item" src="https://campus-xoops.tn.edu.tw/uploads/tadtools/pdf-p.pdf" allowfullscreen scrolling="no"></iframe>' +
        //         '</div>' +
        //     '</div>',
        //     editables: {
        //         col1: {
        //             selector: '.coln-pdf',
        //             allowedContent: allowedWidget
        //         }
        //     },
        //     allowedContent: allowedFull,

        //     upcast: function( element ) {
        //         return element.name == 'div' && element.hasClass( 'pdf-col' );
        //     }
        // } );

        // editor.widgets.add( 'widgetbootstrapPdfL', {
        //     button: showButtons ? '嵌入橫式PDF' : undefined,
        //     template:
        //     '<div class="pdf-col">' +
        //         '<div class="embed-responsive embed-responsive-297by210 ratio ratio-297by210 coln-pdf">' +
        //             '<link href="https://campus-xoops.tn.edu.tw/modules/tad_blocks/type/pdf/embed-responsive.css" rel="stylesheet">' +
        //             '<iframe title="嵌入橫式PDF" class="embed-responsive-item" src="https://campus-xoops.tn.edu.tw/uploads/tadtools/pdf-l.pdf" allowfullscreen scrolling="no"></iframe>' +
        //         '</div>' +
        //     '</div>',
        //     editables: {
        //         col1: {
        //             selector: '.coln-pdf',
        //             allowedContent: allowedWidget
        //         }
        //     },
        //     allowedContent: allowedFull,

        //     upcast: function( element ) {
        //         return element.name == 'div' && element.hasClass( 'pdf-col' );
        //     }
        // } );

        // editor.addCommand( 'openwidgetbootstrapAlert', new CKEDITOR.dialogCommand( 'widgetbootstrapAlert' ) );

        // Add foundation alert button
        // Textare decodes html entities
        //var textarea = new CKEDITOR.dom.element( 'textarea' );

        // editor.widgets.add( 'widgetbootstrapAlert', {

        //     button: showButtons ? 'Add alert box' : undefined,
        //     dialog: 'widgetbootstrapAlert',

        //     template: '<div class="alert alert-box"><div class="alert-text">Some Text</span></div>',

        //     editables: {
        //         alertBox: {
        //             selector: '.alert-text',
        //             allowedContent: allowedWidget
        //         },
        //     },

        //     allowedContent: allowedFull,

        //     data: function() {
        //         var newData = this.data,
        //             oldData = this.oldData;

        //         /*if( newData.alertText ) {
        //             this.element.getChild( 0 ).setHtml( CKEDITOR.tools.htmlEncode( newData.alertText ) );
        //         }*/

        //         if ( oldData && newData.type != oldData.type )
        //             this.element.removeClass(oldData.type);

        //         if ( newData.type )
        //             this.element.addClass(newData.type);

        //         // Save oldData.
        //         this.oldData = CKEDITOR.tools.copy( newData );
        //     },

        //     upcast: function( el, data ) {
        //         if (el.name != 'div' || !el.hasClass( 'alert-box' ))
        //             return;

        //         var childrenArray = el.children,
        //             alertText;

        //         if ( childrenArray.length !== 1 || !( alertText = childrenArray[ 0 ] ).hasClass('alert-text'))
        //             return;

        //         // Acceptable alert types
        //         var alertTypes = CKEDITOR.config.widgetbootstrapAlert_alertTypes;
        //         // Check alert types
        //         for(var i = 0; i < el.attributes.length; i++) {
        //             if(el.attributes[i] != 'alert-box') {
        //                 for ( alertName in alertTypes ) {
        //                     if(el.attributes[i] == alertName) {
        //                         data.type = alertName;
        //                     }
        //                 }
        //             }
        //         }

        //         // Use textarea to decode HTML entities (#11926).
        //         //textarea.setHtml( alertText.getHtml() );
        //         //data.alertText = textarea.getValue();

        //         return el;
        //     },

        //     downcast: function( el ) {
        //         return el;
        //     }

        // } );
        // Alert dialog
        // CKEDITOR.dialog.add( 'widgetbootstrapAlert', this.path + 'dialogs/widgetbootstrapAlert.js' );

        /*CKEDITOR.dialog.add( 'widgetbootstrapAccordion', this.path + 'dialogs/widgetbootstrapAccordion.js' );
        editor.widgets.add( 'widgetbootstrapAccordion', {

            button: showButtons ? 'Add accordion box' : undefined,

            template:
                '<dl class="accordion" data-accordion><div class="col-1"></div></dl>',

            allowedContent: allowedFull,

            dialog: 'widgetbootstrapAccordion',

            upcast: function( element ) {
                return element.name == 'div' && element.hasClass( 'accordion' );
            },

            /*init: function() {
                var width = this.element.getStyle( 'width' );
                if ( width )
                    this.setData( 'width', width );
                if ( this.element.hasClass( 'align-left' ) )
                    this.setData( 'align', 'left' );
                if ( this.element.hasClass( 'align-right' ) )
                    this.setData( 'align', 'right' );
                if ( this.element.hasClass( 'align-center' ) )
                    this.setData( 'align', 'center' );
            },

            data: function() {

                var name = this.data.name != undefined ? this.data.name : 'accordion';
                var count = this.data.count != undefined ? this.data.count : 0;
                //@todo: var prevCount = this.data.prevCount != undefined ? this.data.prevCount :

                // Add rows
                if (this.data.prevCount == undefined || this.data.prevCount < count) {
                    for (var i=this.data.prevCount != undefined ? this.data.prevCount : 1; i<=count; i++) {
                        var active = this.data.activePanel == i ? ' active' : '';
                        var template =
                            '<dd class="accordion-navigation">' +
                                '<a href="#'+ name+i +'"><div class="accordion-header-'+i+'">Heading '+i+'</div></a>' +
                                '<div id="panel'+ name+i +'" class="content content-'+i+active+'">' +
                                  '' +
                                '</div>'
                            '</dd>'
                        var newPanel = CKEDITOR.dom.element.createFromHtml( template );
                        this.element.append(newPanel);
                    }

                    // For some reason, the initEditable call needs to come in a separate for loop
                    // the html code added wasn't in the DOM yet
                    for (var i=this.data.prevCount != undefined ? this.data.prevCount : 1; i<=count; i++) {
                        this.initEditable( 'heading'+i, {
                            selector: '.accordion-header-'+i
                        } );
                        this.initEditable( 'content'+i, {
                            selector: '.content-'+i
                        } );
                    }
                }

                // Remove rows
                if (this.data.prevCount != undefined && this.data.prevCount > count) {
                    // @todo
                }

                this.data.prevCount = i;
            }
        } );*/

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