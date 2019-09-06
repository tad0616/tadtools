<{foreach from=$menu_var item=m1}>
    <li class="nav-item <{if $m1.submenu}>dropdown<{/if}>">
        <a class="nav-link <{if $m1.submenu}>dropdown-toggle<{/if}>" <{if $m1.url!=''}>href="<{if $m1.target=="popup"}>javascript:tad_themes_popup('<{$m1.url}>');<{else}><{$m1.url}><{/if}>" <{if $m1.target!="popup"}>target="<{$m1.target}>"<{/if}><{/if}> title="<{$m1.title}>"><{if $m1.img}><img src="<{$m1.img}>" alt="<{$m1.title}> icon"><{else if $m1.icon}><i class="fa <{$m1.icon}>"></i><{/if}> <{$m1.title}></a>

        <{if $m1.submenu}>
            <ul class="dropdown-menu">
                <{foreach from=$m1.submenu item=m2}>
                    <li class="<{if $m2.submenu}>dropdown<{/if}>">
                        <a class="dropdown-item <{if $m2.submenu}>dropdown-toggle<{/if}>" <{if $m2.url!=''}>href="<{if $m2.target=="popup"}>javascript:tad_themes_popup('<{$m2.url}>');<{else}><{$m2.url}><{/if}>" <{if $m2.target!="popup"}>target="<{$m2.target}>"<{/if}><{/if}> title="<{$m2.title}>"><{if $m2.img}><img src="<{$m2.img}>" alt="<{$m2.title}> icon"><{else if $m2.icon}><i class="fa <{$m2.icon}>"></i><{/if}> <{$m2.title}></a>
                        <{if $m2.submenu}>
                            <ul class="dropdown-menu">
                                <{foreach from=$m2.submenu item=m3}>
                                    <li class="<{if $m3.submenu}>dropdown<{/if}>">
                                        <a class="dropdown-item <{if $m3.submenu}>dropdown-toggle<{/if}>" <{if $m3.url!=''}>href="<{if $m3.target=="popup"}>javascript:tad_themes_popup('<{$m3.url}>');<{else}><{$m3.url}><{/if}>" <{if $m3.target!="popup"}>target="<{$m3.target}>"<{/if}><{/if}> title="<{$m3.title}>"><{if $m3.img}><img src="<{$m3.img}>" alt="<{$m3.title}> icon"><{else if $m3.icon}><i class="fa <{$m3.icon}>"></i><{/if}> <{$m3.title}></a>
                                        <{if $m3.submenu}>
                                            <ul class="dropdown-menu">
                                            <{foreach from=$m3.submenu item=m4}>
                                                <li class="nav-item"><a class="dropdown-item" <{if $m4.url!=''}>href="<{if $m4.target=="popup"}>javascript:tad_themes_popup('<{$m4.url}>');<{else}><{$m4.url}><{/if}>" <{if $m4.target!="popup"}>target="<{$m4.target}>"<{/if}><{/if}> title="<{$m4.title}>"><{if $m4.img}><img src="<{$m4.img}>" alt="<{$m4.title}> icon"><{else if $m4.icon}><i class="fa <{$m4.icon}>"></i><{/if}> <{$m4.title}></a></li>
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
        <{/if}>
    </li>
<{/foreach}>