<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>编辑书籍</title>
    <link rel="stylesheet" href="../assets/css/admin.css"/>
</head>

<body>
    {include file="./include/header.tpl"}
    {$error}
    <form action="edit.php" method="post" enctype="multipart/form-data" id="J_FormAdd">
        <input type="hidden" name="id" value="{$book->id}"/>
        <p>
            <label for="title">标题</label>
            <input type="text" name="title" id="title" value="{$book->title}" />
        </p>
        <p>
            <label for="author">作者</label>
            <input type="text" name="author" id="author" value="{$book->author}" />
        </p>
        <p>
            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" id="isbn" value="{$book->isbn}" />
        </p>
        <p>
            <label for="cover">封面</label>
            <img width="106" height="150" src="../{$book->cover}" />
            <input type="hidden" name="current-cover" value="{$book->cover}"/>
            <input type="file" name="cover" id="cover" />
        </p>
        <p>
            <label for="category">分类</label>
            <input type="text" name="category" id="category" value="{$book->category}"/>
        </p>
        <p>
            <label for="douban-link">豆瓣链接</label>
            <input type="text" name="douban_link" id="douban-link" value="{$book->douban_link}"/>
        </p>

        <p>
            <input type="submit" id="J_ActionAdd" value="提交" />
        </p>

        <input type="hidden" name="submitted" value="yes"/>
    </form>
</body>
</html>