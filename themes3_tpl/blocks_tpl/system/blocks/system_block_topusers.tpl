<div class="row">
  <{foreach item=user from=$block.users}>
    <div class="col-sm-12">
      <div class="thumbnail">
        <{if $user.avatar != ""}>
          <img src="<{$user.avatar}>" alt="<{$user.name}>" class="img-responsive img-rounded">
        <{else}>
          <img src="<{$xoops_imageurl|default:''}>images/blank.gif" alt="<{$user.name}>" class="img-circle">
        <{/if}>
        <div class="caption">
          <h3><a href="<{$xoops_url}>/userinfo.php?uid=<{$user.id}>" title="<{$user.name}>"><{$user.name}></a>
          <small><i class="fa fa-star-o" aria-hidden="true"></i> <{$user.rank}> <i class="fa fa-file-text-o" aria-hidden="true"></i> <{$user.posts}></small>
          </h3>
        </div>
      </div>
    </div>
  <{/foreach}>
</div>