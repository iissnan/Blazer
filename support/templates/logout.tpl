{extends "entry.tpl"}
{block "header_link"}
    {literal}
        <style type="text/css">
            .logout{margin: 20px;}
        </style>
    {/literal}
{/block}
{block "safari"}
    <div class="safari">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php"><i class="icon-home"></i>返回首页</a>
            </li>
        </ul>
    </div>
{/block}
{block "main"}
    <div class="logout">
        <p class="alert alert-info">已退出登录</p>
        <ul>
            <li><a href="login.php">重新登录</a></li>
        </ul>

    </div>
{/block}

