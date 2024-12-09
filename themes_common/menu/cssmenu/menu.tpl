<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/tadtools/themes_common/menu/cssmenu/styles.css" />
<script src="<{$xoops_url}>/modules/tadtools/themes_common/menu/cssmenu/menu_jquery.js"></script>
<style type="text/css">
  #cssmenu{
    background: <{$navbar_bg_top|default:''}>;
    /* background: transparent; */
  }
  #cssmenu > ul{
    background: <{$navbar_bg_top|default:''}>;
    /* background: transparent; */
  }
  #cssmenu ul ul li a {
    background: <{$navbar_bg_bottom|default:''}>;
    color:<{$navbar_color|default:''}>;
    /* color: #6e6265; */
    /* background: #fff; */
  }
  #cssmenu ul ul li:hover > a {
    background: <{$navbar_hover|default:''}>;
    color:<{$navbar_color_hover|default:''}>;
    /* color: #8c9195; */
    /* background: #f6f6f6; */
  }

  #cssmenu > ul > li > a {
    color:<{$navbar_color|default:''}>;
    /* color: #ffffff; */
  }

  #cssmenu > ul > li:hover > a {
    color:<{$navbar_color_hover|default:''}>;
    /* color: #ffffff; */
  }
</style>
<div id="cssmenu">
    <ul>
        <{foreach from=$menu_var item=menu}>
        <li <{if $menu.submenu|default:false}>class='has-sub'<{/if}>>
            <a href='<{$menu.url}>' target="<{$menu.target}>">
            <span><span class="fa <{$menu.icon}>" <{$navbar_icon|default:''}>></span> <{$menu.title}></span>
            </a>
            <{if $menu.submenu|default:false}>
            <{if $menu.submenu=='1'}>
                <{include file="$xoops_rootpath/modules/tadtools/themes_common/menu/cssmenu/login3.tpl"}>
            <{else}>
                <ul>
                <{foreach from=$menu.submenu item=menu2}>
                    <{if $menu2.title == 'separator'}>
                    <li role="separator" class="divider"></li>
                    <{else}>
                    <li <{if $menu2.submenu|default:false}>class='has-sub'<{/if}>>
                        <a href='<{$menu2.url}>' target="<{$menu2.target}>">
                        <span><span class="fa <{$menu2.icon}>"></span> <{$menu2.title}></span>
                        </a>
                        <{if $menu2.submenu|default:false}>
                        <ul>
                            <{foreach from=$menu2.submenu item=menu3}>
                            <li>
                                <a href='<{$menu3.url}>' target="<{$menu3.target}>">
                                <span><span class="fa <{$menu3.icon}>"></span> <{$menu3.title}></span>
                                </a>
                            </li>
                            <{/foreach}>
                        </ul>
                        <{/if}>
                    </li>
                    <{/if}>
                <{/foreach}>
                </ul>
            <{/if}>
            <{/if}>
        </li>
        <{/foreach}>

        <{if !$xoops_isuser}>
        <li>
            <!-- 登入 -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <{$smarty.const._TAD_TF_USER_LOGIN}> <span class="caret"></span>
            </a>
            <{assign var="bootstrap" value=$smarty.session.bootstrap|default:$session.bootstrap}>
            <{if $bootstrap==5}>
              <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_my.tpl"}>
            <{elseif $bootstrap==4}>
              <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_login.tpl"}>
            <{else}>
              <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_login.tpl"}>
            <{/if}>
        </li>
        <{/if}>
    </ul>
</div>
<div style="clear:both;"></div>
