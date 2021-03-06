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
            <li class="active">设置密码</li>
        </ul>
    </div>
{/block}
{block name="content"}
    {include file="include/alert.tpl"}
    <form action="edit_password.php" method="post" class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="old-password">旧密码：</label>
            <div class="controls">
                <input type="password" name="old_password" id="old-password"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="new-password">新密码：</label>
            <div class="controls">
                <input type="password" name="new_password" id="new-password"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="re-password">再次输入新密码：</label>
            <div class="controls">
                <input type="password" name="re_password" id="re-password"/>
            </div>
        </div>
        <div class="control-group mt30">
            <label for="submit" class="control-label"></label>
            <div class="controls">
                <input type="submit" value="更  改" class="btn-primary"/>
            </div>
        </div>
        <input type="hidden" name="submit" value="yes"/>
    </form>
{/block}

{block name="sidebar"}
    {include "user/user_sidebar.tpl"}
{/block}
