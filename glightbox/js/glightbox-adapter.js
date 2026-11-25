(function (window, document) {
    'use strict';

    if (window.TadGLightbox) {
        return;
    }

    var activeInstance = null;
    var activeTimer = null;
    var activeFocusTrapHandler = null;
    var activeResizeHandler = null;
    var lastActiveElement = null;
    var hiddenBodyNodes = [];

    function normalizeDimension(val, axis) {
        if (val === null || val === undefined || val === '') {
            return axis === 'w' ? '90vw' : '90vh';
        }
        var str = String(val).trim();
        if (/^\d+(\.\d+)?$/.test(str)) {
            return str + 'px';
        }
        if (/^\d+(\.\d+)?%$/.test(str)) {
            return str.replace('%', axis === 'w' ? 'vw' : 'vh');
        }
        return str;
    }

    function detectType(el, defaultType) {
        if (!el) {
            return defaultType || '';
        }
        var explicit = el.getAttribute('data-type') || el.getAttribute('data-fancybox-type') || '';
        if (!explicit) {
            if (el.classList.contains('fancybox.iframe')) {
                explicit = 'iframe';
            } else if (el.classList.contains('fancybox.ajax')) {
                explicit = 'ajax';
            } else if (el.classList.contains('fancybox.inline')) {
                explicit = 'inline';
            }
        }
        var type = (explicit || defaultType || '').toLowerCase();
        if (type === 'iframe') {
            return 'external';
        }
        return type;
    }

    function extractSpeakText(triggerEl, index, total) {
        var speakText = '';
        if (triggerEl) {
            var img = triggerEl.querySelector('img');
            speakText =
                triggerEl.getAttribute('data-alt') ||
                (img ? img.getAttribute('alt') : '') ||
                triggerEl.getAttribute('title') ||
                '';

            if (!speakText) {
                var ariaLabel = triggerEl.getAttribute('aria-label') || '';
                speakText = ariaLabel.replace(/^於彈跳視窗觀看：/, '');
            }
        }
        speakText = (speakText || '').trim();
        if (!speakText && total > 0) {
            speakText = '第 ' + (index + 1) + ' 張，共 ' + total + ' 張';
        }
        return speakText;
    }

    var lastSpokenKey = '';
    var lastSpokenAt = 0;

    function speakImageDescription(text, index) {
        if (!text || !('speechSynthesis' in window)) {
            return;
        }
        var now = Date.now();
        var key = String(index) + ':' + text;
        if (key === lastSpokenKey && now - lastSpokenAt < 350) {
            return;
        }
        lastSpokenKey = key;
        lastSpokenAt = now;
        try {
            window.speechSynthesis.cancel();
            var utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'zh-TW';
            window.speechSynthesis.speak(utterance);
        } catch (e) {
            // Ignore speech synthesis errors on restricted environments
        }
    }

    function applyAriaHiddenBackground() {
        restoreAriaHiddenBackground();
        var modal = document.getElementById('glightbox-body');
        if (!modal) {
            return;
        }
        var children = document.body.children;
        for (var i = 0; i < children.length; i++) {
            var node = children[i];
            if (node === modal || node.id === 'glightbox-body' || node.id === 'glightbox-aria-live') {
                continue;
            }
            hiddenBodyNodes.push({
                node: node,
                prev: node.getAttribute('aria-hidden')
            });
            node.setAttribute('aria-hidden', 'true');
        }
    }

    function ensureAriaLiveRegion() {
        var announcer = document.getElementById('glightbox-aria-live');
        if (!announcer) {
            announcer = document.createElement('div');
            announcer.id = 'glightbox-aria-live';
            announcer.setAttribute('role', 'status');
            announcer.setAttribute('aria-live', 'polite');
            announcer.setAttribute('aria-atomic', 'true');
            announcer.style.position = 'absolute';
            announcer.style.width = '1px';
            announcer.style.height = '1px';
            announcer.style.overflow = 'hidden';
            announcer.style.clip = 'rect(0, 0, 0, 0)';
            announcer.style.whiteSpace = 'nowrap';
            announcer.style.border = '0';
            announcer.style.margin = '-1px';
            announcer.style.padding = '0';
            document.body.appendChild(announcer);
        }
        return announcer;
    }

    function removeAriaLiveRegion() {
        var announcer = document.getElementById('glightbox-aria-live');
        if (announcer && announcer.parentNode) {
            announcer.parentNode.removeChild(announcer);
        }
    }

    var lastAnnouncedKey = '';
    var lastAnnouncedAt = 0;

    function announceToScreenReader(announcement, index) {
        if (!announcement) {
            return;
        }
        var modal = document.getElementById('glightbox-body');
        if (modal) {
            modal.setAttribute('aria-label', announcement);
        }
        var now = Date.now();
        var key = String(index) + ':' + announcement;
        if (key === lastAnnouncedKey && now - lastAnnouncedAt < 350) {
            return;
        }
        lastAnnouncedKey = key;
        lastAnnouncedAt = now;

        var announcer = ensureAriaLiveRegion();
        announcer.textContent = '';
        window.setTimeout(function () {
            var currentAnnouncer = document.getElementById('glightbox-aria-live');
            if (currentAnnouncer) {
                currentAnnouncer.textContent = announcement;
            }
        }, 50);
    }

    function focusInitialModalElement() {
        var modal = document.getElementById('glightbox-body');
        if (!modal) {
            return;
        }
        var closeBtn = modal.querySelector('.gclose');
        if (closeBtn && window.getComputedStyle(closeBtn).display !== 'none') {
            closeBtn.focus();
            return;
        }
        var firstFocusable = modal.querySelector(
            'a[href], button:not([disabled]), [tabindex]:not([tabindex^="-"])'
        );
        if (firstFocusable) {
            firstFocusable.focus();
        } else {
            modal.setAttribute('tabindex', '-1');
            modal.focus();
        }
    }

    function restoreAriaHiddenBackground() {
        for (var i = 0; i < hiddenBodyNodes.length; i++) {
            var item = hiddenBodyNodes[i];
            if (item.prev === null) {
                item.node.removeAttribute('aria-hidden');
            } else {
                item.node.setAttribute('aria-hidden', item.prev);
            }
        }
        hiddenBodyNodes = [];
    }

    function localizeModalControls() {
        var modal = document.getElementById('glightbox-body');
        if (!modal) {
            return;
        }
        modal.setAttribute('role', 'dialog');
        modal.setAttribute('aria-modal', 'true');

        var closeBtn = modal.querySelector('.gclose');
        if (closeBtn) {
            closeBtn.setAttribute('aria-label', '關閉');
            closeBtn.setAttribute('title', '關閉');
        }
        var nextBtn = modal.querySelector('.gnext');
        if (nextBtn) {
            nextBtn.setAttribute('aria-label', '下一頁');
            nextBtn.setAttribute('title', '下一頁');
        }
        var prevBtn = modal.querySelector('.gprev');
        if (prevBtn) {
            prevBtn.setAttribute('aria-label', '上一頁');
            prevBtn.setAttribute('title', '上一頁');
        }
    }

    function enableFocusTrap() {
        disableFocusTrap();
        var modal = document.getElementById('glightbox-body');
        if (!modal) {
            return;
        }

        activeFocusTrapHandler = function (e) {
            if (e.key !== 'Tab') {
                return;
            }
            var focusableSelector = [
                'a[href]',
                'area[href]',
                'input:not([disabled]):not([type="hidden"])',
                'select:not([disabled])',
                'textarea:not([disabled])',
                'button:not([disabled])',
                'iframe',
                'object',
                'embed',
                '[contenteditable]',
                '[tabindex]:not([tabindex^="-"])'
            ].join(',');

            var all = modal.querySelectorAll(focusableSelector);
            var visible = [];
            for (var i = 0; i < all.length; i++) {
                var el = all[i];
                var style = window.getComputedStyle(el);
                if (style.display !== 'none' && style.visibility !== 'hidden' && el.offsetParent !== null) {
                    visible.push(el);
                }
            }
            if (!visible.length) {
                return;
            }

            var idx = visible.indexOf(document.activeElement);
            e.preventDefault();
            if (e.shiftKey) {
                visible[idx <= 0 ? visible.length - 1 : idx - 1].focus();
            } else {
                visible[idx < 0 || idx >= visible.length - 1 ? 0 : idx + 1].focus();
            }
        };

        document.addEventListener('keydown', activeFocusTrapHandler, true);
    }

    function disableFocusTrap() {
        if (activeFocusTrapHandler) {
            document.removeEventListener('keydown', activeFocusTrapHandler, true);
            activeFocusTrapHandler = null;
        }
    }

    function stopAutoPlay() {
        if (activeTimer) {
            window.clearInterval(activeTimer);
            activeTimer = null;
        }
    }

    function startAutoPlay(instance, playSpeed) {
        stopAutoPlay();
        var interval = parseInt(playSpeed, 10);
        if (!interval || interval < 500) {
            interval = 3000;
        }
        activeTimer = window.setInterval(function () {
            if (activeInstance === instance && typeof instance.nextSlide === 'function') {
                instance.nextSlide();
            } else {
                stopAutoPlay();
            }
        }, interval);
    }

    function fitImageSlide(slideNode) {
        if (!slideNode || slideNode.classList.contains('zoomed')) {
            return;
        }
        var img = slideNode.querySelector('.gslide-image img');
        if (!img) {
            return;
        }
        var desc = slideNode.querySelector('.gslide-description');
        var media = slideNode.querySelector('.gslide-media');
        var vpH = window.innerHeight || document.documentElement.clientHeight || 0;
        var vpW = window.innerWidth || document.documentElement.clientWidth || 0;
        if (!vpH || !vpW) {
            return;
        }

        var isMobile = vpW <= 768;
        var verticalMargin = isMobile ? 32 : 64;
        var horizontalMargin = isMobile ? 32 : 144;

        var mediaPaddingY = 0;
        var mediaPaddingX = 0;
        if (media) {
            var ms = window.getComputedStyle(media);
            mediaPaddingY = (parseFloat(ms.paddingTop) || 0) + (parseFloat(ms.paddingBottom) || 0);
            mediaPaddingX = (parseFloat(ms.paddingLeft) || 0) + (parseFloat(ms.paddingRight) || 0);
        }

        var descHeight = 0;
        if (desc && window.getComputedStyle(desc).display !== 'none') {
            desc.style.maxWidth = Math.max(260, vpW - horizontalMargin) + 'px';
            var ds = window.getComputedStyle(desc);
            descHeight = desc.offsetHeight + (parseFloat(ds.marginTop) || 0) + (parseFloat(ds.marginBottom) || 0);
        }

        var availH = Math.max(120, Math.floor(vpH - verticalMargin - mediaPaddingY - descHeight));
        var availW = Math.max(160, Math.floor(vpW - horizontalMargin - mediaPaddingX));
        img.style.maxHeight = availH + 'px';
        img.style.maxWidth = availW + 'px';
    }

    function scheduleFitImageSlide(slideNode) {
        if (!slideNode) {
            return;
        }
        fitImageSlide(slideNode);
        var img = slideNode.querySelector('.gslide-image img');
        if (img && !img.complete && img.dataset.tadFitBound !== '1') {
            img.dataset.tadFitBound = '1';
            img.addEventListener('load', function () {
                fitImageSlide(slideNode);
            });
        }
    }

    function handleSlideReady(instance, current, config) {
        if (!current) {
            return;
        }
        var slideNode = current.slideNode;
        var triggerEl = current.trigger || null;
        var slideConfig = current.slideConfig || {};
        var slideType = (slideConfig.type || '').toLowerCase();

        // Sync alt attribute to displayed image (data-alt -> img[alt] -> title -> aria-label)
        if (slideNode && triggerEl) {
            var altText = triggerEl.getAttribute('data-alt') || '';
            if (!altText) {
                var innerImg = triggerEl.querySelector('img');
                if (innerImg) {
                    altText = innerImg.getAttribute('alt') || '';
                }
            }
            if (!altText) {
                altText = (triggerEl.getAttribute('title') || '').replace(/<[^>]*>/g, '');
            }
            if (!altText) {
                var triggerAria = triggerEl.getAttribute('aria-label') || '';
                altText = triggerAria.replace(/^於彈跳視窗觀看：/, '');
            }
            altText = (altText || '').trim();
            var shownImg = slideNode.querySelector('.gslide-image img');
            if (shownImg && altText) {
                shownImg.setAttribute('alt', altText);
            }
        }

        // Fit image height dynamically taking caption height and frame padding into account
        if (slideNode) {
            scheduleFitImageSlide(slideNode);
        }

        var total = instance && instance.elements ? instance.elements.length : 0;
        var index = typeof current.index === 'number' ? current.index : 0;

        // Update dialog aria-label & aria-live announcement for screen readers (NVDA / VoiceOver)
        var label = extractSpeakText(triggerEl, index, 0).replace(/<[^>]*>/g, '').trim() || '圖片';
        var announcement = total > 1 ? label + '，第' + (index + 1) + '張，共' + total + '張' : label;
        announceToScreenReader(announcement, index);

        // Skip speech for iframe / external / inline / ajax slides
        if (config.speech === false) {
            return;
        }
        if (slideType === 'external' || slideType === 'iframe' || slideType === 'inline' || slideType === 'ajax') {
            return;
        }

        var speakText = extractSpeakText(triggerEl, index, total);
        speakImageDescription(speakText, index);
    }

    function attachLifecycleEvents(instance, config) {
        instance.on('open', function () {
            activeInstance = instance;
            lastActiveElement = document.activeElement;
            localizeModalControls();
            ensureAriaLiveRegion();
            applyAriaHiddenBackground();
            enableFocusTrap();
            window.setTimeout(focusInitialModalElement, 60);

            if (activeResizeHandler) {
                window.removeEventListener('resize', activeResizeHandler);
            }
            activeResizeHandler = function () {
                if (activeInstance && typeof activeInstance.getActiveSlide === 'function') {
                    fitImageSlide(activeInstance.getActiveSlide());
                }
            };
            window.addEventListener('resize', activeResizeHandler);

            if (config.autoPlay) {
                startAutoPlay(instance, config.playSpeed);
            }

            // Trigger alt sync + speech for initial slide
            window.setTimeout(function () {
                if (instance && typeof instance.getActiveSlideIndex === 'function') {
                    var idx = instance.getActiveSlideIndex();
                    var activeSlide = instance.getActiveSlide ? instance.getActiveSlide() : null;
                    var elObj = instance.elements && instance.elements[idx] ? instance.elements[idx] : {};
                    handleSlideReady(
                        instance,
                        {
                            index: idx,
                            slideNode: activeSlide,
                            slideConfig: elObj.slideConfig || {},
                            trigger: elObj.node || null
                        },
                        config
                    );
                }
            }, 80);
        });

        instance.on('slide_changed', function (data) {
            if (!data || !data.current) {
                return;
            }
            var idx = typeof data.current.slideIndex === 'number' ? data.current.slideIndex : 0;
            var elObj = instance.elements && instance.elements[idx] ? instance.elements[idx] : {};
            handleSlideReady(
                instance,
                {
                    index: idx,
                    slideNode: data.current.slideNode || null,
                    slideConfig: data.current.slideConfig || elObj.slideConfig || {},
                    trigger: data.current.trigger || elObj.node || null
                },
                config
            );
        });

        instance.on('close', function () {
            stopAutoPlay();
            disableFocusTrap();
            restoreAriaHiddenBackground();
            removeAriaLiveRegion();
            if (activeResizeHandler) {
                window.removeEventListener('resize', activeResizeHandler);
                activeResizeHandler = null;
            }
            if ('speechSynthesis' in window) {
                try {
                    window.speechSynthesis.cancel();
                } catch (e) {
                    // Ignore
                }
            }
            if (activeInstance === instance) {
                activeInstance = null;
            }
            if (lastActiveElement && typeof lastActiveElement.focus === 'function') {
                try {
                    lastActiveElement.focus();
                } catch (e) {
                    // Ignore
                }
            }
            lastActiveElement = null;

            if (config.reload) {
                window.location.reload();
            }
        });
    }

    function openHtml(htmlContent, config) {
        if (typeof window.GLightbox !== 'function') {
            return null;
        }
        config = config || {};
        var width = normalizeDimension(config.width, 'w');
        var height = config.autoSize ? 'auto' : normalizeDimension(config.height, 'h');

        var instance = window.GLightbox({
            elements: [
                {
                    content: htmlContent,
                    width: width,
                    height: height
                }
            ],
            skin: config.skin || 'fancybox2',
            closeOnOutsideClick: !config.preventClosedOutside,
            keyboardNavigation: true,
            touchNavigation: true,
            loop: false
        });

        attachLifecycleEvents(instance, Object.assign({}, config, { speech: false }));
        instance.open();
        return instance;
    }

    function bind(selector, config) {
        if (!selector || typeof window.GLightbox !== 'function') {
            return null;
        }
        config = config || {};

        var nodes = document.querySelectorAll(selector);
        if (!nodes.length) {
            return null;
        }

        var width = normalizeDimension(config.width, 'w');
        var height = normalizeDimension(config.height, 'h');
        var ajaxNodes = [];

        for (var i = 0; i < nodes.length; i++) {
            var el = nodes[i];
            var resolvedType = detectType(el, config.type);

            if (resolvedType === 'ajax') {
                ajaxNodes.push(el);
                continue;
            }

            // Map FancyBox 2 rel="group" to GLightbox data-gallery
            var rel = el.getAttribute('rel');
            if (rel && !el.getAttribute('data-gallery')) {
                el.setAttribute('data-gallery', rel);
            }

            if (resolvedType && !el.getAttribute('data-type')) {
                el.setAttribute('data-type', resolvedType);
            }

            // Apply default dimensions to external (iframe) and inline slides
            if ((resolvedType === 'external' || resolvedType === 'inline') && !el.getAttribute('data-width')) {
                el.setAttribute('data-width', width);
            }
            if ((resolvedType === 'external' || resolvedType === 'inline') && !config.autoSize && !el.getAttribute('data-height')) {
                el.setAttribute('data-height', height);
            }
            // Reserve space for white frame padding and viewport margin on image slides before first paint
            if ((!resolvedType || resolvedType === 'image') && !el.getAttribute('data-height')) {
                el.setAttribute('data-height', 'calc(100vh - 96px)');
            }

            // Preserve FancyBox 2 title attribute for caption display
            if (!el.getAttribute('data-title') && !el.getAttribute('data-glightbox')) {
                var titleText = el.getAttribute('title') || el.getAttribute('data-alt') || '';
                if (titleText) {
                    el.setAttribute('data-title', titleText);
                }
            }
        }

        // Bind AJAX links separately via fetch + openHtml
        for (var j = 0; j < ajaxNodes.length; j++) {
            (function (el) {
                el.setAttribute('data-tad-glightbox-ajax', '1');
                if (el.dataset.tadGlightboxAjaxBound === '1') {
                    return;
                }
                el.dataset.tadGlightboxAjaxBound = '1';
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    var href = el.getAttribute('href');
                    if (!href) {
                        return;
                    }
                    window.fetch(href, { credentials: 'same-origin' })
                        .then(function (res) {
                            return res.text();
                        })
                        .then(function (html) {
                            openHtml(html, config);
                        });
                });
            })(ajaxNodes[j]);
        }

        // Exclude ajax-bound nodes from standard GLightbox selector if mixed
        if (ajaxNodes.length > 0 && ajaxNodes.length === nodes.length) {
            return null;
        }
        var bindSelector = selector;
        if (ajaxNodes.length > 0) {
            bindSelector = selector
                .split(',')
                .map(function (part) {
                    return part.trim() + ':not([data-tad-glightbox-ajax="1"])';
                })
                .join(', ');
        }

        var instance = window.GLightbox({
            selector: bindSelector,
            skin: config.skin || 'fancybox2',
            width: width,
            height: config.autoSize ? '90vh' : height,
            closeOnOutsideClick: !config.preventClosedOutside,
            keyboardNavigation: true,
            touchNavigation: true,
            loop: true
        });

        attachLifecycleEvents(instance, config);
        return instance;
    }

    function bindForm(selector, url, config) {
        if (!selector) {
            return;
        }
        config = config || {};
        var forms = document.querySelectorAll(selector);
        for (var i = 0; i < forms.length; i++) {
            (function (form) {
                if (form.dataset.tadGlightboxFormBound === '1') {
                    return;
                }
                form.dataset.tadGlightboxFormBound = '1';
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    var targetUrl = url || form.getAttribute('action') || window.location.href;
                    var formData = new FormData(form);

                    window.fetch(targetUrl, {
                        method: 'POST',
                        body: formData,
                        credentials: 'same-origin',
                        cache: 'no-store'
                    })
                        .then(function (res) {
                            return res.text();
                        })
                        .then(function (html) {
                            openHtml(html, config);
                        });
                });
            })(forms[i]);
        }
    }

    function close() {
        if (activeInstance && typeof activeInstance.close === 'function') {
            activeInstance.close();
        }
    }

    function onReady(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    window.TadGLightbox = {
        bind: function (selector, config) {
            onReady(function () {
                bind(selector, config);
            });
        },
        bindForm: function (selector, url, config) {
            onReady(function () {
                bindForm(selector, url, config);
            });
        },
        openHtml: openHtml,
        close: close
    };

    // Provide lightweight $.fancybox.close() shim only if legacy FancyBox 2 is not loaded
    if (window.jQuery && !window.jQuery.fancybox) {
        window.jQuery.fancybox = {
            close: close
        };
    }
})(window, document);
