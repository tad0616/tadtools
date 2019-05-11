<?php
class easy_responsive_tabs extends \XoopsModules\Tadtools\EasyResponsiveTabs
{
}

#若有更新，記得把 $currentTab.trigger('tabactivate', $currentTab); 移動到 if (historyApi) {} 之後
/*
use XoopsModules\Tadtools\EasyResponsiveTabs;

$EasyResponsiveTabs = new EasyResponsiveTabs('#demoTab', $type = 'default, vertical, accordion', $activetab_bg = '#B5AC5F', $inactive_bg = '#E0D78C', $active_border_color = '#9C905C', $active_content_border_color = '#9C905C');
$EasyResponsiveTabs->rander();

<div id="demoTab">
<ul class="resp-tabs-list vert">
<li> .... </li>
<li> .... </li>
<li> .... </li>
</ul>

<div class="resp-tabs-container vert">
<div> ....... </div>
<div> ....... </div>
<div> ....... </div>
</div>
</div>

 */
