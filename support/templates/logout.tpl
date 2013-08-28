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
        <p><a href="login.php">重新登录</a></p>
        <p class="pull-right"><span class="label label-important" id="countdown">10</span> 秒之后跳转到首页</p>
        <script type="text/javascript">
            (function () {
                var countdown = document.getElementById("countdown");
                var i = 10;
                setInterval(function() {
                    countdown.innerHTML = --i;
                    if (i === 0) {
                        location.href = "/";
                    }
                }, 1000);
            }());
        </script>
    </div>
{/block}

