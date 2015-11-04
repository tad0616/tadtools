<?php
include_once "tadtools_header.php";
include_once "jquery.php";

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

    public function tinymap($id, $x, $y, $title, $zoom = 15, $show_jquery = true)
    {
        $this->id          = $id;
        $this->x           = $x;
        $this->y           = $y;
        $this->zoom        = $zoom;
        $this->title       = $title;
        $this->show_jquery = $show_jquery;
    }

    public function set_key($key)
    {
        $this->gmap_key = $key;
    }

    public function set_option($key = '', $val = '', $quotation = true)
    {
        $this->quotation[$key]  = $quotation;
        $this->option_arr[$key] = $val;
    }

    public function set_mark_option($key = '', $val = '', $quotation = true)
    {
        $this->mark_quotation[$key]  = $quotation;
        $this->mark_option_arr[$key] = $val;
    }

    public function render()
    {
        $jquery = ($this->show_jquery) ? get_jquery() : "";
        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/tinymap/jquery.tinyMap.js');
            $main = '';
        } else {
            $main = "
            $jquery
            <script type='text/javascript' src='" . TADTOOLS_URL . "/tinymap/jquery.tinyMap.js'></script>";
        }

        $option_arr = "";
        if (!empty($this->option_arr)) {
            foreach ($this->option_arr as $key => $value) {
                $option_arr .= $this->quotation[$key] ? "{$key}: '{$value}'," : "{$key}: {$value},";
            }
        }

        $mark_option_arr = "";
        if (!empty($this->mark_option_arr)) {
            foreach ($this->mark_option_arr as $key => $value) {
                $mark_option_arr[] = $this->mark_quotation[$key] ? "{$key}: '{$value}'\n" : "{$key}: {$value}\n";
            }
        }
        $mark_option_set = implode(',', $mark_option_arr);

        $center      = "";
        $marker_addr = "";
        if (!empty($this->x) and !empty($this->y)) {
            $center      = "center: {x: '{$this->x}', y: '{$this->y}'},";
            $marker_addr = "addr: '{$this->x}, {$this->y}',";
        }

        $zoom = "";
        if (!empty($this->zoom)) {
            $zoom = "zoom: {$this->zoom},";
        }

        $main .= "
        $jquery
        <script type='text/javascript'>
         $(document).ready(function()
         {
           $('{$this->id}').tinyMap({
              {$option_arr}
              {$center}
              {$zoom}
              marker: [
                {
                  {$mark_option_set}
                }
              ]
          });

          // 執行 tinyMap 前可使用 $.tinyMapConfigure 進行 API 的設定。
          $.fn.tinyMapConfigure({
              // Google Maps API URL
              'api': '//maps.googleapis.com/maps/api/js',
              // Google Maps API Version
              'v': '3.21',
              // GPS Sensor，預設 false
              'sensor': true|false,
              // Google Maps API Key，預設 null
              'key': '{$this->gmap_key}'
              // 使用的地圖語言
              // 'language': 'zh‐TW'
              // 載入的函式庫名稱，預設 null
              // 'libraries': 'adsense,drawing,geometry...',
              // 使用個人化的地圖，預設 false
              // 'signed_in': true|false,
              // MarkerClustererPlus.js 路徑
              // 預設 '//google‐maps‐utility‐library‐v3.googlecode.com/svn/trunk/markerclustererplus/src/markerclusterer_packed.js'
              // 建議下載至自有主機，避免讀取延遲造成無法使用。
              // 'clusterer': '/path/to/markerclusterer.js'
              // MarkerWithLabel.js 路徑
              // 預設 '//google‐maps‐utility‐library‐v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel_packed.js'
              // 建議下載至自有主機，避免讀取延遲造成無法使用。
              // 'withLabel': '/path/to/markerwithlabel.js'
          });
         })
        </script>";

        return $main;
    }
}

/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/tinymap.php")){
redirect_header("http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1",3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/tinymap.php";
$tinymap=new tinymap($id, $x, $y, $title);
$tinymap->set_key('xxxx');
//$tinymap->set_option();
//$tinymap->set_mark_option();
$tinymap_code=$tinymap->render();
$xoopsTpl->assign('tinymap_code',$tinymap_code);
 */
