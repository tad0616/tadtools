<?php
include_once "tadtools_header.php";
include_once "jquery.php";
get_bootstrap();



//解決 basename 抓不到中文檔名的問題
if(!function_exists('get_basename')){
  function get_basename($filename){
    $filename=preg_replace('/^.+[\\\\\\/]/', '', $filename);
    $filename=rtrim($filename, '/');
    return $filename;
  }
}

//載入 bootstrap
function get_bootstrap(){
  global $xoopsConfig,$xoopsDB,$xoTheme;
  $theme_set=$xoopsConfig['theme_set'];

  $sql="select `tt_use_bootstrap`,`tt_bootstrap_color`,`tt_theme_kind` from `".$xoopsDB->prefix("tadtools_setup")."`  where `tt_theme`='{$theme_set}'";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  list($tt_use_bootstrap,$tt_bootstrap_color,$tt_theme_kind)=$xoopsDB->fetchRow($result);

  $_SESSION['theme_kind']=$tt_theme_kind;
  if(strpos($tt_bootstrap_color, 'bootstrap3')!==false){
    $_SESSION[$theme_set]['bootstrap_version']='bootstrap3';
    $_SESSION['bootstrap']='3';
    $bootstrap='bootstrap3';
  }else{
    $_SESSION[$theme_set]['bootstrap_version']='bootstrap';
    $_SESSION['bootstrap']='2';
    $bootstrap='bootstrap';
  }

  if($xoTheme){
    if($tt_bootstrap_color=="bootstrap3"){
      $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/bootstrap3/css/bootstrap.css');
      //if($tpl)$tpl=str_replace(".html", "{$b3}.html", $tpl);
    }elseif($tt_bootstrap_color=="bootstrap"){
      $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/bootstrap/css/bootstrap.css');
      $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/bootstrap/css/bootstrap-responsive.css');
    }else{
      $c=explode('/',$tt_bootstrap_color);
      if($c[0]=="bootstrap3"){
        //$xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/bootstrap3/css/bootstrap.css');
        $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/'.$tt_bootstrap_color.'/bootstrap.min.css');
        //if($tpl)$tpl=str_replace(".html", "{$b3}.html", $tpl);
      }elseif($c[0]=="bootstrap"){
        $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/bootstrap/css/bootstrap.css');
        $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/bootstrap/css/bootstrap-responsive.css');
        $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/'.$tt_bootstrap_color.'/bootstrap.min.css');
      }

    }
    $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/css/fix-bootstrap.css');
  }
  return $bootstrap;
}




