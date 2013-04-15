{extends "layout.tpl"}
{block name="content"}
    <p class="alert alert-{$alert_type}">{$action}{$result}</p>
    <p>
        <a href="/index.php">返回书架</a>
        |
        <a href="add.php">添加书籍</a>
    </p>
{/block}
{block name="sidebar"}

{/block}
