<{if $xoops_isadmin}>
  <{php}>
  if(file_exists(XOOPS_VAR_PATH."/data/install_chk.php")){
    global $xoopsConfig;
    include_once XOOPS_ROOT_PATH."/modules/tadtools/language/{$xoopsConfig['language']}/main.php";
    echo "
    <div class='alert alert-danger'>
      "._TAD_DEL_INSTALL_CHK."
    </div>
    ";
    unlink(XOOPS_VAR_PATH."/data/install_chk.php");
  }
  <{/php}>
<{/if}>

<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{xoAppUrl modules/tadtools/colorbox/colorbox.css}>" />
<script type="text/javascript" src="<{xoAppUrl modules/tadtools/colorbox/jquery.colorbox.js}>"></script>
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


<{$tad_themes_popup_code}>
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
          <{if $navbar_logo_img}>
            <<li role="presentation"><a href="<{$xoops_url}>/index.php" style="color:<{$navbar_color}>"><img src="<{$navbar_logo_img}>" alt="<{$xoops_sitename}>"></<li></li>
          <{elseif $show_sitename=='0'}>
            <li role="presentation"><a href="<{$xoops_url}>/index.php" style="color:<{$navbar_color}>"><{$smarty.const._TAD_HOME}></a></li>
          <{else}>
            <li role="presentation"><a href="<{$xoops_url}>/index.php" style="color:<{$navbar_color}>"><{$xoops_sitename}></a></li>
          <{/if}>
        <{/if}>


        <{if $show_sitename==0}>
          <li role="presentation"><a href="<{$xoops_url}>/index.php" style="color:<{$navbar_color}>"><{$smarty.const._TAD_HOME}></a></li>
        <{/if}>
        <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/menu_my.tpl"}>
        <{if !$xoops_isuser}>
          <li>
            <a class="dropdown-toggle" data-toggle="dropdown">
              <{$smarty.const._TAD_TF_USER_LOGIN}> <span class="caret"></span>
            </a>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/menu_login.tpl"}>
          </li>
        <{/if}>
      </ul>
    </div>
  </div>
</nav>
<{/if}>