//自動取得網址
if(!function_exists('get_xoops_url')){
  function get_xoops_url(){
    $u=parse_url("http://".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
    if(!empty($u['path']) and preg_match('/\/modules/',$u['path'])){
      $XMUrl=explode("/modules",$u['path']);
    }elseif(!empty($u['path']) and preg_match('/\/themes/',$u['path'])){
      $XMUrl=explode("/themes",$u['path']);
    }elseif(!empty($u['path']) and preg_match('/.php/',$u['path'])){
      $XMUrl[0]=dirname($u['path']);
    }elseif(!empty($u['path'])){
      $XMUrl[0]=$u['path'];
    }else{
      $XMUrl[0]="";
    }

    $my_url=str_replace('\\','/',$XMUrl['0']);
    if(substr($my_url,-1)=='/')$my_url=substr($my_url,0,-1);
    $url="{$u['scheme']}://{$u['host']}{$my_url}";
    return $url;
  }
}

//自動取得實體位置
if(!function_exists('get_xoops_path')){
  function get_xoops_path(){

    if(preg_match('/\/modules/',$_SERVER["SCRIPT_FILENAME"])){
      $XMPath=explode("/modules",$_SERVER["SCRIPT_FILENAME"]);
      $root_path=$XMPath[0];
    }elseif(preg_match('/\/themes/',$_SERVER["SCRIPT_FILENAME"])){
      $XMPath=explode("/themes",$_SERVER["SCRIPT_FILENAME"]);
      $root_path=$XMPath[0];
    }else{
      $root_path=dirname($_SERVER["SCRIPT_FILENAME"]);
    }
    return $root_path;
  }
}

//自動轉連結
if(!function_exists('autolink')){

  function autolink( &$text, $target='_blank', $nofollow=true )
  {
    // grab anything that looks like a URL...
    $urls  =  _autolink_find_URLS( $text );
    if( !empty($urls) ) // i.e. there were some URLS found in the text
    {
      array_walk( $urls, '_autolink_create_html_tags', array('target'=>$target, 'nofollow'=>$nofollow) );
      $text  =  strtr( $text, $urls );
    }
    return $text;
  }

  function _autolink_find_URLS( $text )
  {
    // build the patterns
    $scheme         =       '(http:\/\/|https:\/\/)';
    $www            =       'www\.';
    $ip             =       '\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}';
    $subdomain      =       '[-a-z0-9_]+\.';
    $name           =       '[a-z][-a-z0-9]+\.';
    $tld            =       '[a-z]+(\.[a-z]{2,2})?';
    $the_rest       =       '\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1}';
    $pattern        =       "$scheme?(?(1)($ip|($subdomain)?$name$tld)|($www$name$tld))$the_rest";

    $pattern        =       '/'.$pattern.'/is';
    $c              =       preg_match_all( $pattern, $text, $m );
    unset( $text, $scheme, $www, $ip, $subdomain, $name, $tld, $the_rest, $pattern );
    if( $c )
    {
      return( array_flip($m[0]) );
    }
    return( array() );
  }

  function _autolink_create_html_tags( &$value, $key, $other=null )
  {
    $target = $nofollow = null;
    if( is_array($other) )
    {
      $target      =  ( $other['target']   ? " target=\"$other[target]\"" : null );
      // see: http://www.google.com/googleblog/2005/01/preventing-comment-spam.html
      $nofollow    =  ( $other['nofollow'] ? ' rel="nofollow"'            : null );
    }
    $value = "<a href=\"$key\"$target$nofollow>$key</a>";
  }
}


//推文工具
if(!function_exists('push_url')){
  function push_url($enable=1,$css="width:auto;margin:10px;float:right;"){
    global $xoopsConfig;
    if(!$enable){
      return;
      }
    $jquery=get_jquery();

    $main="
    <link rel='stylesheet' href='".XOOPS_URL."/modules/tadtools/social-likes/social-likes_birman.css'>
    $jquery
    <script src='".XOOPS_URL."/modules/tadtools/social-likes/social-likes.min.js'></script>
    <script type='text/javascript'>
    $().ready(function() {
      $('.social-likes').socialLikes({
        url: 'http://{$_SERVER["HTTP_HOST"]}{$_SERVER['REQUEST_URI']}',
        title: '{$xoopsConfig['sitename']}',
        counters: true,
        singleTitle: 'Share it!'
      });
    });
    </script>
    <ul class='social-likes'>
      <li class='facebook' title='Share link on Facebook'>Facebook</li>
      <li class='twitter' title='Share link on Twitter'>Twitter</li>
      <li class='plusone' title='Share link on Google+'>Google+</li>
      <div class='pinterest' title='Share image on Pinterest' data-media=''>Pinterest</div>
    </ul>
    ";

    return $main;
  }
}


//facebook的留言
if(!function_exists('facebook_comments')){
  function facebook_comments($facebook_comments_width=600,$modules='',$page='',$col_name='',$col_sn=''){
    if(empty($facebook_comments_width))return;
    $url=(empty($page) and empty($col_name) and empty($col_sn))?"http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}":XOOPS_URL."/modules/{$modules}/{$page}?{$col_name}={$col_sn}";

    $main="
    <div id='fb-root'></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = '//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=199288920104939';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <div class='fb-comments' data-href='{$url}' data-num-posts='10' data-width='100%'></div>
    ";

    return $main;

  }
}



//產生QR Code
if(!function_exists('mk_qrcode')){
  function mk_qrcode($url){
    $imgurl=mk_qrcode_name($url);
    mk_dir(XOOPS_ROOT_PATH."/uploads/qrcode");
    if(!file_exists(XOOPS_ROOT_PATH."/uploads/qrcode/{$imgurl}.gif")){
      include_once "qrcode/qrcode.php";
      $url=chk_qrcode_url($url);
      $a = new QR("{$_SERVER['HTTP_HOST']}{$url}");
      //die(XOOPS_ROOT_PATH."/uploads/qrcode/{$imgurl}.gif");
      file_put_contents(XOOPS_ROOT_PATH."/uploads/qrcode/{$imgurl}.gif",$a->image(2));
    }
  }
}

//產生QR Code檔案的名稱
if(!function_exists('mk_qrcode_name')){
  function mk_qrcode_name($url=''){
    $url=chk_qrcode_url($url);
    $imgurl=str_replace(XOOPS_URL,'',$url);
    $imgurl=str_replace('modules/','',$imgurl);
    $imgurl=str_replace('/','_',$imgurl);
    $imgurl=str_replace('.','_',$imgurl);
    $imgurl=str_replace('?','_',$imgurl);
    $imgurl=str_replace('&','_',$imgurl);
    $imgurl=str_replace('=','_',$imgurl);
    return $imgurl;
  }
}


if(!function_exists('chk_qrcode_url')){
  function chk_qrcode_url($url){
    $var=explode("?",$url);
    if(empty($var[1]))return $url;
    $vars=explode("&",$var[1]);
    foreach($vars as $v){
      list($key,$val)=explode("=",$v);
      if($key=="loadtime")continue;
      $all[$key]=$val;
    }

    $var2="?";
    foreach($all as $key=>$val){
      $varall[]="{$key}={$val}";
    }

    $var2=implode("&",$varall);
    $url="{$var[0]}?{$var2}";
    return $url;
  }
}


//單選回復原始資料函數
if(!function_exists('chk')){
  function chk($DBV=null,$NEED_V="",$defaul="",$return="checked='checked'"){
    if($DBV==$NEED_V){
      return $return;
    }elseif(empty($DBV) && $defaul=='1'){
      return $return;
    }
    return "";
  }
}

//複選回復原始資料函數
if(!function_exists('chk2')){
  function chk2($default_array="",$NEED_V="",$default=0){
    if(in_array($NEED_V,$default_array)){
      return "checked";
    }elseif(empty($default_array) && $default=='1'){
      return "checked";
    }

    return "";
  }
}

//細部權限判斷
if(!function_exists('power_chk')){
  function power_chk($perm_name="",$sn=""){
    global $xoopsUser,$xoopsModule;

    //取得目前使用者的群組編號
    if($xoopsUser) {
      $groups = $xoopsUser->getGroups();
    }else{
      $groups = XOOPS_GROUP_ANONYMOUS;
    }

    //取得模組編號
    $module_id = $xoopsModule->getVar('mid');
    //取得群組權限功能
    $gperm_handler =& xoops_gethandler('groupperm');

    //權限項目編號
    $perm_itemid = intval($sn);
    //依據該群組是否對該權限項目有使用權之判斷 ，做不同之處理
    if($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
      return true;
    }
    return false;
  }
}


//把字串換成群組
if(!function_exists('txt_to_group_name')){
  function txt_to_group_name($enable_group="",$default_txt="",$syb="<br />"){
    $groups_array=get_all_groups();
    if(empty($enable_group)){
      $g_txt_all=$default_txt;
    }else{
      $gs=explode(",",$enable_group);
      $g_txt="";
      foreach($gs as $gid){
        $g_txt[]=$groups_array[$gid];
      }
      $g_txt_all=implode($syb,$g_txt);
    }
    return $g_txt_all;
  }
}

//取得所有群組
if(!function_exists('get_all_groups')){
  function get_all_groups(){
    global $xoopsDB;
    $sql = "select groupid,name from ".$xoopsDB->prefix("groups")."";
    $result = $xoopsDB->query($sql);
    while(list($groupid,$name)=$xoopsDB->fetchRow($result)){
      $data[$groupid]=$name;
    }
    return $data;
  }
}




//輸出為UTF8
if(!function_exists("to_utf8")){
  function to_utf8($buffer=""){
    if(_CHARSET=="UTF-8"){
      return $buffer;
    }else{
      $buffer=(!function_exists("mb_convert_encoding"))?iconv("Big5","UTF-8",$buffer):mb_convert_encoding($buffer,"UTF-8","Big5");
      return $buffer;
    }
  }
}



//判斷字串是否為utf8
if(!function_exists("is_utf8")){
  function  is_utf8($str)  {
    $i=0;
    $len  =  strlen($str);

    for($i=0;$i<$len;$i++)  {
      $sbit  =  ord(substr($str,$i,1));
      if($sbit  <  128)  {
        //本字節為英文字符，不與理會
      }elseif($sbit  >  191  &&  $sbit  <  224)  {
        //第一字節為落於192~223的utf8的中文字(表示該中文為由2個字節所組成utf8中文字)，找下一個中文字
        $i++;
      }elseif($sbit  >  223  &&  $sbit  <  240)  {
        //第一字節為落於223~239的utf8的中文字(表示該中文為由3個字節所組成的utf8中文字)，找下一個中文字
        $i+=2;
      }elseif($sbit  >  239  &&  $sbit  <  248)  {
        //第一字節為落於240~247的utf8的中文字(表示該中文為由4個字節所組成的utf8中文字)，找下一個中文字
        $i+=3;
      }else{
        //第一字節為非的utf8的中文字
        return  0;
      }
    }
    //檢查完整個字串都沒問體，代表這個字串是utf8中文字
    return  1;
  }
}


//轉換編碼 （_CHARSET 在後面時，$OS2Web 為 true，預設）
if(!function_exists('auto_charset')){
  function auto_charset($str='',$OS_or_Web='web'){
    $os_charset=(PATH_SEPARATOR==':')?"UTF-8":"Big5";
    if($os_charset != _CHARSET){
      $str=$OS_or_Web=='web'?iconv($os_charset, _CHARSET, $str):iconv(_CHARSET, $os_charset, $str);
    }
    return $str;
  }
}

//亂數字串
if(!function_exists("randStr")){
  function randStr($len=6,$format='ALL') {
    switch($format) {
      case 'ALL':
        $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; break;
      case 'CHAR':
        $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; break;
      case 'NUMBER':
      $chars='0123456789'; break;
      default :
        $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      break;
    }

    mt_srand((double)microtime()*1000000*getmypid());
    $password="";
    while(strlen($password)<$len)
      $password.=substr($chars,(mt_rand()%strlen($chars)),1);
    return $password;
  }
}


//建立目錄
if(!function_exists('mk_dir')){
  function mk_dir($dir=""){
    //若無目錄名稱秀出警告訊息
    if(empty($dir))redirect_header("index.php", 3,_TAD_NO_DIRNAME);
    //若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
      umask(000);
      //若建立失敗秀出警告訊息
      if(!mkdir($dir, 0777)){
        redirect_header("index.php", 3,sprintf(_TAD_MKDIR_ERROR,$dir));
      }
    }
  }
}

