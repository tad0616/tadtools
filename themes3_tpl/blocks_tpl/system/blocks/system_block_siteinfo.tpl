    <{if $block.showgroups == true}>

        <!-- start group loop -->
        <{foreach item=group from=$block.groups}>
            <h3><{$group.name}></h3>
            <!-- start group member loop -->
            <{foreach item=user from=$group.users}>
            <div>
                <img style="width:32px;" src="<{$user.avatar}>" alt="<{$user.name}>"><br>
                <a href="<{$xoops_url}>/userinfo.php?uid=<{$user.id}>" title="<{$user.name}>"><{$user.name}></a>
                <{$user.msglink}>
            </div>
            <{/foreach}>
            <!-- end group member loop -->

        <{/foreach}>
        <!-- end group loop -->
    <{/if}>



<div class="txtcenter marg3">
    <img src="<{$block.logourl}>" alt="recommendlink logo">
    <br><{$block.recommendlink}>
</div>
