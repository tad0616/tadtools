
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