<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>邀请码添加结果</title>
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
                    <p class="alert alert-{$alert_type}">添加{$result}</p>
                    {if $alert_type == "success"}
                    <p>
                        新生成的邀请码： <span class="label label-info">{$invitation}</span><br />
                        个数：5
                    </p>
                    {/if}
                    <p>
                        <a href="invitation.php">返回邀请码列表</a>
                        |
                        <a href="list.php">返回书籍列表</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>