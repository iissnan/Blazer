<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{$action}操作结果</title>
    <link rel="shortcut icon" href="../assets/img/favicon.ico"/>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
</head>
<body>
    {include file="./include/header.tpl"}
    <div class="admin-wrap container">
        <div class="row">
            <div class="span12">
                <div class="admin-main">
                    <p class="alert alert-{$alert_type}">{$action}{$result}</p>
                    <p>
                        <a href="list.php">返回列表</a>
                        |
                        <a href="add.php">添加书籍</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>