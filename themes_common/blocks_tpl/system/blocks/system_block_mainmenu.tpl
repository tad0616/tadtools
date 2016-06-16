<!-- List group -->
<ul class="list-group">
  <li class="list-group-item <{if !$block.nothome}>active<{/if}>"><a href="<{xoAppUrl }>" title="<{$block.lang_home}>" <{if !$block.nothome}>style="color: yellow"<{/if}>><{$block.lang_home}></a></li>
  <{foreach item=module from=$block.modules}>
      <li class="list-group-item <{if $module.highlight}>active<{/if}>">
          <i class="fa fa-angle-right" aria-hidden="true"></i>
          <a href="<{$xoops_url}>/modules/<{$module.directory}>/" title="<{$module.name}>" <{if $module.highlight}>style="color: yellow"<{/if}>><{$module.name}></a>
      </li>
      <{if $module.sublinks}>
          <{foreach item=sublink from=$module.sublinks}>
              <li class="list-group-item" style="padding-left: 2em; font-size: 0.9em;">
                  <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                  <a href="<{$sublink.url}>" title="<{$sublink.name}>"><{$sublink.name}></a>
              </li>
          <{/foreach}>
      <{/if}>
  <{/foreach}>
</ul>
