<{if $navbar_pos=='fixed-top' or $navbar_pos=='fixed-bottom'}>
<{assign var=nav_display_type value='not_full'}>
    nav.navbar {
        box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
        -webkit-box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
        -moz-box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
        -o-box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
    }
<{/if}>

<{if $navbar_pos=='fixed-top'}>
    <{assign var=margin_top value=50}>
<{/if}>


<{if $navbar_pos=='fixed-bottom'}>
    <{assign var=margin_bottom value=50}>
<{/if}>


#main-nav {
    border: none;
    padding: 0rem 1rem;
    <{if $nav_display_type=='not_full'}>
        <{if $navbar_img}>
            background-color: tranparent;
            background-image: url(<{$navbar_img}>);
            background-size: cover;
        <{elseif $navbar_bg_top==$navbar_bg_bottom}>
            background: <{$navbar_bg_top}>;
        <{else}>
            background: linear-gradient(<{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
        <{/if}>
    <{/if}>
}



.navbar-custom .navbar-brand,
.navbar-custom .navbar-text,
.navbar-custom .navbar-nav .nav-link,
.navbar-custom .nav-item.active .nav-link,
.navbar-custom .nav-item:focus .nav-link,
.navbar-custom .nav-item:hover .nav-link {
    <{if $navbar_font_size}>
    font-size: <{$navbar_font_size/100}>rem;
    <{/if}>
    color: <{$navbar_color}>;
    padding: <{$navbar_py}>px <{$navbar_px}>px;
}


.navbar-custom .nav-item:hover .nav-link,
.navbar-custom .navbar-brand:hover {
    background: <{$navbar_hover}>;
    color: <{$navbar_color_hover}>;
}

.navbar-custom .dropdown-menu {
    background-color: rgb(255,255,255);
    box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
    -webkit-box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
    -moz-box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
    -o-box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
}


.navbar-nav.sm-collapsible .sub-arrow {
    border: 1px solid rgba(255, 255, 255);
}


.custom-toggler.navbar-toggler {
    border-color: <{$navbar_color}>;
}

.custom-toggler .navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgb(255,255,255)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
}
.navbar-toggler-icon {
    color: <{$navbar_color}>;
}