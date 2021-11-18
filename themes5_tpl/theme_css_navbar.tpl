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


@keyframes fadeIn {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}

.dropdown-menu.show {
  -webkit-animation: fadeIn 0.3s alternate;
  /* Safari 4.0 - 8.0 */
  animation: fadeIn 0.3s alternate;
}

.nav-item.dropdown.dropdown-mega {
  position: static;
}

.nav-item.dropdown.dropdown-mega .dropdown-menu {
  width: 90%;
  top: auto;
  left: 5%;
}

.navbar-toggler {
  border: none;
  padding: 0;
  outline: none;
}

.navbar-toggler:focus {
  box-shadow: none;
}

.navbar-toggler .hamburger-toggle {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 50px;
  z-index: 11;
  float: right;
}

.navbar-toggler .hamburger-toggle .hamburger {
  position: absolute;
  transform: translate(-50%, -50%) rotate(0deg);
  left: 50%;
  top: 50%;
  width: 50%;
  height: 50%;
  pointer-events: none;
}

.navbar-toggler .hamburger-toggle .hamburger span {
  width: 100%;
  height: 4px;
  position: absolute;
  background: #333;
  border-radius: 2px;
  z-index: 1;
  transition: transform 0.2s cubic-bezier(0.77, 0.2, 0.05, 1), background 0.2s cubic-bezier(0.77, 0.2, 0.05, 1), all 0.2s ease-in-out;
  left: 0px;
}

.navbar-toggler .hamburger-toggle .hamburger span:first-child {
  top: 10%;
  transform-origin: 50% 50%;
  transform: translate(0% -50%) !important;
}

.navbar-toggler .hamburger-toggle .hamburger span:nth-child(2) {
  top: 50%;
  transform: translate(0, -50%);
}

.navbar-toggler .hamburger-toggle .hamburger span:last-child {
  left: 0px;
  top: auto;
  bottom: 10%;
  transform-origin: 50% 50%;
}

.navbar-toggler .hamburger-toggle .hamburger.active span {
  position: absolute;
  margin: 0;
}

.navbar-toggler .hamburger-toggle .hamburger.active span:first-child {
  top: 45%;
  transform: rotate(45deg);
}

.navbar-toggler .hamburger-toggle .hamburger.active span:nth-child(2) {
  left: 50%;
  width: 0px;
}

.navbar-toggler .hamburger-toggle .hamburger.active span:last-child {
  top: 45%;
  transform: rotate(-45deg);
}

.icons {
  display: inline-flex;
  margin-left: auto;
}

.icons a {
  transition: all 0.2s ease-in-out;
  padding: 0.2rem 0.4rem;
  color: #ccc !important;
  text-decoration: none;
}

.icons a:hover {
  color: white;
  text-shadow: 0 0 30px white;
}