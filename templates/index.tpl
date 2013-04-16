{extends "layout.tpl"}
    {block name="content"}
        <div class="nav-position clearfix">
            <ul class="breadcrumb">
                <li><a href="/index.php">首页</a></li>
            </ul>
            {if $is_login}
                <a href="book/add.php" class="btn btn-primary action-add-book">添  加</a>
            {/if}
        </div>
        {if $total > 0}
            <ul class="cover-list clearfix">
                {foreach $books as $book}
                    <li {if ($book@index+1) % 5 == 0}class="last"{/if}>
                        <a href="book/detail.php?id={$book["id"]}">
                            <div class="book-info">
                                <dl>
                                    <dt>{$book["title"]}</dt>
                                    <dd>{$book["author"]}</dd>
                                </dl>
                            </div>
                            <img src="
                                {if $book["cover"] == ""}
                                    ../assets/cover/default.png
                                {else}
                                    ../assets/cover/{$book["cover"]}
                                {/if}"
                                 alt="{$book["title"]}"
                            />
                        </a>
                    </li>
                {/foreach}
            </ul>

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
        {if not $is_login}
            <div class="box">
                <div class="box-header">
                    <i class="icon-user"></i>
                    用户登录
                    <a href="register.php" class="pull-right">注  册 &raquo;</a>
                </div>
                <div class="box-body">
                    <form action="login.php" method="post" >
                        <input id="email" type="text"  name="email" placeholder="登录邮箱"
                                class="email input-block-level"/>
                        <input type="password" name="password" placeholder="登录密码"
                             class="password input-block-level" id="password" />
                        <div class="control-group">
                            <label class="checkbox">
                                <input type="checkbox" name="remember" />下次自动登录？
                            </label>
                        </div>
                        <input class="btn btn-primary btn-block" type="submit" value="登  录"/>
                        <input type="hidden" name="submitted" value="yes"/>
                    </form>
                </div>
            </div>
        {/if}
    {/block}
