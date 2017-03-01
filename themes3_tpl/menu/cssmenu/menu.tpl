<link rel="stylesheet" type="text/css" href="<{xoAppUrl modules/tadtools/themes3_tpl/menu/cssmenu/styles.css}>" />
<script src="<{xoAppUrl modules/tadtools/themes3_tpl/menu/cssmenu/menu_jquery.js}>"></script>
<style type="text/css">
  #cssmenu{
    background: <{$navbar_bg_top}>;
    /* background: transparent; */
  }
  #cssmenu > ul{
    background: <{$navbar_bg_top}>;
    /* background: transparent; */
  }
  #cssmenu ul ul li a {
    background: <{$navbar_bg_bottom}>;
    color:<{$navbar_color}>;
    /* color: #6e6265; */
    /* background: #fff; */
  }
  #cssmenu ul ul li:hover > a {
    background: <{$navbar_hover}>;
    color:<{$navbar_color_hover}>;
    /* color: #8c9195; */
    /* background: #f6f6f6; */
  }

  #cssmenu > ul > li > a {
    color:<{$navbar_color}>;
    /* color: #ffffff; */
  }

  #cssmenu > ul > li:hover > a {
    color:<{$navbar_color_hover}>;
    /* color: #ffffff; */
  }
</style>
<div id="cssmenu">
  <ul>
    <{foreach from=$menu_var item=menu}>
      <li <{if $menu.submenu}>class='has-sub'<{/if}>>
        <a href='<{$menu.url}>' target="<{$menu.target}>">
          <span><span class="fa <{$menu.icon}>" <{$navbar_icon}>></span> <{$menu.title}></span>
        </a>
        <{if $menu.submenu}>
          <{if $menu.submenu=='1'}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes_tpl/menu/cssmenu/login3.tpl"}>
          <{else}>
            <ul>
              <{foreach from=$menu.submenu item=menu2}>
                <{if $menu2.title == 'separator'}>
                  <li role="separator" class="divider"></li>
                <{else}>
                  <li <{if $menu2.submenu}>class='has-sub'<{/if}>>
                    <a href='<{$menu2.url}>' target="<{$menu2.target}>">
                      <span><span class="fa <{$menu2.icon}>"></span> <{$menu2.title}></span>
                    </a>
                    <{if $menu2.submenu}>
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
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <{$smarty.const._TAD_TF_USER_LOGIN}> <span class="caret"></span>
        </a>
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_login.tpl"}>
      </li>
    <{/if}>
  </ul>
</div>
<div style="clear:both;"></div>
