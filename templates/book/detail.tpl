{extends "layout.tpl"}
{block "safari"}
    <div class="safari clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">
                {if !$error}
                    书籍：{$book->title|escape:'html'}</li>
                {/if}
        </ul>
        <div class="actions">

            {if $user->group == "admin" || $user->id !== $book->creator}
                    &nbsp;
                    <a class="btn btn-primary btn-small" href="edit.php?id={$book->id}">编辑</a>
                    {if $user->group == "admin"}
                        &nbsp;
                        <a class="btn btn-danger btn-small action-book-delete" href="delete.php?id={$book->id}">删除</a>
                    {/if}
            {/if}
        </div>
    </div>
{/block}
{block "content"}
    {if $error}
        {$alert}
        <ul>
            <li><a href="/index.php">返回首页</a></li>
            <li><a href="/user/favorite.php">我的藏书</a></li>
        </ul>
    {else}
        <div class="book-detail clearfix">
            <img src="{$book->cover}" alt="{$book->title|escape:'html'}" class="pull-left cover img-polaroid"/>
            <div class="info">
                <h1 class="title">{$book->title|escape:'html'}</h1>
                <p class="author">作者：{$book->author|escape:'html'}</p>
                <p>ISBN: {$book->isbn|escape:'html'}</p>
                <p>页数：{$book->pages|escape:'html'}</p>
                <p>类别：{$book->category|escape:'html'}</p>
                {if $book->douban_link|escape:'html'}
                    <p><a href="{$book->douban_link|escape:'html'}" target="_blank">豆瓣链接</a></p>
                {/if}
            </div>
        </div>
        {if $is_login}
            <div class="action-position-edit">
                <a class="btn btn-primary btn-small" href="/position/add.php?book_id={$book->id}">更新我的进度</a>
            </div>
        {/if}
        {if $book->intro|escape:'html' != "" }
            <div class="form-divider">内容简介</div>
            <div class="intro">{$book->intro|escape:'html'}</div>
        {/if}
    {/if}
{/block}

{block "sidebar"}{/block}
{block "footer_link"}
    <script type="text/javascript" src="/assets/js/book.js"></script>
{/block}