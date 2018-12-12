.sm-clean {
    background: #eeeeee;
    border-radius: 5px;
}

.sm-clean a,
.sm-clean a:hover,
.sm-clean a:focus,
.sm-clean a:active {
    padding: 13px 20px;
    /* make room for the toggle button (sub indicator) */
    padding-right: 58px;
    font-family: "Lucida Sans Unicode", "Lucida Sans", "Lucida Grande", Arial, sans-serif;
    font-weight: normal;
    line-height: 17px;
    text-decoration: none;
    font-size: <{$navbar_font_size}>%;
    color: <{$navbar_color}>;
}

.sm-clean a.current {
    color: #D23600;
}

.sm-clean a.disabled {
    color: #bbbbbb;
}

.sm-clean a .sub-arrow {
    position: absolute;
    top: 50%;
    margin-top: -17px;
    left: auto;
    right: 4px;
    width: 34px;
    height: 34px;
    overflow: hidden;
    font: bold 16px/34px monospace !important;
    text-align: center;
    text-shadow: none;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 5px;
}

.sm-clean a .sub-arrow::before {
    content: '+';
}

.sm-clean a.highlighted .sub-arrow::before {
    content: '-';
}

.sm-clean>li:first-child>a,
.sm-clean>li:first-child> :not(ul) a {
    border-radius: 5px 5px 0 0;
}

.sm-clean>li:last-child>a,
.sm-clean>li:last-child>*:not(ul) a,
.sm-clean>li:last-child>ul,
.sm-clean>li:last-child>ul>li:last-child>a,
.sm-clean>li:last-child>ul>li:last-child>*:not(ul) a,
.sm-clean>li:last-child>ul>li:last-child>ul,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>a,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>*:not(ul) a,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>ul,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>a,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>*:not(ul) a,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>ul,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>a,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>*:not(ul) a,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>ul {
    border-radius: 0 0 5px 5px;
}

.sm-clean>li:last-child>a.highlighted,
.sm-clean>li:last-child>*:not(ul) a.highlighted,
.sm-clean>li:last-child>ul>li:last-child>a.highlighted,
.sm-clean>li:last-child>ul>li:last-child>*:not(ul) a.highlighted,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>a.highlighted,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>*:not(ul) a.highlighted,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>a.highlighted,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>*:not(ul) a.highlighted,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>a.highlighted,
.sm-clean>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>ul>li:last-child>*:not(ul) a.highlighted {
    border-radius: 0;
}

