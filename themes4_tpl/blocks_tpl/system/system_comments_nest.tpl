<div class="xoops-comment-body">
    <{section name=i loop=$comments}>
    <div class="row">
        <div class="col-sm-2 col-lg-2"><strong><{$lang_poster|default:''}></strong></div>
        <div class="col-sm-10 col-lg-10"><strong><{$lang_thread|default:''}></strong></div>
    </div>
    <{include file="db:system_comment.tpl" comment=$comments[i]}>
    <!-- start comment replies -->
    <{foreach item=reply from=$comments[i].replies}>
        <{assign var="indent" value="`$reply.prefix/25`"}>
        <{assign var="fullcolwidth" value="12"}>

        <{if $indent>3}>
            <{assign var="indent" value="3"}>
        <{/if}>
        <{assign var="replyspace" value="`$fullcolwidth-$indent`"}>

        <div class="row">
            <div class="offset--md<{$indent|default:''}> col-lg-<{$replyspace|default:''}>">
            <{include file="db:system_comment.tpl" comment=$reply}>
            </div>
        </div>
    <{/foreach}>
    <{/section}>
    <{if $commentform|default:false}>
    <div class="aligncenter">
        <button class="btn-comment btn btn-primary btn-md" data-toggle="modal" data-target="#comments-form">
            <span class="glyphicon glyphicon-comment"></span> Add Comment
        </button>
    </div>
<!-- Modal -->
    <div class="modal fade" id="comments-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog comments-modal">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="xoops-comment-form">
                        <{$commentform|default:''}>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">&times;</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <{/if}>
</div>
