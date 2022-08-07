<{if $openid_login!="3"}>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">

    <{if $openid_login=="0" or $openid_login=="1"}>
      <li>
        <form action="<{$xoops_url}>/user.php" method="post" class="form-horizontal" role="form">
          <fieldset style="min-width: 200px; margin: 10px;">
            <legend>
            <{if $login_text}><{$login_text}><{else}>
            <{$smarty.const.TF_USER_ENTER}><{/if}>
            </legend>
            <{if $login_description}><div class="alert alert-warning" style="font-size: 0.825rem;"><{$login_description}></div><{/if}>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="uname">
                <{$smarty.const.TF_USER_S_ID}>
              </label>
              <div class="col-sm-8">
                <input type="text" name="uname"  id="uname" placeholder="<{$smarty.const.TF_USER_ID}>"  class="form-control">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label" for="pass">
                <{$smarty.const.TF_USER_S_PASS}>
              </label>
              <div class="col-sm-8">
              <input type="password" name="pass" id="pass" placeholder="<{$smarty.const.TF_USER_PASS}>" class="form-control">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label">
              </label>
              <div class="col-sm-8">
                <input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi}>">
                <input type="hidden" name="rememberme" value="On">
                <input type="hidden" name="op" value="login">
                <input type="hidden" name="xoops_login" value="1">
                <button type="submit" class="btn btn-primary btn-block"><{$smarty.const.TF_USER_ENTER}></button>
              </div>
            </div>

            <{if $allow_register=='1'}>
              <div class="form-group">
                <div class="col-sm-5">
                  <a href="<{$xoops_url}>/register.php" class="btn btn-xs btn-link" style="background: transparent; width: auto; color: #303030; font-size: 0.75em;">
                    <span class="fa fa-pencil"></span>
                    <{$smarty.const.TF_USER_REGIST}>
                  </a>
                </div>
                <div class="col-sm-7">
                  <a href="<{$xoops_url}>/user.php#lost" class="btn btn-xs btn-link" style="background: transparent; width: auto; color: #303030; font-size: 0.75em;">
                    <span class="fa fa-search"></span>
                    <{$smarty.const.TF_USER_FORGET_PASS}>
                  </a>
                </div>
              </div>
            <{/if}>
          </fieldset>
        </form>

      </li>

    <{/if}>

    <{if $openid_login=="1" or $openid_login=="2"}>
      <{php}>

        global $xoopsConfig,$xoopsTpl,$oidc_array,$oidc_array2,$all_oidc,$all_oidc2;


      $moduleHandler = xoops_getHandler('module');
      $configHandler =xoops_gethandler('config');

      $TadLoginXoopsModule = $moduleHandler->getByDirname("tad_login");

      if($TadLoginXoopsModule){
        require_once XOOPS_ROOT_PATH."/modules/tad_login/function.php";
        require_once XOOPS_ROOT_PATH."/modules/tad_login/oidc.php";
        require_once XOOPS_ROOT_PATH."/modules/tad_login/language/{$xoopsConfig['language']}/county.php";

        $configHandler =xoops_gethandler('config');
        $modConfig= &$configHandler->getConfigsByCat(0, $TadLoginXoopsModule->getVar('mid'));

        if (in_array('facebook', $modConfig['auth_method'])) {
            $tad_login['facebook'] = facebook_login('return');
        } else {
            $tad_login['facebook'] = '';
        }

        if (in_array('google', $modConfig['auth_method'])) {
            $tad_login['google'] = google_login('return');
        } else {
            $tad_login['google'] = '';
        }

        $auth_method=$modConfig['auth_method'];
        $i=0;

        foreach($auth_method as $method){
          $method_const="_".strtoupper($method);

          if($method=="facebook"){
            $tlogin[$i]['link']=$tad_login['facebook'];
                    $tlogin[$i]['text']=sprintf(_TAD_LOGIN_BY,constant($method_const));
          }elseif($method=="google"){
            $tlogin[$i]['link']=$tad_login['google'];
                    $tlogin[$i]['text']=sprintf(_TAD_LOGIN_BY,constant($method_const));
          }else{
            $tlogin[$i]['link']=XOOPS_URL."/modules/tad_login/index.php?login&op={$method}";
                    $tlogin[$i]['text']=sprintf(_TAD_LOGIN_BY,constant($method_const));
          }

                if(in_array($method, $oidc_array)){
                    $tlogin[$i]['img']=XOOPS_URL."/modules/tad_login/images/oidc/{$all_oidc[$method]['tail']}.png";
                    $tlogin[$i]['text']=sprintf(_TAD_LOGIN_BY, constant('_'.strtoupper($all_oidc[$method]['tail']))._TADLOGIN_OIDC);

                }elseif(in_array($method, $oidc_array2)){
                    $tlogin[$i]['img']=XOOPS_URL."/modules/tad_login/images/{$method}.png";
                    $tlogin[$i]['text']=sprintf(_TAD_LOGIN_BY, constant('_'.strtoupper($all_oidc2[$method]['tail']))._TADLOGIN_LDAP);

                }else{
          $tlogin[$i]['img']=XOOPS_URL."/modules/tad_login/images/{$method}.png";
                    $tlogin[$i]['text']=sprintf(_TAD_LOGIN_BY,constant($method_const).' OpenID ');
                }

          $i++;
        }
        $xoopsTpl->assign('tlogin',$tlogin);
      }
      <{/php}>


      <{assign var="i" value=0}>
      <{assign var="total" value=1}>
      <{foreach from=$tlogin item=login}>
        <{if $i==0}>
        <li style="white-space: nowrap">
        <{/if}>

        <a href="<{$login.link}>" class="btn" <{if $openid_logo!=1}>style="display:inline-block;width:32px;height:32px;padding:2px;margin:2px;background-color:transparent;"<{/if}>>
          <img src="<{$login.img}>" alt="<{$login.text}>" title="<{$login.text}>" <{if $openid_logo!=1}>style="width:32px;height:32px;"<{/if}>>
          <{if $openid_logo==1}><{$login.text}><{/if}>
        </a>

        <{assign var="i" value=$i+1}>
        <{assign var="total" value=$total+1}>

        <{if $i == $openid_logo || $total==$count}>
          </li>
          <{assign var="i" value=0}>
        <{/if}>
      <{/foreach}>
    <{/if}>


  </ul>
<{/if}>