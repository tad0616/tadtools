<form method="get" action="<{$pageName|default:''}>"  role="form">
  <div class="form-group row row" style="background: #fcfcfc; padding : 4px;">
    <div class="col-md-4"><{$commentModeSelect->render()}></div>
    <div class="col-md-4"><{$commentOrderSelect->render()}></div>
    <div class="col-md-4">
      <{$commentRefreshButton->render()}>
      <{if ($commentPostButton|default:false) }>
      <{$commentPostButton->render()}>
      <{/if}>
      <{$commentPostHidden|default:''}>
    </div>
  </div>
</form>
