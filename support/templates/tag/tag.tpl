{extends "layout.tpl"}
{block "header_link"}
    {literal}
        <style type="text/css">
            .book-cover{
                margin-right: 10px;
            }
            .book-title{
                margin-bottom: 10px;
            }
            .book-list li{
                margin-bottom: 10px;
            }
        </style>
    {/literal}
{/block}
{block "safari"}
    <div class="safari clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li>
                <a href="/tag/index.php">标签</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">
                {$tag_name|escape:'html'}
            </li>
        </ul>
    </div>
{/block}
{block "content"}
    {include "include/alert.tpl"}
    {if !$error}
        <ul class="book-list">
            {while $book = $books->fetch_object()}
                <li class="clearfix">
                    <div class="book-cover pull-left">
                        <a href="/book/detail.php?id={$book->id}">
                            <img src="/assets/cover/{$book->cover}" class="cover" alt="{$book->title|escape:'html'}" />
                        </a>
                    </div>
                    <div class="pull-left">
                        <h4>
                            <a href="/book/detail.php?id={$book->id}" class="book-title">
                                {$book->title|escape:'html'}
                            </a>
                        </h4>
                        <p>{$book->pages|escape:'html'}</p>
                        <div>{$book->info|escape:'html'}</div>
                    </div>
                </li>
            {/while}
        </ul>
    {/if}
{/block}
{block "sidebar"}{/block}
{block "footer_link"}{/block}