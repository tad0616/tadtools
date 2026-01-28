<div class="text-center">

    <form role="search" action="<{$xoops_url}>/search.php" method="get">

        <div class="input-group">

            <input class="form-control" type="text" name="query" title="search" placeholder="<{$smarty.const.THEME_SEARCH_TEXT}>">

            <input type="hidden" name="action" value="results">

            <span class="input-group-btn">

                <button class="btn btn-primary" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                    <span class="sr-only">search</span>
                </button>

            </span>

        </div>

    </form>

    <p class="text-right text-end">
        <a href="<{$xoops_url}>/search.php">
            <{$block.lang_advsearch}>
        </a>
    </p>
</div>
