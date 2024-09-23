<form method="get" action="<{$pageName|default:''}>"  class="form-horizontal" role="form">
  <div class="form-group" style="background: #fcfcfc; padding : 4px;">
    <div class="col-sm-4"><{$commentModeSelect->render()}></div>
    <div class="col-sm-4"><{$commentOrderSelect->render()}></div>
    <div class="col-sm-4">
      <{$commentRefreshButton->render()}>
      <{if ($commentPostButton|default:false) }>
      <{$commentPostButton->render()}>
      <{/if}>
      <{$commentPostHidden|default:''}>
    </div>
  </div>
</form>
