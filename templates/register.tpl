<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>注册</title>
    <link rel="stylesheet" href="assets/css/admin.css"/>
</head>
<body>
    {$error}
    <form action="register.php" method="post" id="registerForm">
        <p>
            <label for="email">登录邮箱</label> <br />
            <input type="text" name="email" id="email" value="{$email}" />
        </p>
        <p>
            <label for="password">登录密码</label> <br />
            <input type="password" name="password" id="password" value="{$password}" />
        </p>
        <p>
            <label for="re-password">密码确认</label> <br />
            <input type="password" name="re-password" id="re-password" value="{$re_password}" />
        </p>
        <p>
            <label for="invitation">邀请码</label> <br />
            <input type="text" name="invitation" id="invitation" value="{$invitation}" />
        </p>
        <p>
            <label for="nickname">昵称</label> <br />
            <input type="text" name="nickname" id="nickname" value="{$nickname}" />
        </p>
        <p>
            <input type="submit" value="注册"/>
        </p>
        <input type="hidden" name="submitted" value="yes" />
    </form>
</body>
</html>