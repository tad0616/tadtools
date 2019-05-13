<?php
require_once dirname(dirname(__DIR__)) . '/mainfile.php';
// require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
use XoopsModules\Tadtools\Captcha;
Captcha::draw();
