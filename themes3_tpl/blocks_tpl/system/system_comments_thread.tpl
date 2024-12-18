<div class="xoops-comment-body">
    <{section name=i loop=$comments}>
        <div class="row">
            <div class="col-xs-2 col-md-2"><strong><{$lang_poster|default:''}></strong></div>
            <div class="col-xs-10 col-md-10"><strong><{$lang_thread|default:''}></strong></div>
        </div>
        <{include file="db:system_comment.tpl" comment=$comments[i]}>

        <{if $show_threadnav == true}>
            <a href="<{$comment_url|default:''}>" title="<{$lang_top|default:''}>"><{$lang_top|default:''}></a>
            <a href="<{$comment_url|default:''}>&amp;com_id=<{$comments[i].pid}>&amp;com_rootid=<{$comments[i].rootid}>#newscomment<{$comments[i].pid}>"><{$lang_parent|default:''}></a>
        <{/if}>

        <{if $comments[i].show_replies == true}>
            <!-- start comment tree -->
            <div class="row">
                <div class="col-md-4">
                    <strong><{$lang_subject|default:''}></strong>
                </div>

                <div class="col-md-4">
                    <strong><{$lang_poster|default:''}></strong>
                </div>
                <div class="col-md-4">
                    <strong><{$lang_posted|default:''}></strong>
                </div>
            </div>
            <{foreach item=reply from=$comments[i].replies}>
                <div class="row">
                    <div class="col-md-4">
                        <{$reply.prefix}> <a href="<{$comment_url|default:''}>&amp;com_id=<{$reply.id}>&amp;com_rootid=<{$reply.root_id}>" title=""><{$reply.title}></a>
                    </div>

                    <div class="col-md-4">
                        <{$reply.poster.uname}>
                    </div>

                    <div class="col-md-4">
                        <{$reply.date_posted}>
                    </div>
                </div>
            <{/foreach}>
            <!-- end comment tree -->
        <{/if}>
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">&times;</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    <{/if}>
</div>
