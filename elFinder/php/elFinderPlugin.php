<?php
/**
 * elFinder Plugin Abstract
 *
 * @package elfinder
 * @author Naoki Sawada
 * @license New BSD
 */
class elFinderPlugin
{
    /**
     * This plugin's options
     *
     * @var array
     */
    protected $opts = [];

    /**
     * Get current volume's options
     *
     * @param object $volume
     * @return array options
     */
    protected function getCurrentOpts($volume)
    {
        $name = mb_substr(get_class($this), 14); // remove "elFinderPlugin"
        $opts = $this->opts;
        if (is_object($volume)) {
            $volOpts = $volume->getOptionsPlugin($name);
            if (is_array($volOpts)) {
                $opts = array_merge($opts, $volOpts);
            }
        }

        return $opts;
    }

    /**
     * Is enabled with options
     *
     * @param array $opts
     * @return bool
     */
    protected function iaEnabled($opts)
    {
        if (!$opts['enable']) {
            return false;
        }

        if (isset($opts['offDropWith']) && null !== $opts['offDropWith'] && isset($_REQUEST['dropWith'])) {
            $offDropWith = $opts['offDropWith'];
            $action = (int)$_REQUEST['dropWith'];
            if (!is_array($offDropWith)) {
                $offDropWith = [$offDropWith];
            }
            $res = true;
            foreach ($offDropWith as $key) {
                $key = (int)$key;
                if (0 === $key) {
                    if (0 === $action) {
                        $res = false;
                        break;
                    }
                } else {
                    if (($action & $key) === $key) {
                        $res = false;
                        break;
                    }
                }
            }
            if (!$res) {
                return false;
            }
        }

        return true;
    }
}
