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
        <title>注册</title>
        <link rel="stylesheet" href="assets/css/admin.css"/>
    </head>
    <body>
        <?php
            if ($_POST["submitted"] == "yes") {
                $email = trim($_POST["email"]);
                $password = trim($_POST["password"]);
                $re_password = trim($_POST["re-password"]);
                $nickname = trim($_POST["nickname"]);

                $isValidate = true;
                if ($email == "" || preg_match("/[-\w\.]+@(?:[a-zA-Z0-9]+\.)*[a-zA-Z0-9]+/", $email)) {
                    $isValidate = false;
                    echo "<div class='error' id='error' style='display:block'>登录邮箱有误</div>";
                }
                if ($password == "") {
                    $isValidate = false;
                    echo "<div class='error' id='error' style='display:block'>密码不能为空</div>";
                }
                if ($password != $_POST["re-password"]) {
                    $isValidate = false;
                    echo "<div class='error' id='error' style='display:block'>确认密码不匹配</div>";
                }
                if ($nickname == "") {
                    $isValidate = false;
                    echo "<div class='error' id='error' style='display:block'>昵称不能为空</div>";
                }

                if ($isValidate) {
                    $user = new User();
                    if ($user->add($email, $password, $nickname)) {
                        echo "<script>location.href = 'login.php';</script>";
                    } else {
                        echo "<div class='error' id='error'>注册失败，请稍后再试</div>";
                    }
                }
            }
        ?>
        <form action="register.php" method="post" id="registerForm">
            <p>
                <label for="email">登录邮箱</label> <br />
                <input type="text" name="email" id="email" value="<?php echo $_POST["email"];?>"/>
            </p>
            <p>
                <label for="password">登录密码</label> <br />
                <input type="password" name="password" id="password" value="<?php echo $_POST["password"];?>"/>
            </p>
            <p>
                <label for="re-password">密码确认</label> <br />
                <input type="password" name="re-password" id="re-password" value="<?php echo $_POST["re-password"];?>"/>
            </p>
            <p>
                <label for="invitation">邀请码</label> <br />
                <input type="text" name="invitation" id="invitation" value="<?php echo $_POST["invitation"];?>"/>
            </p>
            <p>
                <label for="nickname">昵称</label> <br />
                <input type="text" name="nickname" id="nickname" value="<?php echo $_POST["nickname"];?>"/>
            </p>
            <p>
                <input type="submit" value="注册"/>
            </p>
            <input type="hidden" name="submitted" value="yes" />
        </form>
    </body>
</html>
