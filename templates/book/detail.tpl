{extends "layout.tpl"}
{block "safari"}
    <div class="nav-position clearfix">
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
                <p class="title">{$book->title|escape:'html'}</p>
                <p class="author">作者：{$book->author|escape:'html'}</p>
                <p>ISBN: {$book->isbn|escape:'html'}</p>
                <p>页数：{$book->pages|escape:'html'}</p>
                <p>类别：{$book->category|escape:'html'}</p>
                {if $book->douban_link|escape:'html'}
                    <p><a href="{$book->douban_link|escape:'html'}" target="_blank">豆瓣链接</a></p>
                {/if}
            </div>
            <div class="intro">
                {$book->intro|escape:'html'}
            </div>
        </div>
    {/if}
{/block}

{block "sidebar"}{/block}