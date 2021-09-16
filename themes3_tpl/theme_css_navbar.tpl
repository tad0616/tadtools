
.navbar-default {
  background-color: <{$navbar_bg_bottom}>;
  background-image: -moz-linear-gradient(top, <{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
  background-image: -webkit-linear-gradient(top, <{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
  background-image: -o-linear-gradient(top, <{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
  background-image: linear-gradient(to bottom, <{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(<{$navbar_bg_top}>), to(<{$avbar_bg_bottom}>));
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=<{$navbar_bg_top}>, endColorstr=<{$navbar_bg_bottom}>, GradientType=0);
  min-height: inherit;
}

.navbar-default .navbar-nav > li > a {
  color: <{$navbar_color}>;
  padding: <{$navbar_py}>px <{$navbar_px}>px;
  font-size: <{$navbar_font_size/100}>rem;
}
.navbar-default .navbar-nav > li > a:focus,
.navbar-default .navbar-nav > li > a:hover {
  color:<{$navbar_color_hover}>;
}
.navbar-default .navbar-nav > li > a:hover {
  background-color: <{$navbar_hover}>;
}


.navbar-default .navbar-nav li.dropdown.open > .dropdown-toggle,
.navbar-default .navbar-nav li.dropdown.active > .dropdown-toggle,
.navbar-default .navbar-nav li.dropdown.open.active > .dropdown-toggle {
  background-color: <{$navbar_hover}>;
}

.navbar-default .navbar-navbar-btn {
  background-color: <{$navbar_bg_bottom}>;
  background-image: -moz-linear-gradient(top, <{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
  background-image: -webkit-linear-gradient(top, <{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
  background-image: -o-linear-gradient(top, <{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
  background-image: linear-gradient(to bottom, <{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(<{$navbar_bg_top}>), to(<{$avbar_bg_bottom}>));
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=<{$navbar_bg_top}>, endColorstr=<{$navbar_bg_bottom}>, GradientType=0);

}

.dropdown-menu > li > a{
  font-size: <{$navbar_font_size/100}>rem;
}

<{if $navbar_pos=='navbar-fixed-top'}>
  <{assign var=margin_top value=50}>
  nav.navbar {
    box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
    -webkit-box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
    -moz-box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
    -o-box-shadow: 0px 3px 10px 1px rgba(0, 0, 0, 0.5);
  }
<{/if}>


<{if $navbar_pos=='navbar-fixed-bottom'}>
  <{assign var=margin_bottom value=50}>
  nav.navbar {
    box-shadow: 0px -3px 10px 1px rgba(0, 0, 0, 0.5);
    -webkit-box-shadow: 0px -3px 10px 1px rgba(0, 0, 0, 0.5);
    -moz-box-shadow: 0px -3px 10px 1px rgba(0, 0, 0, 0.5);
    -o-box-shadow: 0px -3px 10px 1px rgba(0, 0, 0, 0.5);
  }
<{/if}>