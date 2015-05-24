<?php
/*
$json="[
      { id:1, pId:0, name:"pNode 1", open:true},
      { id:11, pId:1, name:"pNode 11"}
      ]"

$sql = "select csn,of_csn,title from ".$xoopsDB->prefix("tad_gallery_cate")." order by sort";
$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
while(list($csn,$of_csn,$title)=$xoopsDB->fetchRow($result)){
  $title_arr[$csn]=$title;
  $cate_arr[$csn]=$of_csn;
  $url_arr[$csn]="cate.php?csn={$csn}";
}
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/ztree.php")){
  redirect_header("index.php",3, _MA_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/ztree.php";
$ztree=new ztree("album_tree","",$title_arr,$cate_arr,$url_arr);
$ztree_code=$ztree->render("11pt",true);
$xoopsTpl->assign('ztree_code',$ztree_code);

*/
include_once "tadtools_header.php";

class ztree{
  var $name;
  var $json;
  var $save_drag_file;
  var $save_sort_file;
  var $of_sn_col;
  var $sn_col;

  //建構函數
  function ztree($name="",$json="",$save_drag_file="",$save_sort_file="",$of_sn_col="",$sn_col=""){
    $this->name=$name;
    $this->json=$json;
    $this->save_drag_file=$save_drag_file;
    $this->save_sort_file=$save_sort_file;
    $this->of_sn_col=$of_sn_col;
    $this->sn_col=$sn_col;
  }

  //產生選單
  function render(){
    global $xoTheme;

    $jquery=get_jquery();

    if($xoTheme){
      $ztree="";
      $xoTheme->addStylesheet('modules/tadtools/ztree/css/zTreeStyle/zTreeStyle.css');
      $xoTheme->addScript('modules/tadtools/ztree/js/jquery.ztree.core-3.5.js');
      $xoTheme->addScript('modules/tadtools/ztree/js/jquery.ztree.excheck-3.5.js');
      if($this->save_drag_file){
        $xoTheme->addScript('modules/tadtools/ztree/js/jquery.ztree.exedit-3.5.js');
      }
    }else{

      $drag_js_file=($this->save_drag_file)?"<script type='text/javascript' src='".TADTOOLS_URL."/ztree/js/jquery.ztree.exedit-3.5.js'></script>":"";

      $ztree="
      {$jquery}
      <link rel='StyleSheet' href='".TADTOOLS_URL."/ztree/css/zTreeStyle/zTreeStyle.css' type='text/css' />
      <script type='text/javascript' src='".TADTOOLS_URL."/ztree/js/jquery.ztree.core-3.5.js'></script>
      <script type='text/javascript' src='".TADTOOLS_URL."/ztree/js/jquery.ztree.excheck-3.5.js'></script>
      $drag_js_file
      ";
    }

    if($this->save_drag_file){
      $onDrop="onDrop: onDrop,";
      $drag_code="
      function onDrop(event, treeId, treeNodes, targetNode, moveType) {
        var treeObj = $.fn.zTree.getZTreeObj('{$this->name}');
        var nodes = treeObj.transformToArray(treeObj.getNodes());
        //alert(nodes);

        for (var i=0,l=nodes.length; i<l; i++) {
          $.post('{$this->save_sort_file}', { {$this->sn_col}: nodes[0].id, sort: i },
            function(data) {
              $('#save_msg').html(data);
            });
        }


        //alert(treeNodes[0].id + ' - ' + treeNodes[0].pId + ' - ' + treeNodes[0].name + ' to ' + targetNode.id + ' - ' + targetNode.pId + ' - ' + targetNode.name);

        $.post('{$this->save_drag_file}', { {$this->of_sn_col}: treeNodes[0].pId, {$this->sn_col}: treeNodes[0].id },
          function(data) {
              $('#save_msg').html(data);
          });

        return true;
      }
      ";
    }else{
      $onDrop="";
      $drag_code="";
    }

    $ztree.="
    <SCRIPT type='text/javascript'>
      <!--
      var setting = {
        edit: {
          enable: true,
          showRemoveBtn: false,
          showRenameBtn: false
        },
        data: {
          simpleData: {
            enable: true
          }
        },
        callback: {
          {$onDrop}
          onClick: linkto
        }
      };

      var zNodes =[{$this->json}];

      function linkto(event, treeId, treeNode) {
        location.href = treeNode.url;
      }


      {$drag_code}

      $(document).ready(function(){
        $.fn.zTree.init($('#{$this->name}'), setting, zNodes);
      });
      //-->
    </SCRIPT>

    <ul id='{$this->name}' class='ztree'></ul>
    ";
    return $ztree;
  }
}
?>
