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
            <li class="active">更新信息</li>
        </ul>
    </div>
{/block}
{block name="content"}
    {include file="include/alert.tpl"}
    <form action="edit_profile.php" method="post" class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="email">登录邮箱</label>
            <div class="controls">
                <input type="text" id="email" readonly="readonly" value="{$user->email|escape:'email'}" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="username">用户名：</label>
            <div class="controls">
                <input type="text" name="username" id="username" value="{$username|escape:'html'}"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="signature">
                签  名：
            </label>
            <div class="controls">
                <textarea name="signature" rows="4" id="signature">{$signature|escape:'html'}</textarea>
                <span class="label label-important">限140字以内</span>
            </div>
        </div>
        <div class="control-group mt30">
            <label for="submit" class="control-label"></label>
            <div class="controls">
                <input type="submit" value="更  新" class="btn-primary"/>
            </div>
        </div>
        <input type="hidden" name="submitted" value="yes"/>
    </form>
{/block}

{block name="sidebar"}
    {include "user/user_sidebar.tpl"}
{/block}