//刪除整個目錄
if(!function_exists('rrmdir')){
  function rrmdir($path)
  {
    return is_file($path)?
      @unlink($path):
      array_map('rrmdir',glob($path.'/*'))==@rmdir($path)
    ;
  }
}
//取得分頁工具
if(!function_exists('getPageBar')){
  function getPageBar($sql="",$show_num=20,$page_list=10,$to_page="",$url_other="",$bootstrap=""){
    global $xoopsDB;
    //die('PHP_SELF:'.$_SERVER['PHP_SELF']);
    if(empty($show_num))$show_num=20;
    if(empty($page_list))$page_list=10;
    if(empty($bootstrap))$bootstrap=$_SESSION['bootstrap'];
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],10, mysql_error()."<br>$sql");
    $total=$xoopsDB->getRowsNum($result);

    $navbar = new PageBar($total, $show_num, $page_list);

    if(!empty($to_page)){
      $navbar->set_to_page($to_page);
    }

    if(!empty($url_other)){
      $navbar->set_url_other($url_other);
    }

    if($bootstrap=='3'){
      $mybar = $navbar->makeBootStrap3Bar();
      $main['bar']= "
      <div class='row'>
        <div class='col-md-12'>
          <div class='text-center'>
            <nav>
              <ul class='pagination'>
                {$mybar['left']}
                {$mybar['center']}
                {$mybar['right']}
              </ul>
            </nav>
          </div>
        </div>
      </div>
      ";
    }else{
      $mybar = $navbar->makeBar();
      $main['bar']= "<div style='text-align:center;margin:4px;'>{$mybar['left']}{$mybar['center']}{$mybar['right']}<div style='zoom:1;clear:both;'></div></div>
      ";
    }

    $main['sql']=$sql.$mybar['sql'];
    $main['total']=$total;

    return $main;
  }
}


