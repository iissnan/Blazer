{extends "layout.tpl"}
{block "safari"}

{/block}
{block "content"}
    {include "include/alert.tpl"}
    {if $error}
        <a href="javascript:history.go(-1);">返回</a>
    {/if}
{/block}