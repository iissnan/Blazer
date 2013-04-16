{extends "layout.tpl"}
{block "content"}
    <div class="nav-position clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">书籍：{$book->title}</li>
        </ul>
    </div>
    {$alert}
    <div class="book-detail">
        <img src="{$book->cover}" alt="{$book->title}" class="pull-left cover"/>
        <div class="info">
            <p class="title">{$book->title}</p>
            <p class="author">作者：{$book->author}</p>
            <p>ISBN: {$book->isbn}</p>
            <p>页数：{$book->pages}</p>
            <p>类别：{$book->category}</p>
            {if $book->douban_link}
                <p><a href="{$book->douban_link}" target="_blank">豆瓣链接</a></p>
            {/if}
        </div>
        <div class="intro">
            {$book->intro}
        </div>
    </div>
{/block}

{block "sidebar"}{/block}