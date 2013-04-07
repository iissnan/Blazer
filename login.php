<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");

    if (isset($_SESSION["user"])) {
        echo "<script>location.href='list.php';</script>";
    }

    require_once("class/user.class.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>登录</title>
        <link rel="stylesheet" href="assets/css/admin.css"/>
    </head>

    <body>
        <div class="error" id="error"></div>
        <?php
            if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
                $isValidate = true;
                $email = trim($_POST["email"]);
                $password = trim($_POST["password"]);

                if ($email == "" || !preg_match("/[-\w\.]+@(?:[a-zA-Z0-9]+\.)*[a-zA-Z0-9]+/", $email)) {
                    $isValidate = false;
                    echo "<div class='error' id='error' style='display: block'>请输入正确的登录邮箱地址</div>";
                }

                if ($password == "") {
                    $isValidate = false;
                    echo "<div class='error' id='error' style='display: block'>请输入登录密码</div>";
                }

                if ($isValidate) {
                    $user_instance = new User();
                    $user = $user_instance->get($email, $password);
                    if ($user->error == 0) {
                        $_SESSION["user"] = $user;
                        echo "<script>location.href='list.php';</script>";
                    } else {
                        echo "<div class='error' id='error' style='display: block'>$user->msg</div>";
                    }
                }

            }
        ?>
        <form action="login.php" method="post" id="J_LoginForm">
            <p>
                <label for="email">登录邮箱</label> <br />
                <input type="text" name="email" id="email"
                       value="<?php echo isset($_POST["email"]) ? $_POST["email"] : "";?>" />
            </p>
            <p>
                <label for="password">登录密码</label> <br />
                <input type="password" name="password" id="password"
                       value="<?php echo isset($_POST["password"]) ? $_POST["password"] : "";?>" />
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
                        if (emailInput.value === "") {
                            error.innerHTML = "请输入登录邮箱";
                            error.style.display = "block";
                            return false;
                        }
                        if (passwordInput.value === "") {
                            error.innerHTML = "请输入登录密码";
                            error.style.display = "block";
                            return false;
                        }
                    };
                }
            }());
        </script>
    </body>
</html>
