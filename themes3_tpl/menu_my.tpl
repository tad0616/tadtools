<{foreach from=$menu_var item=m}>
  <li>
    <a <{if $m.submenu}>class="dropdown-toggle" data-toggle="dropdown" <{/if}> href="<{if $m.target=="popup"}>javascript:tad_themes_popup('<{$m.url}>');<{else}><{$m.url}><{/if}>" <{if $m.target!="popup"}>target="<{$m.target}>"<{/if}>>
      <{if $m.img}><img src="<{$m.img}>" alt="<{$m.title}> icon"><{else if $m.icon}><i class="fa <{$m.icon}>"></i><{/if}> <{$m.title}> <{if $m.submenu}> <span class="caret"></span><{/if}>
    </a>
    <{if $m.submenu}>
      <{if $m.submenu=='1'}>
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_login.tpl"}>
      <{else}>
        <ul class="dropdown-menu">
          <{foreach from=$m.submenu item=m2}>
            <{if $m2.title == 'separator'}>
              <li role="separator" class="divider"></li>
            <{else}>
              <li>
                <a <{if $m2.submenu}>tabindex="-1"<{/if}> href="<{if $m2.target=="popup"}>javascript:tad_themes_popup('<{$m2.url}>');<{else}><{$m2.url}><{/if}>" <{if $m2.target!="popup"}>target="<{$m2.target}>"<{/if}>>
                 <{if $m2.img}><img src="<{$m2.img}>" alt="<{$m2.title}> icon"><{else if $m2.icon}> <i class="fa <{$m2.icon}>"></i><{/if}> <{$m2.title}> <{if $m2.submenu}> <span class="caret"></span><{/if}>
                </a>
                <{if $m2.submenu}>
                  <ul class="dropdown-menu">
                    <{foreach from=$m2.submenu item=m3}>
                      <li>
                        <a <{if $m3.submenu}>tabindex="-1"<{/if}> href="<{if $m3.target=="popup"}>javascript:tad_themes_popup('<{$m3.url}>');<{else}><{$m3.url}><{/if}>" <{if $m3.target!="popup"}>target="<{$m3.target}>"<{/if}>>
                          <{if $m3.img}><img src="<{$m3.img}>" alt="<{$m3.title}> icon"><{else if if $m3.icon}><i class="fa <{$m3.icon}>"></i><{/if}> <{$m3.title}> <{if $m3.submenu}> <span class="caret"></span><{/if}>
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