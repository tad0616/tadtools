<div class="xoops-comment-template" id="comment<{$comment.id}>">
    <div class="row hidden-xs">
        <div class="col-xs-2 col-md-2 aligncenter"><{$comment.poster.uname}></div><!-- .col-md-3 -->
        <div class="col-xs-4 col-md-4">
            <small class="text-muted"><strong><{$lang_posted|default:''}></strong> <{$comment.date_posted}></small>
        </div><!-- .col-md-3 -->
		<{if $comment.date_posted != $comment.date_modified}>
        <div class="col-xs-5 col-md-5">
            <small class="text-muted"><strong><{$lang_updated|default:''}></strong> <{$comment.date_modified}></small>
        </div><!-- .col-md-3 -->
		<{/if}>
    </div><!-- row -->

    <div class="row">
        <div class="col-xs-2 col-md-2 xoops-comment-author aligncenter">
            <{if $comment.poster.id != 0}>
                <img src="<{$xoops_upload_url|default:''}>/<{$comment.poster.avatar}>" class="img-responsive img-rounded image-avatar" alt="">
                <ul class="list-unstyled">
                    <li><strong class="poster-rank hidden-xs"><{$comment.poster.rank_title}></strong></li>
                    <li><img src="<{$xoops_upload_url|default:''}>/<{$comment.poster.rank_image}>" alt="<{$comment.poster.rank_title}>"
                             class="poster-rank img-responsive"></li>
                </ul>
                <ul class="list-unstyled poster-info hidden">
                    <li><{$lang_joined|default:''}> <{$comment.poster.regdate}></li>
                    <li><{$lang_from|default:''}> <{$comment.poster.from}></li>
                    <li><{$lang_posts|default:''}> <{$comment.poster.postnum}></li>
                    <li><{$comment.poster.status}></li>
                </ul>
            <{else}>
                &nbsp; <!-- ? -->
            <{/if}>
        </div><!-- .col-md-3 .xoops-comment-author -->

        <div class="col-xs-10 col-md-10 xoops-comment-text">
            <h4><{$comment.image}><{$comment.title}></h4>

            <p class="message-text"><{$comment.text}></p>
        </div><!-- .col-md-3 -->
    </div><!-- row -->

    <div class="row">
        <div class="col-xs-12 col-md-12 alignright">
            <{if $xoops_iscommentadmin == true}>
                <a href="<{$editcomment_link|default:''}>&amp;com_id=<{$comment.id}>" title="<{$lang_edit|default:''}>" class="btn btn-default btn-xs">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a href="<{$replycomment_link|default:''}>&amp;com_id=<{$comment.id}>" title="<{$lang_reply|default:''}>" class="btn btn-default btn-xs">
                    <span class="glyphicon glyphicon-comment"></span>
                </a>
                <a href="<{$deletecomment_link|default:''}>&amp;com_id=<{$comment.id}>" title="<{$lang_delete|default:''}>" class="btn btn-default btn-xs">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            <{elseif $xoops_isuser == true && $xoops_userid == $comment.poster.id}>
                <a href="<{$editcomment_link|default:''}>&amp;com_id=<{$comment.id}>" title="<{$lang_edit|default:''}>" class="btn btn-default btn-xs">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a href="<{$replycomment_link|default:''}>&amp;com_id=<{$comment.id}>" title="<{$lang_reply|default:''}>" class="btn btn-default btn-xs">
                    <span class="glyphicon glyphicon-comment"></span>
                </a>
            <{elseif $xoops_isuser == true || $anon_canpost == true}>
                <a href="<{$replycomment_link|default:''}>&amp;com_id=<{$comment.id}>" class="btn btn-default btn-xs">
                    <span class="glyphicon glyphicon-comment"></span>
                </a>
            <{else}>
                &nbsp;        <!-- ? -->
            <{/if}>
        </div><!-- .col-md-12 -->
    </div><!-- row -->
</div><!-- .xoops-comment-template -->
