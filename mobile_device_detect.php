<?php

use XoopsModules\Tadtools\Utility;

function mobile_device_detect($iphone = true, $ipad = true, $android = true, $opera = true, $blackberry = true, $palm = true, $windows = true, $mobileredirect = false, $desktopredirect = false)
{
    return Utility::mobile_device_detect($iphone, $ipad, $android, $opera, $blackberry, $palm, $windows, $mobileredirect, $desktopredirect);
}
