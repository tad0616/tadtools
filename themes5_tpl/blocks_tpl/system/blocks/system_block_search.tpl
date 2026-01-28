<div class="text-center">
    <form role="search" action="<{$xoops_url}>/search.php" method="get">
        <div class="input-group">
            <input class="form-control" type="text" name="query" title="search" placeholder="<{$smarty.const.THEME_SEARCH_TEXT}>">
            <input type="hidden" name="action" value="results">
            <div class="input-group-append">
                <button class="btn btn-info" type="submit"><i class="fa fa-magnifying-glass" aria-hidden="true"></i><span class="sr-only visually-hidden">search</span></button>
            </div>
        </div>
    </form>

    <p class="text-end">
        <a href="<{$xoops_url}>/search.php">
            <{$block.lang_advsearch}>
        </a>
    </p>
</div>