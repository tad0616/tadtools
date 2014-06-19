<?php
/*
$item[$id]['id']=$id;
$item[$id]['parent_id']=$home_title;
$item[$id]['title']=$title;
$item[$id]['url']=$url;
$item[$id]['open']=true;
$item[$id]['icon']="../../../css/zTreeStyle/img/diy/4.png";
$item[$id]['iconOpen']="../../../css/zTreeStyle/img/diy/1_open.png";
$item[$id]['iconClose']="../../../css/zTreeStyle/img/diy/1_close.png";
*/

include_once "tadtools_header.php";


class zTree{
  var $name;
  var $items;

  //建構函數
  function zTree($items=array(),$edit=false,$drag=false){
    $this->name=randStr();
    $this->items=$items;
    $this->edit=$edit;
    $this->drag=$drag;
  }

  //產生選單
  function render(){
    $opt="";
    foreach($this->items as $id => $item){
      $open=($item['open'])?", open:true":"";
      $url=!empty($item['url'])?", url:'{$item['url']}'":"";
      $icon=!empty($item['icon'])?", icon:'{$item['icon']}'":"";
      $iconOpen=!empty($item['iconOpen'])?", iconOpen:'{$item['iconOpen']}'":"";
      $iconClose=!empty($item['iconClose'])?", iconClose:'{$item['iconClose']}'":"";
      $opt.="{ id:$id, pId:{$item['parent_id']}, name:'{$item['title']}'{$url}{$open}{$icon}{$iconOpen}{$iconClose} },\n";
    }

    $zTree="";
    if(!defined("_TAD_HAVE_ZTREE")){
      $zTree="
      <link rel='StyleSheet' href='".TADTOOLS_URL."/zTree/css/zTreeStyle/zTreeStyle.css' type='text/css' />
      <script type='text/javascript' src='".TADTOOLS_URL."/zTree/js/jquery.ztree.core-3.5.js'></script>
      <script type='text/javascript' src='".TADTOOLS_URL."/zTree/js/jquery.ztree.excheck-3.5.js'></script>
      <script type='text/javascript' src='".TADTOOLS_URL."/zTree/js/jquery.ztree.exedit-3.5.js'></script>
      ";

      define("_TAD_HAVE_ZTREE",true);
    }
//die(var_export($opt));
    $opt=substr($opt,0,-2);

    $edit_setup="";
    if($this->edit){
      $edit_setup="
      edit: {
        enable: true,
        showRemoveBtn: false,
        showRenameBtn: false
      },
      ";
    }

    $drag_setup="";
    if($this->drag){
      $drag_setup="
      ,
      callback: {
        beforeDrag: beforeDrag,
        beforeDrop: beforeDrop
      }
      ";
    }

    $zTree.="
    <script type='text/javascript'>

    var setting = {
      $edit_setup
      data: {
        simpleData: {
          enable: true
        }
      }
      $drag_setup
    };

    var zNodes =[
      $opt
    ];


    function beforeDrag(treeId, treeNodes) {
      for (var i=0,l=treeNodes.length; i<l; i++) {
        if (treeNodes[i].drag === false) {
          return false;
        }
      }
      return true;
    }
    function beforeDrop(treeId, treeNodes, targetNode, moveType) {
      return targetNode ? targetNode.drop !== false : true;
    }

    function setCheck() {
      var zTree = $.fn.zTree.getZTreeObj('ztree_{$this->name}'),
      isCopy = $('#copy').attr('checked'),
      isMove = $('#move').attr('checked'),
      prev = $('#prev').attr('checked'),
      inner = $('#inner').attr('checked'),
      next = $('#next').attr('checked');
      zTree.setting.edit.drag.isCopy = isCopy;
      zTree.setting.edit.drag.isMove = isMove;
      showCode(1, ['setting.edit.drag.isCopy = ' + isCopy, 'setting.edit.drag.isMove = ' + isMove]);

      zTree.setting.edit.drag.prev = prev;
      zTree.setting.edit.drag.inner = inner;
      zTree.setting.edit.drag.next = next;
      showCode(2, ['setting.edit.drag.prev = ' + prev, 'setting.edit.drag.inner = ' + inner, 'setting.edit.drag.next = ' + next]);
    }
    function showCode(id, str) {
      var code = $('#code' + id);
      code.empty();
      for (var i=0, l=str.length; i<l; i++) {
        code.append('<li>'+str[i]+'</li>');
      }
    }

    $(document).ready(function(){
      $.fn.zTree.init($('#ztree_{$this->name}'), setting, zNodes);
      setCheck();
      $('#copy').bind('change', setCheck);
      $('#move').bind('change', setCheck);
      $('#prev').bind('change', setCheck);
      $('#inner').bind('change', setCheck);
      $('#next').bind('change', setCheck);
    });

    $(document).ready(function(){
      $.fn.zTree.init($('#ztree_{$this->name}'), setting, zNodes);
    });
    </script>
    <ul id='ztree_{$this->name}' class='ztree'></ul>

    ";
    return $zTree;
  }
}
?>
