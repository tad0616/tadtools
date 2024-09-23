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
          <span><span class="fa <{$menu.icon}>" <{$navbar_icon|default:''}>><{if $menu.img|default:false}><img src="<{$menu.icon}>" alt="<{$menu.title}> icon"><{/if}></span> <{$menu.title}></span>
        </a>
        <{if $menu.submenu|default:false}>
          <ul>
            <{foreach from=$menu.submenu item=menu2}>
              <li <{if $menu2.submenu|default:false}>class='has-sub'<{/if}>>
                <a href='<{$menu2.url}>' target="<{$menu2.target}>">
                  <span><span class="fa <{$menu2.icon}>"><{if $menu2.img|default:false}><img src="<{$menu2.icon}>" alt="<{$menu2.title}> icon"><{/if}></span> <{$menu2.title}></span>
                </a>
                <{if $menu2.submenu|default:false}>
                  <ul>
                    <{foreach from=$menu2.submenu item=menu3}>
                      <li>
                        <a href='<{$menu3.url}>' target="<{$menu3.target}>">
                          <span><span class="fa <{$menu3.icon}>"><{if $menu3.img|default:false}><img src="<{$menu3.icon}>" alt="<{$menu3.title}> icon"><{/if}></span> <{$menu3.title}></span>
                        </a>
                      </li>
                     <{/foreach}>
                  </ul>
                <{/if}>
              </li>
             <{/foreach}>
          </ul>
        <{/if}>
      </li>
     <{/foreach}>
  </ul>
</div>
<div style="clear:both;"></div>
