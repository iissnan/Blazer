<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{$page_title} - 6unt</title>
    <link rel="shortcut icon" href="/assets/img/favicon.ico"/>
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="/assets/css/gbootstrap.css"/>
    <link rel="stylesheet" href="/assets/css/main.css?t=20130827"/>
    <link href='http://fonts.googleapis.com/css?family=Graduate' rel='stylesheet' type='text/css'>
    {block name="header_link"}{/block}
</head>

<body>
    <div id="navigation" >
        <div class="navbar navbar-static-top navbar-inverse">
            <div class="navbar-inner">
                <div class="container">
                    <a href="/" class="brand">six unit</a>
                    <button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            {if $is_login}
                            <li><a href="/user/index.php">{$user->username|escape:'html'}的账号</a></li>
                            <li><a href="/position/index.php">我的进度</a></li>
                            <li><a href="/user/favorite.php">我的收藏</a></li>
                            <li><a href="/logout.php">退出登录</a></li>
                            {else}
                            <li><a href="/login.php">登录</a></li>
                            <li><a href="/register.php">注册</a></li>
                            {/if}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrap container">
        <div class="row">
            <div class="span9 box-wrap main">
                {block "safari"}{/block}
                <div class="content" id="content">{block name="content"}{/block}</div>
            </div>
            <div class="span3 sidebar" id="sidebar">
                {if $is_login }
                    <div class="user-profile">
                        <div class="user-summary clearfix">
                            <a href="/user/index.php">
                                <img src="/assets/avatar/{$user->avatar|escape:'html'|default:"default.png"}"
                                     alt="{$user->username|escape:'html'}"
                                     class="img-rounded pull-left sidebar-avatar" />
                            </a>
                            <div class="pull-left">
                                <p class="username">{$user->username|escape:'html'}</p>
                                <p class="signature" title="{$user->signature|escape:'html'}">
                                    {$user->signature|escape:'html'|truncate:13:"..."}
                                </p>
                            </div>
                        </div>
                    </div>
                {/if}
                {block name="sidebar"}
                {/block}
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/assets/vendor/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    {block name="footer_link"}{/block}
</body>
</html>
