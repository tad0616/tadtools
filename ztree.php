<?php
/*

$path     = get_tad_link_cate_path($show_cate_sn);
$path_arr = array_keys($path);
$sql      = "select cate_sn,of_cate_sn,cate_title from " . $xoopsDB->prefix("tad_link_cate") . " order by cate_sort";
$result   = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());

$count  = tad_link_cate_count();
$data[] = "{ id:0, pId:0, name:'All', url:'index.php', target:'_self', open:true}";
while (list($cate_sn, $of_cate_sn, $cate_title) = $xoopsDB->fetchRow($result)) {
$font_style      = $show_cate_sn == $cate_sn ? ", font:{'background-color':'yellow', 'color':'black'}" : '';
$open            = in_array($cate_sn, $path_arr) ? 'true' : 'false';
$display_counter = empty($count[$cate_sn]) ? "" : " ({$count[$cate_sn]})";
$data[]          = "{ id:{$cate_sn}, pId:{$of_cate_sn}, name:'{$cate_title}{$display_counter}', url:'index.php?cate_sn={$cate_sn}', target:'_self', open:{$open} {$font_style}}";
}
$json = implode(',', $data);

if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/ztree.php")) {
redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH . "/modules/tadtools/ztree.php";
$ztree      = new ztree("link_tree", $json, "save_drag.php", "save_sort.php", "of_cate_sn", "cate_sn");
$ztree_code = $ztree->render();
$xoopsTpl->assign('ztree_code', $ztree_code);

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
    public function __construct($name = "", $json = "", $save_drag_file = "", $save_sort_file = "", $of_sn_col = "", $sn_col = "", $menu_name = "")
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
            if ($this->save_drag_file or $this->save_sort_file) {
                $xoTheme->addScript('modules/tadtools/ztree/js/jquery.ztree.exedit-3.5.js');
            }
        } else {

            $drag_js_file = ($this->save_drag_file or $this->save_sort_file) ? "<script type='text/javascript' src='" . TADTOOLS_URL . "/ztree/js/jquery.ztree.exedit-3.5.js'></script>" : "";

            $ztree = "
            {$jquery}
            <link rel='StyleSheet' href='" . TADTOOLS_URL . "/ztree/css/zTreeStyle/zTreeStyle.css' type='text/css' />
            <script type='text/javascript' src='" . TADTOOLS_URL . "/ztree/js/jquery.ztree.core-3.5.js'></script>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/ztree/js/jquery.ztree.excheck-3.5.js'></script>
            $drag_js_file
            ";
        }

        if ($this->save_drag_file or $this->save_sort_file) {
            $onDrop    = "onDrop: onDrop,";
            $drag_code = "
              function onDrop(event, treeId, treeNodes, targetNode, moveType) {
                var treeObj = $.fn.zTree.getZTreeObj('{$this->name}');
                var nodes = treeObj.transformToArray(treeObj.getNodes());
            ";

            if ($this->save_sort_file) {
                $drag_code .= "
                for (var i=0,l=nodes.length; i<l; i++) {
                  //alert(nodes[i].id+'='+i);
                  $.post('{$this->save_sort_file}', { {$this->sn_col}: nodes[i].id, sort: i },
                    function(data) {
                      $('#save_msg').html(data);
                    });
                }
              ";
            }

            if ($this->save_drag_file) {

                $drag_code .= "
                $.post('{$this->save_drag_file}', { {$this->of_sn_col}: treeNodes[0].pId, {$this->sn_col}: treeNodes[0].id },
                  function(data) {
                      $('#save_msg').html(data);
                  });
              ";
            }

            if ($this->save_drag_file or $this->save_sort_file) {

                $drag_code .= "
                return true;
              }
              ";
            }
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
                if (!check) alert("");
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
                // addDiyDom: addDiyDom,
                dblClickExpand: false,
                fontCss: getFont
              },
            ";
            $onClick = "onClick";
        } else {
            $mode = "
              view: {
                // addDiyDom: addDiyDom,
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

          function addDiyDom(treeId, treeNode) {
            var spaceWidth = 5;
            var switchObj = $('#' + treeNode.tId + '_switch'),
            icoObj = $('#' + treeNode.tId + '_ico');
            switchObj.remove();
            icoObj.before(switchObj);

            if (treeNode.level > 1) {
              var spaceStr = \"<span style='display: inline-block;width:\" + (spaceWidth * treeNode.level)+ \"px'></span>\";
              switchObj.before(spaceStr);
            }
            var spantxt=$('#' + treeNode.tId + '_span').html();
            if(spantxt.length>17){
              spantxt=spantxt.substring(0,17)+'...';
              $('#' + treeNode.tId + '_span').html(spantxt);
            }
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
