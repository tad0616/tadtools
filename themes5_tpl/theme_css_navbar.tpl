.sm-mint {
  border-top: 2px solid <{$nav_sub_bg_color}>;
  border-bottom: 2px solid <{$nav_sub_bg_color}>;
  background: transparent;
}
.sm-mint a, .sm-mint a:hover, .sm-mint a:focus, .sm-mint a:active {
  padding: <{$navbar_py}>px <{$navbar_px}>px;
  /* make room for the toggle button (sub indicator) */
  padding-right: 58px;
  color: <{$navbar_color}>;
  font-family: <{if $font_family|default:false}><{$font_family}>, <{/if}>FontAwesome;
  font-size: <{$navbar_font_size}>rem;
  font-weight: normal;
  line-height: 17px;
  text-decoration: none;
}
.sm-mint a.current {
  font-weight: bold;
}
.sm-mint a.disabled {
  color: #cccccc;
}
.sm-mint a .sub-arrow {
  position: absolute;
  top: 50%;
  margin-top: -17px;
  left: auto;
  right: 4px;
  width: 34px;
  height: 34px;
  overflow: hidden;
  font: bold 0.875rem/2.125rem monospace !important;
  text-align: center;
  text-shadow: none;
  background: <{$navbar_hover}>;
  color:<{$navbar_color_hover}>;
  border-radius: 4px;
}
.sm-mint a .sub-arrow::before {
  content: '+';
}
.sm-mint a.highlighted .sub-arrow::before {
  content: '-';
}
.sm-mint li {
  border-top: 1px solid <{$nav_sub_font_color}>22;
}
.sm-mint > li:first-child {
  border-top: 0;
}
.sm-mint ul {
  background: <{$nav_sub_bg_color}>88;
}
.sm-mint ul a, .sm-mint ul a:hover, .sm-mint ul a:focus, .sm-mint ul a:active {
  color: <{$nav_sub_font_color}>;
  font-size: <{$navbar_font_size}>rem;
  border-left: 8px solid transparent;
}

.sm-mint ul ul a,
.sm-mint ul ul a:hover,
.sm-mint ul ul a:focus,
.sm-mint ul ul a:active {
  color: <{$nav_sub_font_color}>;
  border-left: 8px solid transparent;
}

.sm-mint ul ul ul a,
.sm-mint ul ul ul a:hover,
.sm-mint ul ul ul a:focus,
.sm-mint ul ul ul a:active {
  color: <{$nav_sub_font_color}>;
  border-left: 8px solid transparent;
}
.sm-mint ul ul ul ul a,
.sm-mint ul ul ul ul a:hover,
.sm-mint ul ul ul ul a:focus,
.sm-mint ul ul ul ul a:active {
  color: <{$nav_sub_font_color}>;
  border-left: 8px solid transparent;
}

.sm-mint ul ul ul ul ul a,
.sm-mint ul ul ul ul ul a:hover,
.sm-mint ul ul ul ul ul a:focus,
.sm-mint ul ul ul ul ul a:active {
  color: <{$nav_sub_font_color}>;
  border-left: 8px solid transparent;
}

