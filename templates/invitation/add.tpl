{extends "layout.tpl"}
{block name="content"}
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
            <li>
                <a href="/invitation/index.php">我的邀请码</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">添加邀请码</li>
        </ul>
    </div>
    <p class="alert alert-{$alert_type}">添加{$result}</p>
    {if $alert_type == "success"}
        <p>
            新生成的邀请码： <span class="label label-info">{$invitation}</span><br />
            个数： <span class="label label-important">5</span>
        </p>
    {/if}
    <p>
        <a href="index.php">返回我的邀请码</a>
        |
        <a href="/index.php">返回书架</a>
    </p>
{/block}

{block name="sidebar"}

{/block}
