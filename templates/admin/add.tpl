<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>添加书籍</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/admin.css"/>
</head>

<body>
    {include file="./include/header.tpl"}
    <div class="container">
        <div class="row">
            <div class="span12">
                {$error}
                <form action="add.php" method="post" enctype="multipart/form-data" id="J_FormAdd">
                    <p>
                        <label for="title">标题</label>
                        <input type="text" name="title" id="title" value="{$title}" />
                    </p>
                    <p>
                        <label for="author">作者</label>
                        <input type="text" name="author" id="author" value="{$author}" />
                    </p>
                    <p>
                        <label for="isbn">ISBN</label>
                        <input type="text" name="isbn" id="isbn" value="{$isbn}" />
                    </p>
                    <p>
                        <label for="cover">封面</label>
                        <input type="file" name="cover" id="cover" />
                    </p>
                    <p>
                        <label for="category">分类</label>
                        <input type="text" name="category" id="category" value="{$category}"/>
                    </p>
                    <p>
                        <label for="douban-link">豆瓣链接</label>
                        <input type="text" name="douban_link" id="douban-link" value="{$douban_link}"/>
                    </p>

                    <p>
                        <input type="hidden" name="submitted" value="yes"/>
                        <input type="submit" id="J_ActionAdd" value="提交" class="btn btn-primary " />
                    </p>

                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../assets/vendor/jquery/jquery.min.js"></script>
</body>
</html>