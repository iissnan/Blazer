<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>注册</title>
    <link rel="shortcut icon" href="assets/img/favicon.ico"/>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
</head>
<body>
    <div class="container login-wrap mt30">
        {$alert}
        <form action="register.php" method="post" id="registerForm">
            <div class="control-group">
                <label for="nickname" class="control-label">昵称</label>
                <input type="text" name="nickname" id="nickname"
                       class="control input-block-level" value="{$nickname}" />
            </div>
            <div class="control-group">
                <label for="email" class="control-label">登录邮箱</label>
                <input type="text" name="email" id="email"
                       class="control input-block-level" value="{$email}" />
            </div>
            <div class="control-group">
                <label for="password" class="control-label">登录密码</label>
                <input type="password" name="password" id="password"
                       class="control input-block-level" value="{$password}" />
            </div>
            <div class="control-group">
                <label for="re-password" class="control-label">密码确认</label>
                <input type="password" name="re-password" id="re-password"
                       class="control input-block-level" value="{$re_password}" />
            </div>
            <div class="control-group">
                <label for="invitation" class="control-label">邀请码</label>
                <input type="text" name="invitation" id="invitation"
                       class="control input-block-level" value="{$invitation}" />
            </div>
            <div class="mt30">
                <input type="hidden" name="submitted" value="yes" />
                <input type="submit" class="btn btn-large btn-primary btn-block" value="注  册"/>
            </div>

            <p class="mt30">
                <a href="login.php" class="pull-right">登录 &raquo;</a>
            </p>
        </form>
    </div>
    <script type="text/javascript" src="assets/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/account.js"></script>
</body>
</html>