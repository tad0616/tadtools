<?php
class TadtoolsCorePreload extends XoopsPreloadItem
{
    public static function eventCoreFooterStart($args)
    {
        global $xoopsConfig, $xoopsDB, $xoTheme, $xoopsTpl, $xoopsUser, $xoTheme;

        $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');

        $xoTheme->addStylesheet('modules/tadtools/jquery/themes/base/jquery.ui.all.css');
        // $xoTheme->addScript('modules/tadtools/jquery/ui/jquery-ui.js');
        $xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.ui.js');
        //$xoTheme->addScript('modules/tadtools/jquery/jquery.jgrowl.js');
        $theme_set = $xoopsConfig['theme_set'];

        $_SESSION['now_theme_set'] = $theme_set;

        if (!isset($xoTheme)) {
            $xoTheme = &$GLOBALS['xoTheme'];
        }

        if (!isset($_SESSION['old_theme_set'])) {
            $_SESSION['old_theme_set'] = $theme_set;
        }

        $_SESSION['old_theme_set'] = $theme_set;

        $sql    = 'select `tt_theme`,`tt_use_bootstrap`,`tt_bootstrap_color`,`tt_theme_kind` from `' . $xoopsDB->prefix('tadtools_setup') . "`  where `tt_theme`='{$theme_set}'";
        $result = $xoopsDB->query($sql);

        list($tt_theme, $tt_use_bootstrap, $tt_bootstrap_color, $tt_theme_kind) = $xoopsDB->fetchRow($result);

        if (empty($tt_theme_kind)) {
            if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_set}/config.php")) {
                require_once XOOPS_ROOT_PATH . "/themes/{$theme_set}/config.php";
                if (isset($theme_kind)) {
                    $tt_theme_kind      = $theme_kind;
                    $tt_use_bootstrap   = 'html' === $theme_kind ? 1 : 0;
                    $tt_bootstrap_color = 'bootstrap3';
                    if (empty($tt_theme)) {
                        $sql = 'insert into `' . $xoopsDB->prefix('tadtools_setup') . "`  (`tt_theme`,`tt_use_bootstrap`,`tt_bootstrap_color`,`tt_theme_kind`) values('{$theme_set}','{$tt_use_bootstrap}','{$tt_bootstrap_color}','{$tt_theme_kind}')";
                    } else {
                        $sql = 'update `' . $xoopsDB->prefix('tadtools_setup') . "` set `tt_use_bootstrap`='{$tt_use_bootstrap}',
                            `tt_bootstrap_color`='{$tt_bootstrap_color}',
                            `tt_theme_kind`='{$tt_theme_kind}' where `tt_theme`='{$theme_set}'";
                    }
                    $xoopsDB->queryF($sql);
                }
            } else {
                $tt_theme_kind      = 'html';
                $tt_use_bootstrap   = 1;
                $tt_bootstrap_color = 'bootstrap3';
            }
        }

        $_SESSION['theme_kind']                    = $tt_theme_kind;
        $_SESSION[$theme_set]['bootstrap_version'] = $tt_theme_kind;
        $_SESSION['bootstrap']                     = 'bootstrap4' === $tt_theme_kind ? '4' : '3';
        if ($xoopsTpl) {
            $xoopsTpl->assign('bootstrap_version', $_SESSION['bootstrap']);
        }

        if ($xoTheme and $tt_use_bootstrap) {
            if ('bootstrap3' === $tt_bootstrap_color) {
                $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/bootstrap3/css/bootstrap.css');
            } elseif ('bootstrap4' === $tt_bootstrap_color) {
                $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/bootstrap4/css/bootstrap.css');
            } else {
                $c = explode('/', $tt_bootstrap_color);
                if ('bootstrap4' === $c[0]) {
                    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/bootstrap4/css/bootstrap.css');
                    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/' . $tt_bootstrap_color . '/bootstrap.min.css');
                } elseif ('bootstrap3' === $c[0]) {
                    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/bootstrap3/css/bootstrap.css');
                    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/' . $tt_bootstrap_color . '/bootstrap.min.css');
                }
            }
            $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/fix-bootstrap.css');
        }
    }

    // to add PSR-4 autoloader

    /**
     * @param $args
     */
    public static function eventCoreIncludeCommonEnd($args)
    {
        require __DIR__ . '/autoloader.php';
    }
}
