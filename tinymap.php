<?php
require_once __DIR__ . '/tadtools_header.php';
require_once __DIR__ . '/jquery.php';

class tinymap
{
    public $id;
    public $x;
    public $y;
    public $title;
    public $zoom;
    public $show_jquery;
    public $option_arr;
    public $quotation;
    public $mark_option_arr;
    public $mark_quotation;
    public $gmap_key;

    public function __construct($id, $x, $y, $title, $zoom = 15, $show_jquery = true)
    {
        $this->id = $id;
        $this->x = $x;
        $this->y = $y;
        $this->zoom = $zoom;
        $this->title = $title;
        $this->show_jquery = $show_jquery;
    }

    public function set_key($key)
    {
        $this->gmap_key = $key;
    }

    public function set_option($key = '', $val = '', $quotation = true)
    {
        $this->quotation[$key] = $quotation;
        $this->option_arr[$key] = $val;
    }

    public function set_mark_option($key = '', $val = '', $quotation = true)
    {
        $this->mark_quotation[$key] = $quotation;
        $this->mark_option_arr[$key] = $val;
    }

    public function render()
    {
        $jquery = ($this->show_jquery) ? "<script src='" . XOOPS_URL . "/browse.php?Frameworks/jquery/jquery.js' type='text/javascript'></script>" : '';
        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/tinymap/jquery.tinyMap.js');
            $main = '';
        } else {
            $main = "
            $jquery
            <script type='text/javascript' src='" . TADTOOLS_URL . "/tinymap/jquery.tinyMap.js'></script>";
        }

        $option_arr = '';
        if (!empty($this->option_arr)) {
            foreach ($this->option_arr as $key => $value) {
                $option_arr .= $this->quotation[$key] ? "{$key}: '{$value}'," : "{$key}: {$value},";
            }
        }

        $mark_option_arr = '';
        if (!empty($this->mark_option_arr)) {
            foreach ($this->mark_option_arr as $key => $value) {
                $mark_option_arr[] = $this->mark_quotation[$key] ? "{$key}: '{$value}'\n" : "{$key}: {$value}\n";
            }
        }
        $mark_option_set = implode(',', $mark_option_arr);

        $center = '';
        $marker_addr = '';
        if (!empty($this->x) and !empty($this->y)) {
            $center = "'center': [{$this->x} , {$this->y}],";
            $marker_addr = "'addr': [{$this->x}, {$this->y}]";
        }

        $zoom = '';
        if (!empty($this->zoom)) {
            $zoom = "'zoom': {$this->zoom},";
        }

        $gmap_key_set = '';
        if (!empty($this->gmap_key)) {
            $gmap_key_set = "$.fn.tinyMapConfigure({
              'key': '{$this->gmap_key}'
            });";
        }

        $main .= "
        <script type='text/javascript'>
        var map = $('{$this->id}');

        {$gmap_key_set}
        map.tinyMap({
            {$center}
            {$zoom}
            {$option_arr}
            'marker': [{
              {$marker_addr}
            }]
        });
        </script>";

        return $main;
    }
}

/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/tinymap.php")){
redirect_header("http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1",3, _TAD_NEED_TADTOOLS);
}
require_once XOOPS_ROOT_PATH."/modules/tadtools/tinymap.php";
$tinymap=new tinymap($id, $x, $y, $title);
$tinymap->set_key('xxxx');
//$tinymap->set_option();
//$tinymap->set_mark_option();
$tinymap_code=$tinymap->render();
$xoopsTpl->assign('tinymap_code',$tinymap_code);
 */
