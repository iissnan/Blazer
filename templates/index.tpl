{extends "layout.tpl"}
    {block name="content"}
        {if $is_login}
            <div class="action">
                <a href="book/add.php" class="btn btn-primary pull-right">添  加</a>
            </div>
        {/if}
        {if $total > 0}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>封面</th>
                        <th>名称</th>
                        <th>作者</th>
                        <th>ISBN</th>
                        <th>分类</th>
                        {if $is_login}
                            <th>操作</th>
                        {/if}
                    </tr>
                </thead>
                {foreach $books as $book}
                    <tr>
                        <td>
                            <img src="
                                {if $book["cover"] == ""}
                                    ../assets/cover/default.png
                                {else}
                                    ../assets/cover/{$book["cover"]}
                                {/if}"
                                 alt="{$book["title"]}"
                                 class="cover img-polaroid"
                            />
                        </td>
                        <td>{$book["title"]}</td>
                        <td>{$book["author"]}</td>
                        <td>{$book["isbn"]}</td>
                        <td>{$book["category"]}</td>
                        {if $is_login}
                            <td>
                                <a href="book/edit.php?id={$book["id"]}"
                                   class="btn btn-mini btn-primary">编辑</a>
                                &nbsp;
                                <a href="book/delete.php?id={$book["id"]}"
                                   class="btn btn-mini btn-danger"
                                   onclick="return confirmDelete()">删除</a>
                            </td>
                        {/if}
                    </tr>
                {/foreach}
            </table>

            {*分页*}
            {if $pagination}
                <div class="pagination">
                    <ul>
                    {for $i = 1 to $page_total}
                        <li class="{if $i == $page_current}active{/if}">
                            <a href="index.php?page={$i}">{$i}</a>
                        </li>
                    {/for}
                    </ul>
                </div>
            {/if}
        {else}
            <p>没有书籍</p>
        {/if}
    {/block}
    {block name="sidebar"}
    {/block}
