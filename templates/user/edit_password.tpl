<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>密码设置</title>
    <link rel="shortcut icon" href="../assets/img/favicon.ico"/>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/gbootstrap.css"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
</head>

<body>
    {include file="../include/header.tpl"}
    <div class="admin-wrap container">
        <div class="row">
            <div class="span12">
                <div class="admin-main">
                    {$alert}
                    <form action="edit_password.php" method="post" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="old-password">旧密码：</label>
                            <div class="controls">
                                <input type="password" name="old_password" id="old-password"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="new-password">新密码：</label>
                            <div class="controls">
                                <input type="password" name="new_password" id="new-password"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="re-password">确认新密码：</label>
                            <div class="controls">
                                <input type="password" name="re_password" id="re-password"/>
                            </div>
                        </div>
                        <div class="control-group mt30">
                            <label for="submit" class="control-label"></label>
                            <div class="controls">
                                <input type="submit" value="更  改" class="btn-primary"/>
                            </div>
                        </div>
                        <input type="hidden" name="submit" value="yes"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../assets/vendor/jquery/jquery.min.js"></script>
</body>
</html>