@media (min-width: 768px) {
  /* Switch to desktop layout
  -----------------------------------------------
     These transform the menu tree from
     collapsible to desktop (navbar + dropdowns)
  -----------------------------------------------*/
  /* start... (it's not recommended editing these rules) */
  .sm-mint ul {
    position: absolute;
    width: 12em;
    z-index: 250;
  }

  .sm-mint li {
    float: left;
  }

  .sm-mint.sm-rtl li {
    float: right;
  }

  .sm-mint ul li, .sm-mint.sm-rtl ul li, .sm-mint.sm-vertical li {
    float: none;
  }

  .sm-mint a {
    white-space: nowrap;
  }

  .sm-mint ul a, .sm-mint.sm-vertical a {
    white-space: normal;
  }

  .sm-mint .sm-nowrap > li > a, .sm-mint .sm-nowrap > li > :not(ul) a {
    white-space: nowrap;
  }

  /* ...end */
  .sm-mint {
    border-top: 0;
    background: transparent;
  }
  .sm-mint a, .sm-mint a:hover, .sm-mint a:focus, .sm-mint a:active, .sm-mint a.highlighted {
    padding: <{$navbar_py}>px <{$navbar_px}>px;
    color: <{$navbar_color}>;
    border-radius: 4px 4px 0 0;
    border-radius: 0;
  }
  .sm-mint a:hover, .sm-mint a:focus, .sm-mint a:active {
    background: <{$navbar_hover}>;
    color: <{$navbar_color_hover}>;
  }

  .sm-mint a.highlighted {
    background: <{$nav_sub_bg_color}>;
    color: <{$nav_sub_font_color}>;
    box-shadow: 0 4px 3px rgba(0, 0, 0, 0.25);
  }


  .sm-mint a.disabled {
    background: transparent;
    color: #cccccc;
    box-shadow: none;
  }
  .sm-mint a.has-submenu {
    padding-right: 34px;
  }
  .sm-mint a .sub-arrow {
    top: 50%;
    margin-top: -3px;
    right: 20px;
    width: 0;
    height: 0;
    border-width: 6px 4.02px 0 4.02px;
    border-style: solid dashed dashed dashed;
    border-color: <{$navbar_color}> transparent transparent transparent;
    background: transparent;
    border-radius: 0;
  }
  .sm-mint a:hover .sub-arrow, .sm-mint a:focus .sub-arrow, .sm-mint a:active .sub-arrow {
    border-color: <{$navbar_color_hover}> transparent transparent transparent;
  }
  .sm-mint a.highlighted .sub-arrow {
    border-color: <{$navbar_color}> transparent transparent transparent;
  }
  .sm-mint a.disabled .sub-arrow {
    border-color: <{$navbar_color}> transparent transparent transparent;
  }
  .sm-mint a .sub-arrow::before {
    display: none;
  }
  .sm-mint li {
    border-top: 0;
  }
  .sm-mint ul {
    border: 0;
    padding: 8px 0;
    background: <{$nav_sub_bg_color}>;
    border-radius: 0 4px 4px 4px;
    box-shadow: 0 4px 3px rgba(0, 0, 0, 0.25);
  }
  .sm-mint ul ul {
    border-radius: 4px;
  }

  .sm-mint ul a, .sm-mint ul a:hover, .sm-mint ul a:focus, .sm-mint ul a:active, .sm-mint ul a.highlighted {
    <{if $nav_sub_y_padding > 0}>
    padding: <{$nav_sub_y_padding}>px 20px;
    <{else}>
    padding: 12px 20px;
    <{/if}>
    border-radius: 0;
    <{if $nav_line=='1'}>
    border-bottom: 1px solid #00000011;
    <{else}>
    border: none !important;
    <{/if}>
  }

  .sm-mint ul li:last-child a{
    border-bottom: none;
    <{if $nav_sub_y_padding > 0}>
      padding: <{$nav_sub_y_padding}>px 20px <{$nav_sub_y_padding/2}>px;
    <{else}>
      padding: 12px 20px 6px;
    <{/if}>
  }

  .sm-mint ul a:hover, .sm-mint ul a:focus, .sm-mint ul a:active, .sm-mint ul a.highlighted {
    background: <{$navbar_hover}>;
    color: <{$navbar_color_hover}>;
    box-shadow: none;
  }
  .sm-mint ul a.disabled {
    background: transparent;
    color: #b3b3b3;
  }

  .sm-mint ul a.has-submenu {
    padding-right: 20px;
  }
  .sm-mint ul a .sub-arrow {
    right: 10px;
    margin-top: -4.02px;
    border-width: 4.02px 0 4.02px 6px;
    border-style: dashed dashed dashed solid;
    border-color: transparent transparent transparent <{$navbar_color}>;
  }
  .sm-mint ul a:hover .sub-arrow, .sm-mint ul a:focus .sub-arrow, .sm-mint ul a:active .sub-arrow, .sm-mint ul a.highlighted .sub-arrow {
    border-color: transparent transparent transparent <{$navbar_color_hover}>;
  }
  .sm-mint ul a.disabled .sub-arrow {
    border-color: transparent transparent transparent <{$navbar_color}>;
  }
  .sm-mint .scroll-up,
  .sm-mint .scroll-down {
    position: absolute;
    display: none;
    visibility: hidden;
    overflow: hidden;
    background: <{$nav_sub_bg_color}>;
    height: 20px;
  }
  .sm-mint .scroll-up-arrow,
  .sm-mint .scroll-down-arrow {
    position: absolute;
    top: 6px;
    left: 50%;
    margin-left: -8px;
    width: 0;
    height: 0;
    overflow: hidden;
    border-width: 0 6px 8px 6px;
    border-style: dashed dashed solid dashed;
    border-color: transparent transparent <{$navbar_hover}> transparent;
  }
  .sm-mint .scroll-down-arrow {
    border-width: 8px 6px 0 6px;
    border-style: solid dashed dashed dashed;
    border-color: <{$navbar_hover}> transparent transparent transparent;
  }
  .sm-mint.sm-rtl a.has-submenu {
    padding-right: 20px;
    padding-left: 34px;
  }
  .sm-mint.sm-rtl a .sub-arrow {
    right: auto;
    left: 20px;
  }
  .sm-mint.sm-rtl.sm-vertical {
    border-right: 0;
    border-left: 2px solid <{$navbar_hover}>;
  }
  .sm-mint.sm-rtl.sm-vertical a {
    border-radius: 0 4px 4px 0;
  }
  .sm-mint.sm-rtl.sm-vertical a.has-submenu {
    padding: 10px 20px;
  }
  .sm-mint.sm-rtl.sm-vertical a .sub-arrow {
    right: auto;
    left: 10px;
    border-width: 4.02px 6px 4.02px 0;
    border-style: dashed solid dashed dashed;
    border-color: transparent <{$navbar_hover}> transparent transparent;
  }
  .sm-mint.sm-rtl.sm-vertical a:hover .sub-arrow, .sm-mint.sm-rtl.sm-vertical a:focus .sub-arrow, .sm-mint.sm-rtl.sm-vertical a:active .sub-arrow, .sm-mint.sm-rtl.sm-vertical a.highlighted .sub-arrow {
    border-color: transparent <{$navbar_color_hover}> transparent transparent;
  }
  .sm-mint.sm-rtl.sm-vertical a.disabled .sub-arrow {
    border-color: transparent <{$navbar_hover}> transparent transparent;
  }
  .sm-mint.sm-rtl ul {
    border-radius: 4px 0 4px 4px;
  }
  .sm-mint.sm-rtl ul a {
    border-radius: 0 !important;
  }
  .sm-mint.sm-rtl ul a.has-submenu {
    padding: 10px 20px !important;
  }
  .sm-mint.sm-rtl ul a .sub-arrow {
    right: auto;
    left: 10px;
    border-width: 4.02px 6px 4.02px 0;
    border-style: dashed solid dashed dashed;
    border-color: transparent <{$navbar_hover}> transparent transparent;
  }
  .sm-mint.sm-rtl ul a:hover .sub-arrow, .sm-mint.sm-rtl ul a:focus .sub-arrow, .sm-mint.sm-rtl ul a:active .sub-arrow, .sm-mint.sm-rtl ul a.highlighted .sub-arrow {
    border-color: transparent <{$navbar_color_hover}> transparent transparent;
  }
  .sm-mint.sm-rtl ul a.disabled .sub-arrow {
    border-color: transparent <{$navbar_hover}> transparent transparent;
  }
  .sm-mint.sm-vertical {
    border-bottom: 0;
    border-right: 2px solid <{$navbar_hover}>;
  }
  .sm-mint.sm-vertical a {
    padding: 10px 20px;
    border-radius: 4px 0 0 4px;
  }
  .sm-mint.sm-vertical a:hover, .sm-mint.sm-vertical a:focus, .sm-mint.sm-vertical a:active, .sm-mint.sm-vertical a.highlighted {
    background: <{$navbar_hover}>;
    color: <{$navbar_color_hover}>;
    box-shadow: none;
  }
  .sm-mint.sm-vertical a.disabled {
    background: transparent;
    color: #cccccc;
  }
  .sm-mint.sm-vertical a .sub-arrow {
    right: 10px;
    margin-top: -4.02px;
    border-width: 4.02px 0 4.02px 6px;
    border-style: dashed dashed dashed solid;
    border-color: transparent transparent transparent <{$navbar_hover}>;
  }
  .sm-mint.sm-vertical a:hover .sub-arrow, .sm-mint.sm-vertical a:focus .sub-arrow, .sm-mint.sm-vertical a:active .sub-arrow, .sm-mint.sm-vertical a.highlighted .sub-arrow {
    border-color: transparent transparent transparent <{$navbar_color}>;
  }
  .sm-mint.sm-vertical a.disabled .sub-arrow {
    border-color: transparent transparent transparent <{$navbar_hover}>;
  }
  .sm-mint.sm-vertical ul {
    border-radius: 4px !important;
  }
  .sm-mint.sm-vertical ul a {
    padding: 10px 20px;
  }
}