//分頁物件
if(!class_exists('PageBar')){
  class   PageBar{
    // 目前所在頁碼
    var $current;
    // 所有的資料數量 (rows)
    var $total;
    // 每頁顯示幾筆資料
    var $limit;
    // 目前在第幾層的頁數選項？
    var $pCurrent;
    // 總共分成幾頁？
    var $pTotal;
    // 每一層最多有幾個頁數選項可供選擇，如：3 = {[1][2][3]}
    var $pLimit;
    var $prev;
    var $next;
    var $prev2;
    var $next2;
    var $prev_layer = ' ';
    var $next_layer = ' ';
    var $first;
    var $last;
    var $first2;
    var $last2;
    var $bottons = array();
    // 要使用的 URL 頁數參數名？
    var $url_page = "g2p";
    // 會使用到的 URL 變數名，給 process_query() 過濾用的。
    var $used_query = array();
    // 目前頁數顏色
    var $act_color = "#990000";
    var $query_str; // 存放 URL 參數列
    //指定頁面
    var $to_page;
    //其他連結參數
    var $url_other;

    function PageBar($total, $limit, $page_limit){
      $mydirname = basename( dirname( __FILE__ ) ) ;
      $this->prev = "<img src='".TADTOOLS_URL."/images/1leftarrow.png' alt='"._TAD_BACK_PAGE."' align='absmiddle' hspace=3>";
      $this->next = "<img src='".TADTOOLS_URL."/images/1rightarrow.png' alt='"._TAD_NEXT_PAGE."' align='absmiddle' hspace=3>";
      $this->first = "<img src='".TADTOOLS_URL."/images/2leftarrow.png' alt='"._TAD_FIRST_PAGE."' align='absmiddle' hspace=3>";
      $this->last = "<img src='".TADTOOLS_URL."/images/2rightarrow.png' alt='"._TAD_LAST_PAGE."' align='absmiddle' hspace=3>";
      $this->prev2 = "<img src='".TADTOOLS_URL."/images/1leftarrow_g.png' alt='"._TAD_BACK_PAGE."' align='absmiddle' hspace=3>";
      $this->next2 = "<img src='".TADTOOLS_URL."/images/1rightarrow_g.png' alt='"._TAD_NEXT_PAGE."' align='absmiddle' hspace=3>";
      $this->first2 = "<img src='".TADTOOLS_URL."/images/2leftarrow_g.png' alt='"._TAD_FIRST_PAGE."' align='absmiddle' hspace=3>";
      $this->last2 = "<img src='".TADTOOLS_URL."/images/2rightarrow_g.png' alt='"._TAD_LAST_PAGE."' align='absmiddle' hspace=3>";
      $this->to_page = $_SERVER['PHP_SELF'];
      $this->limit = $limit;
      $this->total = $total;
      $this->pLimit = $page_limit;
    }

    function init(){
      $this->used_query = array($this->url_page);
      $this->query_str = $this->processQuery($this->used_query);
      $this->glue = ($this->query_str == "")?'?':'&';

      $this->current = (isset($_GET[$this->url_page]))? intval($_GET[$this->url_page]): 1;
      if($this->current < 1)$this->current=1;
      $this->pTotal = ceil($this->total / $this->limit);
      $this->pCurrent = ceil($this->current / $this->pLimit);
    }

    //初始設定
    function set($active_color = "none", $buttons = "none"){
      if ($active_color != "none"){
        $this->act_color = $active_color;
      }

      if ($buttons != "none"){
        $this->buttons = $buttons;
        $this->prev = $this->buttons['prev'];
        $this->next = $this->buttons['next'];
        $this->prev_layer = $this->buttons['prev_layer'];
        $this->next_layer = $this->buttons['next_layer'];
        $this->first = $this->buttons['first'];
        $this->last = $this->buttons['last'];
        $this->prev2 = $this->buttons['prev'];
        $this->next2 = $this->buttons['next'];
        $this->first2 = $this->buttons['first'];
        $this->last2 = $this->buttons['last'];
      }
    }

    // 處理 URL 的參數，過濾會使用到的變數名稱
    function processQuery($used_query){
      // 將 URL 字串分離成二維陣列
      $QUERY_STRING=htmlspecialchars($_SERVER['QUERY_STRING']);
      $vars = explode("&", $QUERY_STRING);
      //die(var_export($vars));
      for($i = 0; $i < count($vars); $i++){
        if(substr($vars[$i],0,7)=="amp;g2p")continue;
        //echo substr($vars[$i],0,7)."<br>";
        $var[$i] = explode("=", $vars[$i]);
      }

      // 過濾要使用的 URL 變數名稱
      for($i = 0; $i < count($var); $i++){
        for($j = 0; $j < count($used_query); $j++){
          if (isset($var[$i][0]) && $var[$i][0] == $used_query[$j]) $var[$i] = array();
        }
      }

      $vars="";
      // 合併變數名與變數值
      for($i = 0; $i < count($var); $i++){
        $vars[$i] = implode("=", $var[$i]);
      }

      // 合併為一完整的 URL 字串
      $processed_query = "";
      for($i = 0; $i < count($vars); $i++){
        $glue = ($processed_query == "")?'?':'&';
        // 開頭第一個是 '?' 其餘的才是 '&'
        if ($vars[$i] != "") $processed_query .= $glue.$vars[$i];
      }
      return $processed_query;
    }

    // 製作 sql 的 query 字串 (LIMIT)
    function sqlQuery(){
      $row_start = ($this->current * $this->limit) - $this->limit;
      $sql_query = " LIMIT {$row_start}, {$this->limit}";
      return $sql_query;
    }


    function set_to_page($page=""){
      $this->to_page=$page;
    }

    function set_url_other($other=""){
      $this->url_other=$other;
    }


    // 製作 bar
    function makeBar($url_page = "none"){
      if ($url_page != "none"){
        $this->url_page = $url_page;
      }
      $this->init();

      // 取得目前時間
      $loadtime = $this->url_other;

      // 取得目前頁框(層)的第一個頁數啟始值，如 6 7 8 9 10 = 6
      $i = ($this->pCurrent * $this->pLimit) - ($this->pLimit - 1);

      $bar_center = "";
      while ($i <= $this->pTotal && $i <= ($this->pCurrent * $this->pLimit)){
        if ($i == $this->current){
          $bar_center = "{$bar_center}<span color='{$this->act_color}' style='border:1px solid #660000;background-color:#660000;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>&nbsp;{$i}&nbsp;</span>";
        }else{
          $bar_center .= " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='{$i}'  style='border:1px solid silver;background-color:white;color:#666666;text-align:center;padding:3px;margin:1px;line-height:100%;'>&nbsp;{$i}&nbsp;</a> ";
        }
        $i++;
      }
      $bar_center = $bar_center . "";

      // 往前跳一頁
      if ($this->current <= 1){
        //$bar_left=$bar_first="";
        $bar_left = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->prev2}</span>";
        $bar_first = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->first2}</span>";
      } else{
        $i = $this->current-1;
        $bar_left = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='"._TAD_BACK_PAGE."' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->prev}</a> ";
        $bar_first = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}=1{$loadtime}' title='"._TAD_FIRST_PAGE."' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->first}</a> ";
      }

      // 往後跳一頁
      if ($this->current >= $this->pTotal){
        //$bar_right=$bar_last="";
        $bar_right = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->next2}</span>";
        $bar_last = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->last2}</span>";
      } else{
        $i = $this->current + 1;
        $bar_right = "<a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='"._TAD_NEXT_PAGE."' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->next}</a> ";
        $bar_last = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$this->pTotal}{$loadtime}' title='"._TAD_LAST_PAGE."' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->last}</a> ";
      }

      // 往前跳一整個頁框(層)
      if (($this->current - $this->pLimit) < 1){
        $bar_l = " {$this->prev_layer} ";
      } else{
        $i = $this->current - $this->pLimit;
        $bar_l = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='".sprintf($this->pLimit,_TAD_GO_BACK_PAGE)."' style=''>{$this->prev_layer}</a> ";
      }

      //往後跳一整個頁框(層)
      if (($this->current + $this->pLimit) > $this->pTotal){
        $bar_r = " {$this->next_layer} ";
      } else{
        $i = $this->current + $this->pLimit;
        $bar_r = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='".sprintf($this->pLimit,_TAD_GO_NEXT_PAGE)."' style=''>{$this->next_layer}</a> ";
      }

      $page_bar['center'] = $bar_center;
      $page_bar['left'] = $bar_first . $bar_l . $bar_left;
      $page_bar['right'] = $bar_right . $bar_r . $bar_last;
      $page_bar['current'] = $this->current;
      $page_bar['total'] = $this->pTotal;
      $page_bar['sql'] = $this->sqlQuery();
      return $page_bar;
    }


    // 製作 bar
    function makeBootStrap3Bar($url_page = "none"){
      if ($url_page != "none"){
        $this->url_page = $url_page;
      }
      $this->init();

      // 取得目前時間
      $loadtime = $this->url_other;

      // 取得目前頁框(層)的第一個頁數啟始值，如 6 7 8 9 10 = 6
      $i = ($this->pCurrent * $this->pLimit) - ($this->pLimit - 1);

      $bar_center = "";
      while ($i <= $this->pTotal && $i <= ($this->pCurrent * $this->pLimit)){
        if ($i == $this->current){
          $bar_center = "
          {$bar_center}
          <li class='active'>
            <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='{$i}'>{$i}<span class='sr-only'>(current)</span></a>
          </li>";
        }else{
          $bar_center .= "
          <li>
            <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='{$i}'>{$i}</a>
          </li>";
        }
        $i++;
      }
      $bar_center = $bar_center . "";

      // 往前跳一頁
      if ($this->current <= 1){
        //$bar_left=$bar_first="";
        $bar_left = "<li class='disabled'><a href='#'>&lsaquo;</a></li>";
        $bar_first = "<li class='disabled'><a href='#'>&laquo;</a></li>";
      } else{
        $i = $this->current-1;
        $bar_left = "<li><a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='"._TAD_BACK_PAGE."'>&lsaquo;</a></li>";
        $bar_first = "<li><a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}=1{$loadtime}' title='"._TAD_FIRST_PAGE."' >&laquo;</a></li>";
      }

      // 往後跳一頁
      if ($this->current >= $this->pTotal){
        //$bar_right=$bar_last="";
        $bar_right = "<li class='disabled'><a href='#'>&rsaquo;</a></li>";
        $bar_last = "<li class='disabled'><a href='#'>&raquo;</a></li>";
      } else{
        $i = $this->current + 1;
        $bar_right = "<li><a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='"._TAD_NEXT_PAGE."'>&rsaquo;</a></li>";
        $bar_last = "<li><a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$this->pTotal}{$loadtime}' title='"._TAD_LAST_PAGE."' >&raquo;</a></li>";
      }

      // 往前跳一整個頁框(層)
      if (($this->current - $this->pLimit) < 1){
        $bar_l = "";
      } else{
        $i = $this->current - $this->pLimit;
        $bar_l = "";
      }

      //往後跳一整個頁框(層)
      if (($this->current + $this->pLimit) > $this->pTotal){
        $bar_r = "";
      } else{
        $i = $this->current + $this->pLimit;
        $bar_r = "";
      }

      $page_bar['center'] = $bar_center;
      $page_bar['left'] = $bar_first . $bar_l . $bar_left;
      $page_bar['right'] = $bar_right . $bar_r . $bar_last;
      $page_bar['current'] = $this->current;
      $page_bar['total'] = $this->pTotal;
      $page_bar['sql'] = $this->sqlQuery();
      return $page_bar;
    }
  }
}


?>