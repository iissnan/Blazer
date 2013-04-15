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
                        <li><a href="/login.php">登录</a></li>
                        <li class="divider-vertical"></li>
                        <li><a href="/register.php">注册</a></li>
                    {/if}
                </ul>
            </div>
        </div>
    </div>
</div>