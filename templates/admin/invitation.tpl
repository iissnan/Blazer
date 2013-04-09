<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>邀请码列表</title>
    <link rel="shortcut icon" href="../assets/img/favicon.ico"/>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/gbootstrap.css"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
</head>
<body>
    {include file="./include/header.tpl"}
    <div class="admin-wrap container">
        <div class="row">
            <div class="span12">
                <div class="admin-main">
                    <div class="action">
                        <a href="invitation_add.php" class="btn btn-primary pull-right">生  成</a>
                    </div>
                    {if $invitations_size > 0}
                        <table class="table">
                            <thead>
                            <tr>
                                <th>邀请码</th>
                                <th>剩余次数</th>
                            </tr>
                            </thead>
                            {while $invitation = $invitations->fetch_object()}
                                <tr>
                                    <td>{$invitation->value}</td>
                                    <td>{$invitation->number}</td>
                                </tr>
                            {/while}
                        </table>
                    {else}
                        <p>没有邀请码</p>
                    {/if}
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../assets/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/admin.js"></script>
</body>
</html>