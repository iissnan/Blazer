<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{$page_title}</title>
    <link rel="shortcut icon" href="/assets/img/favicon.ico"/>
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/css/gbootstrap.css"/>
    <link rel="stylesheet" href="/assets/css/main.css"/>
    {block "header_link"}{/block}
</head>
<body>
    <div class="container entry-wrap mt30 {$page_class}">
        {block "safari"}{/block}
        {block "main"}{/block}
    </div>
    <script type="text/javascript" src="/assets/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/js/account.js"></script>
    {block "footer_link"}{/block}
</body>
</html>