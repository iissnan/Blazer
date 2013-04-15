<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>添加书籍</title>
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
                    <h2>添加书籍</h2>
                    {$alert}
                    <form action="add.php" method="post" enctype="multipart/form-data"
                          id="J_FormAdd" class="form-horizontal">
                        <div class="control-group">
                            <label for="title" class="control-label">标题</label>
                            <div class="controls">
                                <input type="text" name="title" id="title" value="{$title}"
                                        class="input-xlarge"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="author" class="control-label">作者</label>
                            <div class="controls">
                                <input type="text" name="author" id="author" value="{$author}"
                                        class="input-xlarge"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="isbn" class="control-label">ISBN</label>
                            <div class="controls">
                                <input type="text" name="isbn" id="isbn" value="{$isbn}"
                                       class="input-xlarge"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="cover" class="control-label">封面</label>
                            <div class="controls">
                                <input type="file" name="cover" id="cover" class="input-xlarge"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="category" class="control-label">分类</label>
                            <div class="controls">
                                <input type="text" name="category" id="category" value="{$category}"
                                       class="input-xlarge"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="douban-link" class="control-label">豆瓣链接</label>
                            <div class="controls">
                                <input type="text" name="douban_link" id="douban-link"
                                       value="{$douban_link}" class="input-xlarge"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <input type="hidden" name="submitted" value="yes"/>
                            <div class="controls">
                                <input type="submit" id="J_ActionAdd" value="添  加" class="btn btn-primary " />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../assets/vendor/jquery/jquery.min.js"></script>
</body>
</html>