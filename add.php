<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    if (!isset($_SESSION["user"])) {
        echo "<script>location.href='login.php';</script>";
    }

    require_once "class/book.class.php";

    if ($_POST["submitted"] == "yes") {
        $title = trim($_POST["title"]);
        $author = trim($_POST["author"]);
        $isbn = trim($_POST["isbn"]);
        $category = trim($_POST["category"]);
        $douban_link = trim($_POST["douban_link"]);
        $cover = $_FILES["cover"];

        // title为必需值
        if ($title == "") {
            echo "请输入标题";
            exit();
        }

        $book_instance = new Book();
        $result = $book_instance->add($title, $author, $isbn, $cover, $category, $douban_link);
        echo "<script>location.href = 'add_result.html?code=" . $result . "';</script>";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>添加书籍</title>
        <link rel="stylesheet" href="assets/css/admin.css"/>
    </head>

    <body>
        <?php
            require_once("inc/admin_header.php");
        ?>
        <div id="error" class="error"></div>
        <form action="add.php" method="post" enctype="multipart/form-data" id="J_FormAdd">
            <p>
                <label for="title">标题</label>
                <input type="text" name="title" id="title" />
            </p>
            <p>
                <label for="author">作者</label>
                <input type="text" name="author" id="author" />
            </p>
            <p>
                <label for="isbn">ISBN</label>
                <input type="text" name="isbn" id="isbn" />
            </p>
            <p>
                <label for="cover">封面</label>
                <input type="file" name="cover" id="cover" />
            </p>
            <p>
                <label for="category">分类</label>
                <input type="text" name="category" id="category"/>
            </p>
            <p>
                <label for="douban-link">豆瓣链接</label>
                <input type="text" name="douban_link" id="douban-link"/>
            </p>

            <p>
                <input type="button" id="J_ActionAdd" value="提交" />
            </p>

            <input type="hidden" name="submitted" value="yes"/>
        </form>
        <script type="text/javascript" src="assets/js/admin.js"></script>
    </body>
</html>
