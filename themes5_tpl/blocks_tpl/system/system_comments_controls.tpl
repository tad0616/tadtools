<form method="get" action="<{$pageName}>"  role="form">
  <div class="form-group row mb-3" style="background: #fcfcfc; padding : 4px;">
    <div class="col-md-4"><{$commentModeSelect->render()}></div>
    <div class="col-md-4"><{$commentOrderSelect->render()}></div>
    <div class="col-md-4">
      <{$commentRefreshButton->render()}>
      <{if ($commentPostButton|default:false) }>
      <{$commentPostButton->render()}>
      <{/if}>
      <{$commentPostHidden}>
    </div>
  </div>
</form>
