<{if $xoops_isadmin|default:false}>
  <{if $install_chk|default:false}>
    <div class='alert alert-danger'>
      <{$smarty.const._TAD_DEL_INSTALL_CHK}>
    </div>
<{/if}>

<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/modules/tadtools/colorbox/colorbox.css" />
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/colorbox/jquery.colorbox.js"></script>
<script>
  function tad_themes_popup(URL) {
    $.colorbox({iframe:true, width:"80%", height:"90%",href : URL});
  }

  $(document).ready(function(){
    //Stack menu when collapsed
    $('#bs-example-navbar-collapse-1').on('show.bs.collapse', function() {
        $('.nav-pills').addClass('nav-stacked');
    });

    //Unstack menu when not collapsed
    $('#bs-example-navbar-collapse-1').on('hide.bs.collapse', function() {
        $('.nav-pills').removeClass('nav-stacked');
    });
  });
</script>
<style>
.custom-nav-bar.navbar-toggle {
   background-color: #ddd;
}
.custom-nav-bar.navbar-toggle .icon-bar {
    background-color: #888;
}
</style>


<{$tad_themes_popup_code|default:''}>
<{if $navbar_pos!="not-use"}>
<nav id="pills" class="navbar" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed custom-nav-bar" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav nav-pills">
        <{if $show_sitename !='2' }>
          <{if $navlogo_img|default:false}>
            <<li role="presentation"><a href="<{$xoops_url}>/index.php" style="color:<{$navbar_color|default:''}>"><img src="<{$navlogo_img|default:''}>" alt="<{$xoops_sitename|default:''}>"></<li></li>
          <{elseif $show_sitename=='0' or $show_sitename==''}>
            <li role="presentation"><a href="<{$xoops_url}>/index.php" style="color:<{$navbar_color|default:''}>"><{$smarty.const._TAD_HOME}></a></li>
          <{else}>
            <li role="presentation"><a href="<{$xoops_url}>/index.php" style="color:<{$navbar_color|default:''}>"><{$xoops_sitename|default:''}></a></li>
          <{/if}>
        <{/if}>


        <{if $show_sitename==0 or $show_sitename==''}>
          <li role="presentation"><a href="<{$xoops_url}>/index.php" style="color:<{$navbar_color|default:''}>"><{$smarty.const._TAD_HOME}></a></li>
        <{/if}>
        <{if $smarty.session.bootstrap==5}>
          <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_my.tpl"}>
        <{elseif $smarty.session.bootstrap==4}>
          <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_my.tpl"}>
        <{else}>
          <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_my.tpl"}>
        <{/if}>
        <{if !$xoops_isuser}>
          <li>
            <a class="dropdown-toggle" data-toggle="dropdown">
              <{$smarty.const._TAD_TF_USER_LOGIN}> <span class="caret"></span>
            </a>
            <{include file="$xoops_rootpath/modules/tadtools/themes`$smarty.session.bootstrap`_tpl/menu_login.tpl"}>
          </li>
        <{/if}>
      </ul>
    </div>
  </div>
</nav>
<{/if}>