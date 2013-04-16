<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{$page_title}</title>
    <link rel="shortcut icon" href="/assets/img/favicon.ico"/>
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/css/gbootstrap.css"/>
    <link rel="stylesheet" href="/assets/css/main.css"/>
    {block name="header_link"}{/block}
</head>

<body>
    <div id="navigation" >
        <div class="navbar navbar-static-top navbar-inverse">
            <div class="navbar-inner">
                <div class="container">
                    {*<a href="index.php" class="brand">BookShelf</a>*}
                    <ul class="nav">
                        <li><a href="/index.php">书架</a>
                        <li><a href="/user/favorite.php">我的收藏</a></li>
                    </ul>
                    <ul class="nav pull-right">
                        {if $is_login}
                            <li><a href="/user/index.php">设置</a></li>
                            <li><a href="/logout.php">退出登录</a></li>
                        {else}
                            {*
                            <li><a href="/login.php">登录</a></li>
                            <li class="divider-vertical"></li>
                            <li><a href="/register.php">注册</a></li>
                            *}
                        {/if}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="admin-wrap container">
        <div class="row">
            <div class="span9 box-wrap">
                <div class="box">
                    {block name="content"}{/block}
                </div>
            </div>
            <div class="span3 box-wrap sidebar">
                {if $is_login }
                    <div class="user-profile">
                        <div class="user-summary clearfix">
                            <img src="{if $user->avatar == ""}
                                    /assets/avatar/default.png
                                    {else}
                                    /assets/avatar/{$user->avatar}
                                    {/if}
                                    "
                                 alt="{$user->nickname}" class="img-rounded pull-left" style="max-width: 64px; margin-right: 10px"/>
                            <p class="pull-left">{$user->nickname}</p>
                        </div>
                    </div>
                {/if}
                {block name="sidebar"}
                {/block}
            </div>
        </div>
    </div>
    {block name="footer_link"}{/block}
</body>
</html>
