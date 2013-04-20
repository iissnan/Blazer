{extends "layout.tpl"}
{block "safari"}
    <div class="nav-position clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">操作结果</li>
        </ul>
    </div>
{/block}
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
