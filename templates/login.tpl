<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>登录</title>
    <link rel="stylesheet" href="assets/css/admin.css"/>
</head>

<body>
    {$error}
    <form action="login.php" method="post" id="J_LoginForm">
        <p>
            <label for="email">登录邮箱</label> <br />
            <input type="text" name="email" id="email" value="{$email}" />
        </p>
        <p>
            <label for="password">登录密码</label> <br />
            <input type="password" name="password" id="password" value="{$password}" />
        </p>

        <p>
            <input type="submit" value="登录"/>
        </p>
        <input type="hidden" name="submitted" value="yes"/>
    </form>
    <script type="text/javascript">
        (function(){
            "use strict";
            var loginForm = document.getElementById("J_LoginForm");
            if (loginForm) {
                var emailInput = document.getElementById("email");
                var passwordInput = document.getElementById("password");
                var error = document.getElementById("error");
                loginForm.onsubmit = function () {
                    var error = document.getElementById("error");
                    if (!error) {
                        error = document.createElement("div");
                        error.setAttribute("id", "error");
                        document.body.insertBefore(error, document.body.childNodes[0]);
                    }
                    if (emailInput.value === "") {
                        error.innerHTML = "请输入登录邮箱";
                        error.setAttribute("class", "error");
                        return false;
                    }
                    if (passwordInput.value === "") {
                        error.innerHTML = "请输入登录密码";
                        error.setAttribute("class", "error");
                        return false;
                    }
                };
            }
        }());
    </script>
</body>
</html>