.sm-clean li {
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.sm-clean>li:first-child {
    border-top: 0;
}

.sm-clean ul {
    background: rgba(162, 162, 162, 0.1);
}

.sm-clean ul a,
.sm-clean ul a:hover,
.sm-clean ul a:focus,
.sm-clean ul a:active {
    font-size: 16px;
    border-left: 8px solid transparent;
}

.sm-clean ul ul a,
.sm-clean ul ul a:hover,
.sm-clean ul ul a:focus,
.sm-clean ul ul a:active {
    border-left: 16px solid transparent;
}

.sm-clean ul ul ul a,
.sm-clean ul ul ul a:hover,
.sm-clean ul ul ul a:focus,
.sm-clean ul ul ul a:active {
    border-left: 24px solid transparent;
}

.sm-clean ul ul ul ul a,
.sm-clean ul ul ul ul a:hover,
.sm-clean ul ul ul ul a:focus,
.sm-clean ul ul ul ul a:active {
    border-left: 32px solid transparent;
}

.sm-clean ul ul ul ul ul a,
.sm-clean ul ul ul ul ul a:hover,
.sm-clean ul ul ul ul ul a:focus,
.sm-clean ul ul ul ul ul a:active {
    border-left: 40px solid transparent;
}

@media (min-width: 768px) {

    /* Switch to desktop layout
-----------------------------------------------
    These transform the menu tree from
    collapsible to desktop (navbar + dropdowns)
-----------------------------------------------*/
    /* start... (it's not recommended editing these rules) */
    .sm-clean ul {
        position: absolute;
        width: 12em;
    }

    .sm-clean li {
        float: left;
    }

    .sm-clean.sm-rtl li {
        float: right;
    }

    .sm-clean ul li,
    .sm-clean.sm-rtl ul li,
    .sm-clean.sm-vertical li {
        float: none;
    }

    .sm-clean a {
        white-space: nowrap;
    }

    .sm-clean ul a,
    .sm-clean.sm-vertical a {
        white-space: normal;
    }

    .sm-clean .sm-nowrap>li>a,
    .sm-clean .sm-nowrap>li> :not(ul) a {
        white-space: nowrap;
    }

    /* ...end */
    .sm-clean {
        padding: 0 10px;
        background: #eeeeee;
        border-radius: 100px;
    }

    .sm-clean a,
    .sm-clean a:hover,
    .sm-clean a:focus,
    .sm-clean a:active,
    .sm-clean a.highlighted {        
        padding: <{$navbar_py}>px <{$navbar_px}>px;
        border-radius: 0 !important;
        color: <{$navbar_color}>;
    }

    .sm-clean a:hover,
    .sm-clean a:focus,
    .sm-clean a:active,
    .sm-clean a.highlighted {
        background: <{$navbar_hover}>;
        color: <{$navbar_color_hover}>;
    }

    .sm-clean a.current {
        background: <{$navbar_hover}>;
        color: <{$navbar_color_hover}>;
    }

    .sm-clean a.disabled {
        color: #bbbbbb;
    }

    .sm-clean a.has-submenu {
        padding-right: 24px;
    }

    .sm-clean a .sub-arrow {
        top: 50%;
        margin-top: -2px;
        right: 12px;
        width: 0;
        height: 0;
        border-width: 4px;
        border-style: solid dashed dashed dashed;
        border-color: <{$navbar_color}> transparent transparent transparent;
        background: transparent;
        border-radius: 0;
    }

    .sm-clean a .sub-arrow::before {
        display: none;
    }

    .sm-clean li {
        border-top: 0;
    }

    .sm-clean>li>ul::before,
    .sm-clean>li>ul::after {
        content: '';
        position: absolute;
        top: -18px;
        left: 30px;
        width: 0;
        height: 0;
        overflow: hidden;
        border-width: 9px;
        border-style: dashed dashed solid dashed;
        border-color: transparent transparent #bbbbbb transparent;
    }

    .sm-clean>li>ul::after {
        top: -16px;
        left: 31px;
        border-width: 8px;
        border-color: transparent transparent #fff transparent;
    }

    .sm-clean ul {
        border: 1px solid #bbbbbb;
        padding: 5px 0;
        background: #fff;
        border-radius: 5px !important;
        box-shadow: 0 5px 9px rgba(0, 0, 0, 0.2);
    }

    .sm-clean ul a,
    .sm-clean ul a:hover,
    .sm-clean ul a:focus,
    .sm-clean ul a:active,
    .sm-clean ul a.highlighted {
        border: 0 !important;
        padding: 10px 20px;
        color: #555555;
    }

    .sm-clean ul a:hover,
    .sm-clean ul a:focus,
    .sm-clean ul a:active,
    .sm-clean ul a.highlighted {
        background: #eeeeee;
        color: #D23600;
    }

    .sm-clean ul a.current {
        color: #D23600;
    }

    .sm-clean ul a.disabled {
        background: #fff;
        color: #cccccc;
    }

    .sm-clean ul a.has-submenu {
        padding-right: 20px;
    }

    .sm-clean ul a .sub-arrow {
        right: 0px;
        top: 50%;
        margin-top: -5px;
        border-width: 5px;
        border-style: dashed dashed dashed solid;
        border-color: transparent transparent transparent #555555;
    }

    .sm-clean .scroll-up,
    .sm-clean .scroll-down {
        position: absolute;
        display: none;
        visibility: hidden;
        overflow: hidden;
        background: #fff;
        height: 20px;
    }

    .sm-clean .scroll-up:hover,
    .sm-clean .scroll-down:hover {
        background: #eeeeee;
    }

    .sm-clean .scroll-up:hover .scroll-up-arrow {
        border-color: transparent transparent #D23600 transparent;
    }

    .sm-clean .scroll-down:hover .scroll-down-arrow {
        border-color: #D23600 transparent transparent transparent;
    }

    .sm-clean .scroll-up-arrow,
    .sm-clean .scroll-down-arrow {
        position: absolute;
        top: 0;
        left: 50%;
        margin-left: -6px;
        width: 0;
        height: 0;
        overflow: hidden;
        border-width: 6px;
        border-style: dashed dashed solid dashed;
        border-color: transparent transparent #555555 transparent;
    }

    .sm-clean .scroll-down-arrow {
        top: 8px;
        border-style: solid dashed dashed dashed;
        border-color: #555555 transparent transparent transparent;
    }

    .sm-clean.sm-rtl a.has-submenu {
        padding-right: 12px;
        padding-left: 24px;
    }

    .sm-clean.sm-rtl a .sub-arrow {
        right: auto;
        left: 12px;
    }

    .sm-clean.sm-rtl.sm-vertical a.has-submenu {
        padding: 10px 20px;
    }

    .sm-clean.sm-rtl.sm-vertical a .sub-arrow {
        right: auto;
        left: 8px;
        border-style: dashed solid dashed dashed;
        border-color: transparent #555555 transparent transparent;
    }

    .sm-clean.sm-rtl>li>ul::before {
        left: auto;
        right: 30px;
    }

    .sm-clean.sm-rtl>li>ul::after {
        left: auto;
        right: 31px;
    }

    .sm-clean.sm-rtl ul a.has-submenu {
        padding: 10px 20px !important;
    }

    .sm-clean.sm-rtl ul a .sub-arrow {
        right: auto;
        left: 8px;
        border-style: dashed solid dashed dashed;
        border-color: transparent #555555 transparent transparent;
    }

    .sm-clean.sm-vertical {
        padding: 10px 0;
        border-radius: 5px;
    }

    .sm-clean.sm-vertical a {
        padding: 10px 20px;
    }

    .sm-clean.sm-vertical a:hover,
    .sm-clean.sm-vertical a:focus,
    .sm-clean.sm-vertical a:active,
    .sm-clean.sm-vertical a.highlighted {
        background: #fff;
    }

    .sm-clean.sm-vertical a.disabled {
        background: #eeeeee;
    }

    .sm-clean.sm-vertical a .sub-arrow {
        right: 8px;
        top: 50%;
        margin-top: -5px;
        border-width: 5px;
        border-style: dashed dashed dashed solid;
        border-color: transparent transparent transparent #555555;
    }

    .sm-clean.sm-vertical>li>ul::before,
    .sm-clean.sm-vertical>li>ul::after {
        display: none;
    }

    .sm-clean.sm-vertical ul a {
        padding: 10px 20px;
    }

    .sm-clean.sm-vertical ul a:hover,
    .sm-clean.sm-vertical ul a:focus,
    .sm-clean.sm-vertical ul a:active,
    .sm-clean.sm-vertical ul a.highlighted {
        background: #eeeeee;
    }

    .sm-clean.sm-vertical ul a.disabled {
        background: #fff;
    }
}

/*# sourceMappingURL=sm-clean.css.map */

.main-nav {
    border: none;
    <{if $nav_display_type=='not_full'}>
        <{if $navbar_img}>
            background-color:tranparent;
            background-image: url(<{$navbar_img}>);
            background-size: cover;
        <{elseif $navbar_bg_top==$navbar_bg_bottom}>
            background-color: <{$navbar_bg_top}>;
        <{else}>
            background-color: linear-gradient(<{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
        <{/if}>
    <{/if}>
}

.main-nav:after {
    clear: both;
    content: "\00a0";
    display: block;
    height: 0;
    font: 0px/0 serif;
    overflow: hidden;
}

.nav-brand {
    float: left;
    margin: 0;
    background-color: transparent;
}

.nav-brand a {
    display: block;
    font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
    font-weight: normal;
    line-height: 17px;
    text-decoration: none;
    font-size: <{$navbar_font_size}>%;
    color: <{$navbar_color}>;
    padding: <{$navbar_py}>px <{$navbar_px}>px;
}

#main-menu {
    width: 100%;
    clear: both;
    border: 0;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
}

@media (min-width: 768px) {
    #main-menu {
        float: left;
        clear: none;
    }

    li.right-btn {
        float: right;
        clear: none;
    }
}

/* Mobile menu toggle button */

.main-menu-btn {
    float: right;
    margin: 5px 10px;
    position: relative;
    display: inline-block;
    width: 29px;
    height: 29px;
    text-indent: 29px;
    white-space: nowrap;
    overflow: hidden;
    cursor: pointer;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}


/* hamburger icon */

.main-menu-btn-icon,
.main-menu-btn-icon:before,
.main-menu-btn-icon:after {
    position: absolute;
    top: 50%;
    left: 2px;
    height: 2px;
    width: 24px;
    background: #555;
    -webkit-transition: all 0.25s;
    transition: all 0.25s;
}

.main-menu-btn-icon:before {
    content: '';
    top: -7px;
    left: 0;
}

.main-menu-btn-icon:after {
    content: '';
    top: 7px;
    left: 0;
}


/* x icon */

#main-menu-state:checked~.main-menu-btn .main-menu-btn-icon {
    height: 0;
    background: transparent;
}

#main-menu-state:checked~.main-menu-btn .main-menu-btn-icon:before {
    top: 0;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
}

#main-menu-state:checked~.main-menu-btn .main-menu-btn-icon:after {
    top: 0;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
}


/* hide menu state checkbox (keep it visible to screen readers) */

#main-menu-state {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    border: 0;
    padding: 0;
    overflow: hidden;
    clip: rect(1px, 1px, 1px, 1px);
}


/* hide the menu in mobile view */

#main-menu-state:not(:checked)~#main-menu {
    display: none;
}

#main-menu-state:checked~#main-menu {
    display: block;
}

@media (min-width: 768px) {

    /* hide the button in desktop view */
    .main-menu-btn {
        position: absolute;
        top: -99999px;
    }

    /* always show the menu in desktop view */
    #main-menu-state:not(:checked)~#main-menu {
        display: block;
    }
}
