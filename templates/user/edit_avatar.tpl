<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>头像设置</title>
    <link rel="shortcut icon" href="../assets/img/favicon.ico"/>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/gbootstrap.css"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <style type="text/css">
        .current-avatar img{
            vertical-align: bottom;
        }
    </style>
</head>

<body>
    {include file="../include/header.tpl"}
    <div class="admin-wrap container">
        <div class="row">
            <div class="span12">
                <div class="admin-main">
                    {$alert}
                    <form action="edit_avatar.php" method="post" enctype="multipart/form-data" class="form-inline">
                        <div class="current-avatar">
                            <span>当前头像</span>
                            <span class="controls">
                                {if $current_avatar != ""}
                                    <img src="{$current_avatar}" class="img-rounded" alt="" width="120" />
                                    &nbsp;
                                    <img src="{$current_avatar}" class="img-rounded" alt="" width="80" />
                                    &nbsp;
                                    <img src="{$current_avatar}" class="img-rounded" alt="" width="40" />
                                {else}
                                    <img src="../assets/img/default_avatar.png" alt="默认头像"
                                            width="120" class="img-rounded"/>
                                    &nbsp;
                                    <img src="../assets/img/default_avatar.png" alt="默认头像"
                                         width="80" class="img-rounded"/>
                                    &nbsp;
                                    <img src="../assets/img/default_avatar.png" alt="默认头像"
                                         width="40" class="img-rounded"/>
                                {/if}
                            </span>
                        </div>
                        <div class="control-group mt30">
                            <label for="update-custom" class="control-label inline">更新</label>
                            <input type="file" name="avatar" id="update-custom" class="inline"/>
                        </div>
                        <div class="control-group mt30">
                            <input type="submit" value="立即更新" class="btn-primary"/>
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