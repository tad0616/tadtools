<div class="xoops-comment-template" id="comment<{$comment.id}>">
    <div class="row hidden-xs">
        <div class="col-sm-2 col-lg-2 aligncenter"><{$comment.poster.uname}></div><!-- .col-lg-3 -->
        <div class="col-sm-4 col-lg-4">
            <small class="text-muted"><strong><{$lang_posted}></strong> <{$comment.date_posted}></small>
        </div><!-- .col-lg-3 -->
		<{if $comment.date_posted != $comment.date_modified}>
        <div class="col-sm-5 col-lg-5">
            <small class="text-muted"><strong><{$lang_updated}></strong> <{$comment.date_modified}></small>
        </div><!-- .col-lg-3 -->
		<{/if}>
    </div><!-- row -->

    <div class="row">
        <div class="col-sm-2 col-lg-2 xoops-comment-author aligncenter">
            <{if $comment.poster.id != 0}>
                <img src="<{$xoops_upload_url}>/<{$comment.poster.avatar}>" class="img-fluid rounded image-avatar" alt="">
                <ul class="list-unstyled">
                    <li><strong class="poster-rank hidden-xs"><{$comment.poster.rank_title}></strong></li>
                    <li><img src="<{$xoops_upload_url}>/<{$comment.poster.rank_image}>" alt="<{$comment.poster.rank_title}>"
                             class="poster-rank img-fluid"></li>
                </ul>
                <ul class="list-unstyled poster-info hidden">
                    <li><{$lang_joined}> <{$comment.poster.regdate}></li>
                    <li><{$lang_from}> <{$comment.poster.from}></li>
                    <li><{$lang_posts}> <{$comment.poster.postnum}></li>
                    <li><{$comment.poster.status}></li>
                </ul>
            <{else}>
                &nbsp; <!-- ? -->
            <{/if}>
        </div><!-- .col-lg-3 .xoops-comment-author -->

        <div class="col-sm-10 col-lg-10 xoops-comment-text">
            <h4><{$comment.image}><{$comment.title}></h4>

            <p class="message-text"><{$comment.text}></p>
        </div><!-- .col-lg-3 -->
    </div><!-- row -->

    <div class="row">
        <div class="col-sm-12 col-lg-12 alignright">
            <{if $xoops_iscommentadmin == true}>
                <a href="<{$editcomment_link}>&amp;com_id=<{$comment.id}>" title="<{$lang_edit}>" class="btn btn-light btn-sm">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>" title="<{$lang_reply}>" class="btn btn-light btn-sm">
                    <span class="glyphicon glyphicon-comment"></span>
                </a>
                <a href="<{$deletecomment_link}>&amp;com_id=<{$comment.id}>" title="<{$lang_delete}>" class="btn btn-light btn-sm">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            <{elseif $xoops_isuser == true && $xoops_userid == $comment.poster.id}>
                <a href="<{$editcomment_link}>&amp;com_id=<{$comment.id}>" title="<{$lang_edit}>" class="btn btn-light btn-sm">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
                <a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>" title="<{$lang_reply}>" class="btn btn-light btn-sm">
                    <span class="glyphicon glyphicon-comment"></span>
                </a>
            <{elseif $xoops_isuser == true || $anon_canpost == true}>
                <a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>" class="btn btn-light btn-sm">
                    <span class="glyphicon glyphicon-comment"></span>
                </a>
            <{else}>
                &nbsp;        <!-- ? -->
            <{/if}>
        </div><!-- .col-lg-12 -->
    </div><!-- row -->
</div><!-- .xoops-comment-template -->
