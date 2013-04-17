{extends "layout.tpl"}
{block name="header_link"}
    <style type="text/css">
        .current-avatar img{
            vertical-align: bottom;
        }
    </style>
{/block}
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
            <li class="active">设置头像</li>
        </ul>
    </div>
{/block}
{block name="content"}

    {$alert}
    <form action="edit_avatar.php" method="post" enctype="multipart/form-data" class="form-inline">
        <div class="current-avatar">
            <span>当前头像：</span>
            <span class="controls">
                <img src="{$current_avatar}" class="img-rounded" alt="" width="120" />
                &nbsp;
                <img src="{$current_avatar}" class="img-rounded" alt="" width="80" />
                &nbsp;
                <img src="{$current_avatar}" class="img-rounded" alt="" width="40" />
            </span>
        </div>
        <div class="control-group mt30">
            <label for="update-custom" class="control-label inline">更新头像： </label>
            <input type="file" name="avatar" id="update-custom" class="inline"/>
        </div>
        <div class="control-group mt30">
            <input type="submit" value="立即更新" class="btn-primary"/>
        </div>
        <input type="hidden" name="submit" value="yes"/>
    </form>
{/block}
{block name="sidebar"}

{/block}
