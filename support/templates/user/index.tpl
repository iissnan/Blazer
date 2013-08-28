{extends "layout.tpl"}
{block "header_link"}
    {literal}
        <style type="text/css">
            .form-divider{margin-top: 25px;}
            .profile .avatar{margin-right: 20px;}
            .summary h1{margin: 0 0 10px; font-size: 20px; line-height: 30px; color: #333;}
            .summary p{margin-left: 5px; color: #999;}
            .user-info{margin: 10px;}
                .user-info table{}
                    .user-info td{padding: 5px;}
                    .user-info .td-right{text-align: right;}
        </style>
    {/literal}
{/block}
{block "safari"}
    <div class="nav-position clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">{$view_user->username|escape:'html'}</li>
        </ul>
    </div>
{/block}
{block name="content"}
    {include "include/alert.tpl"}
    {if !$error}
        <div class="profile clearfix">
            <img class="img-rounded pull-left avatar" width="100"
                 src="/assets/avatar/{$view_user->avatar} " alt="{$view_user->username|escape:'html'}"/>
            <div class="summary pull-left">
                <h1>
                    {$view_user->username|escape:'html'|upper}
                    {if $is_self}<span class="badge badge-important">这是我</span>{/if}
                </h1>
                <p>
                    <i class="icon-flag"></i> 第{$view_user->id}位成员
                </p>
                <p><i class="icon-time"></i> 加入于{$view_user->create_at}</p>
            </div>
        </div>
        <div class="form-divider">
            {if $is_self}
                我
            {else}
                {$view_user->username|escape:'html'}
            {/if}
            的信息
        </div>
        <table class="user-info">
            <tr>
                <td class="td-right">登录邮箱：</td>
                <td>{$view_user->email|escape:'email'}</td>
            </tr>
            <tr>
                <td class="td-right">签名：</td>
                <td>{$view_user->signature|escape:'html'}</td>
            </tr>
            <tr>
                <td class="td-right">上次登录于：</td>
                <td>{$view_user->last_login_at}</td>
            </tr>
            <tr>
                <td class="td-right">登录次数：</td>
                <td>{$view_user->times}</td>
            </tr>
        </table>
        <div class="form-divider">
            {if $is_self}
                我
            {else}
                {$view_user->username|escape:'html'}
            {/if}
            最近创建的书籍
        </div>
        {if $books}
            <ul>
                {while $book = $books->fetch_object()}
                        <li>
                            <a href="/book/detail.php?id={$book->id}">{$book->title}</a>
                        </li>
                {/while}
            </ul>
        {else}
        {/if}
    {/if}
{/block}

{block name="sidebar"}
    {include "user/user_sidebar.tpl"}
{/block}
