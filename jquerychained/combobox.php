<?php
include "../../../../mainfile.php";

$array = array();
switch ($_GET['_name']) {
    case "menu1":
        $array[] = get_menu2($_GET['_value']);
        break;

    case "menu2":
        $array[] = get_menu3($_GET['_value']);
        break;

}
echo jsonencode($array);

function get_menu2($val = "")
{
    global $xoopsDB;
    $sql    = "SELECT `sn`,`title` FROM " . $xoopsDB->prefix("資料表") . " where xxx='$val' order by xxx";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
    while (list($sn, $title) = $xoopsDB->fetchRow($result)) {
        $all[$sn] = $title;
    }
    return $all;
}

function get_menu3($val = "")
{
    global $xoopsDB;
    $sql    = "SELECT `sn`,`title` FROM " . $xoopsDB->prefix("資料表") . " where xxx='$val' order by xxx";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
    while (list($sn, $title) = $xoopsDB->fetchRow($result)) {
        $all[$sn] = $title;
    }
    return $all;
}

if (!function_exists("jsonencode")) {
    function jsonencode($a = false)
    {
        if (is_null($a)) {
            return 'null';
        }

        if ($a === false) {
            return 'false';
        }

        if ($a === true) {
            return 'true';
        }

        if (is_scalar($a)) {
            if (is_float($a)) {
                // Always use "." for floats.
                return floatval(str_replace(",", ".", strval($a)));
            }

            if (is_string($a)) {
                static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
            } else {
                return $a;
            }

        }
        $isList = true;
        for ($i = 0, reset($a); $i < count($a); $i++, next($a)) {
            if (key($a) !== $i) {
                $isList = false;
                break;
            }
        }
        $result = array();
        if ($isList) {
            foreach ($a as $v) {
                $result[] = json_encode($v);
            }

            return '[' . join(',', $result) . ']';
        } else {
            foreach ($a as $k => $v) {
                $result[] = json_encode($k) . ':' . json_encode($v);
            }

            return '{' . join(',', $result) . '}';
        }
    }
}
