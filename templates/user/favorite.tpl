{extends "layout.tpl"}
{block name="content"}
    <div class="nav-position clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li>
                <a href="/user/index.php">{$user->nickname}</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">我的收藏</li>
        </ul>
    </div>
    我的收藏
{/block}
{block name="sidebar"}

{/block}
