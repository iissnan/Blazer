<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>登录</title>
    <link rel="shortcut icon" href="assets/img/favicon.ico"/>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/gbootstrap.css"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
</head>

<body>
    <div class="container login-wrap">
        {$alert}
        <form action="login.php" method="post" id="J_LoginForm">
            <div class="control-group">
                <label for="email" class="control-label">登录邮箱</label>
                <input type="text" name="email" id="email"
                       class="input-block-level" value="{$email}" />
            </div>

            <div class="control-group">
                <label for="password" class="control-label">登录密码</label>
                <input type="password" name="password" id="password"
                       class="input-block-level" value="{$password}" />
            </div>

            {if $recaptcha}
                <div class="control-group">
                    <label class="control-label" for="recaptcha">验证码</label>
                    <div class="controls">
                        {$recaptcha}
                    </div>
                </div>
            {/if}

            <label for="remember" class="checkbox">
                <input type="checkbox" name="remember" id="remember" />  下次自动登录?
            </label>

            <div class="mt30">
                <input type="submit" class="btn btn-primary btn-block btn-large" value="登    录"/>
                <input type="hidden" name="submitted" value="yes"/>
            </div>
            <p class="mt30 pull-right">
                <a href="register.php">立即注册 &raquo;</a>
            </p>
        </form>
    </div>

    <script type="text/javascript" src="assets/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/account.js"></script>
</body>
</html>