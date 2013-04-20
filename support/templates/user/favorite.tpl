{extends "layout.tpl"}
{block "safari"}
    <div class="nav-position clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li>
                <a href="/user/index.php">{$user->username|escape:'html'}</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">我的收藏</li>
        </ul>
    </div>
{/block}
{block name="content"}

    我的收藏
{/block}
{block name="sidebar"}
    {include "user/user_sidebar.tpl"}
{/block}
