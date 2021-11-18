<div class="text-center">
    <form role="search" action="<{xoAppUrl search.php}>" method="get">
        <div class="input-group">
            <input class="form-control" type="text" name="query" title="search" placeholder="<{$smarty.const.THEME_SEARCH_TEXT}>">
            <input type="hidden" name="action" value="results">
            <div class="input-group-append">
                <button class="btn btn-info" type="submit"><i class="fa fa-search" aria-hidden="true"></i><span class="sr-only">search</span></button>
            </div>
        </div>
    </form>

    <p class="text-end">
        <a href="<{xoAppUrl search.php}>" title="<{$block.lang_advsearch}>">
            <{$block.lang_advsearch}>
        </a>
    </p>
</div>