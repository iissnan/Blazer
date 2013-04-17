{extends "layout.tpl"}
{block name="content"}
    <div class="nav-position clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">{$user->username|escape:'html'}</li>
        </ul>
    </div>
    <a href="edit_avatar.php">更新头像</a>
    <a href="edit_password.php">修改密码</a>
    {*<a href="/invitation/index.php">邀请码</a>*}
{/block}

{block name="sidebar"}

{/block}
