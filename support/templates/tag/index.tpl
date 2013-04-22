{extends "layout.tpl"}
{block "safari"}
    <div class="safari clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">
                图书标签
            </li>
        </ul>
    </div>
{/block}
{block "content"}
    {include "include/alert.tpl"}
    {if !$error}
        {while $tag = $tags->fetch_object()}
            <a href="/tag/tag.php?tagname={$tag->name|escape:'html'}">{$tag->name|escape:'html'}</a> &nbsp;&nbsp;
        {/while}
    {/if}
{/block}
{block "footer_link"}{/block}