/*# sourceMappingURL=sm-mint.css.map */

#main-nav {
    border: none;
    position: relative;
    min-height: 50px;
    <{* <{if $nav_display_type=='not_full'}>
        <{if $navbar_img|default:false}>
            background-color: tranparent;
            background-image: url(<{$navbar_img}>);
            /* background-size: cover; */
        <{elseif $navbar_bg_top==$navbar_bg_bottom}>
            background: <{$navbar_bg_top}>;
        <{else}>
            background: linear-gradient(<{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
        <{/if}>
    <{/if}> *}>
}

/* Complete navbar .sm-mint */

<{* .main-nav {
  /* border-bottom: 2px solid #8db863;
  background: #fff; */
}

.main-nav:after {
  clear: both;
  content: "\00a0";
  display: block;
  height: 0;
  font: 0rem/0 serif;
  overflow: hidden;
} *}>

.nav-brand {
  float: left;
  margin: 0;
}

.nav-brand a {
  display: block;
  <{if !$navlogo_img}>
  padding: 11px 11px 11px 20px;
  <{/if}>
  color: <{$navbar_color}>;
  <{if $navbar_font_size|default:false}>
    font-size: <{$navbar_font_size}>rem;
  <{/if}>
  font-weight: normal;
  text-decoration: none;
}

#main-menu {
  clear: both;
  border-bottom: 0;
}

@media (min-width: 768px) {
  #main-menu {
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
  background: <{$navbar_color}>;
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

#main-menu-state:checked ~ .main-menu-btn .main-menu-btn-icon {
  height: 0;
  background: transparent;
}

#main-menu-state:checked ~ .main-menu-btn .main-menu-btn-icon:before {
  top: 0;
  -webkit-transform: rotate(-45deg);
  transform: rotate(-45deg);
}

#main-menu-state:checked ~ .main-menu-btn .main-menu-btn-icon:after {
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

#main-menu-state:not(:checked) ~ #main-menu {
  display: none;
}

#main-menu-state:checked ~ #main-menu {
  display: block;
}

@media (min-width: 768px) {
  /* hide the button in desktop view */
  .main-menu-btn {
    position: absolute;
    top: -99999px;
  }
  /* always show the menu in desktop view */
  #main-menu-state:not(:checked) ~ #main-menu {
    display: block;
  }
}
