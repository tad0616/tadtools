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

class ztree
{
    public $name;
    public $json;
    public $save_drag_file;
    public $save_sort_file;
    public $of_sn_col;
    public $sn_col;
    public $menu_name;

    //建構函數
    public function ztree($name = "", $json = "", $save_drag_file = "", $save_sort_file = "", $of_sn_col = "", $sn_col = "", $menu_name = "")
    {
        $this->name           = $name;
        $this->json           = $json;
        $this->save_drag_file = $save_drag_file;
        $this->save_sort_file = $save_sort_file;
        $this->of_sn_col      = $of_sn_col;
        $this->sn_col         = $sn_col;
        $this->menu_name      = $menu_name;
    }

    //產生選單
    public function render($drop_menu = false)
    {
        global $xoTheme;

        $jquery = get_jquery();

        if ($xoTheme) {
            $ztree = "";
            $xoTheme->addStylesheet('modules/tadtools/ztree/css/zTreeStyle/zTreeStyle.css');
            $xoTheme->addScript('modules/tadtools/ztree/js/jquery.ztree.core-3.5.js');
            $xoTheme->addScript('modules/tadtools/ztree/js/jquery.ztree.excheck-3.5.js');
            if ($this->save_drag_file) {
                $xoTheme->addScript('modules/tadtools/ztree/js/jquery.ztree.exedit-3.5.js');
            }
        } else {

            $drag_js_file = ($this->save_drag_file) ? "<script type='text/javascript' src='" . TADTOOLS_URL . "/ztree/js/jquery.ztree.exedit-3.5.js'></script>" : "";

            $ztree = "
            {$jquery}
            <link rel='StyleSheet' href='" . TADTOOLS_URL . "/ztree/css/zTreeStyle/zTreeStyle.css' type='text/css' />
            <script type='text/javascript' src='" . TADTOOLS_URL . "/ztree/js/jquery.ztree.core-3.5.js'></script>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/ztree/js/jquery.ztree.excheck-3.5.js'></script>
            $drag_js_file
            ";
        }

        if ($this->save_drag_file) {
            $onDrop    = "onDrop: onDrop,";
            $drag_code = "
              function onDrop(event, treeId, treeNodes, targetNode, moveType) {
                var treeObj = $.fn.zTree.getZTreeObj('{$this->name}');
                var nodes = treeObj.transformToArray(treeObj.getNodes());

                for (var i=0,l=nodes.length; i<l; i++) {
                  //alert(nodes[i].id+'='+i);
                  $.post('{$this->save_sort_file}', { {$this->sn_col}: nodes[i].id, sort: i },
                    function(data) {
                      $('#save_msg').html(data);
                    });
                }

                $.post('{$this->save_drag_file}', { {$this->of_sn_col}: treeNodes[0].pId, {$this->sn_col}: treeNodes[0].id },
                  function(data) {
                      $('#save_msg').html(data);
                  });

                return true;
              }
              ";
        } else {
            $onDrop    = "";
            $drag_code = "";
        }

        $style            = "";
        $style2           = "";
        $drop_menu_script = "";
        if ($drop_menu) {
            $drop_menu_script = '
              function beforeClick(treeId, treeNode) {
                var check = (treeNode && !treeNode.isParent);
                if (!check) alert("請選擇");
                return check;
              }
              function onClick(e, treeId, treeNode) {
                var zTree = $.fn.zTree.getZTreeObj("' . $this->name . '"),
                nodes = zTree.getSelectedNodes(),
                v = "";
                display_v = "";
                nodes.sort(function compare(a,b){return a.id-b.id;});
                for (var i=0, l=nodes.length; i<l; i++) {
                  v += nodes[i].id + ",";
                  display_v += nodes[i].name + ",";
                }
                if (v.length > 0 ) v = v.substring(0, v.length-1);
                if (display_v.length > 0 ) display_v = display_v.substring(0, display_v.length-1);
                var tObj = $("#' . $this->menu_name . '_show");
                tObj.attr("value", display_v);
                var ttObj = $("#' . $this->menu_name . '");
                ttObj.attr("value", v);
              }

              function showMenu() {
                var tObj = $("#' . $this->menu_name . '_show");
                var menuOffset = $("#' . $this->menu_name . '_show").offset();
                $("#' . $this->name . '_menuContent").css({left:menuOffset.left + "px", top:menuOffset.top + tObj.outerHeight() + "px"}).slideDown("fast");

                $("body").bind("mousedown", onBodyDown);
              }
              function hideMenu() {
                $("#' . $this->name . '_menuContent").fadeOut("fast");
                $("body").unbind("mousedown", onBodyDown);
              }
              function onBodyDown(event) {
                if (!(event.target.id == "' . $this->name . '_menuContent" || $(event.target).parents("#' . $this->name . '_menuContent").length>0)) {
                  hideMenu();
                }
              }
            ';
            $style = "display:none; position: absolute;z-index: 1000; background: #ffffff;";
            $mode  = "
              view: {
                dblClickExpand: false,
                fontCss: getFont
              },
            ";
            $onClick = "onClick";
        } else {
            $mode = "
              view: {
                fontCss: getFont
              },
              edit: {
                enable: true,
                showRemoveBtn: false,
                showRenameBtn: false
              },
            ";
            $onClick = "linkto";
        }

        $ztree .= "
        <SCRIPT type='text/javascript'>
          <!--
          var setting = {
            {$mode}
            data: {
              simpleData: {
                enable: true
              }
            },

            callback: {
              {$onDrop}
              onClick: {$onClick}
            }
          };

          var zNodes =[{$this->json}];

          function linkto(event, treeId, treeNode) {
            location.href = treeNode.url;
          }

          function getFont(treeId, node) {
            return node.font ? node.font : {};
          }

          {$drop_menu_script}

          {$drag_code}

          $(document).ready(function(){
            $.fn.zTree.init($('#{$this->name}'), setting, zNodes);
          });
          //-->
        </SCRIPT>

        <div id='{$this->name}_menuContent' class='menuContent' style='$style'>
          <ul id='{$this->name}' class='ztree' style='$style2'></ul>
        </div>
        ";
        return $ztree;
    }
}
