<?php

$adminmenu = [];

$i                      = 1;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_HOME;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['desc']  = _MI_TAD_ADMIN_HOME;
$adminmenu[$i]['icon']  = 'images/admin/home.png';

++$i;
$adminmenu[$i]['title'] = _MI_TADTOOLS_ADMENU1;
$adminmenu[$i]['link']  = "admin/main.php";
$adminmenu[$i]['desc']  = _MI_TADTOOLS_ADMENU1;
$adminmenu[$i]['icon']  = 'images/admin/folder_txt.png';

++$i;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['desc']  = _MI_TAD_ADMIN_ABOUT;
$adminmenu[$i]['icon']  = 'images/admin/about.png';
