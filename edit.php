<?php
    header("Content-Type: text/html; charset=utf-8");
    require_once("class/book.class.php");

    // 提交数据
    if ($_POST["submitted"] == "yes") {
        $title = $_POST["title"];

        if ($title == "") {
            echo "标题不能为空";
        }

        $author = $_POST["author"];
        $category = "";
        $isbn = $_POST["isbn"];
        $cover = $_FILES["cover"];
        $douban_link = $_POST["douban_link"];

        $book->update($title, $author, $isbn, $category, $cover, $douban_link);
        if (!$book) {
            echo "<p>编辑失败</p>";
        } else {
            echo "<p>编辑成功</p>";
            echo "<p><a href='list.php'>返回列表</a> | <a href='add.php'>添加书籍</a>";
        }
    } else {
        // 获取数据
        if (isset($_GET["id"])) {
            $id = (int)$_GET["id"];
            $book_instance = new Book();
            $book = $book_instance->get($id);
            if ($book->num_rows > 0) {
                $book = $book->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>添加书籍</title>
    <link rel="stylesheet" href="assets/css/admin.css"/>
</head>

<body>
    <div id="error" class="error"></div>
    <form action="add.php" method="post" enctype="multipart/form-data" id="J_FormAdd">
        <p>
            <label for="title">标题</label>
            <input type="text" name="title" id="title" value="<?php echo $book["title"] ?>" />
        </p>
        <p>
            <label for="author">作者</label>
            <input type="text" name="author" id="author" value="<?php echo $book["author"] ?>" />
        </p>
        <p>
            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" id="isbn" value="<?php echo $book["isbn"] ?>" />
        </p>
        <p>
            <label for="cover">封面</label>
            <img width="106" height="150" src="<?php echo $book["cover"]?>" />
            <input type="file" name="cover" id="cover" />
        </p>
        <p>
            <label for="douban-link">豆瓣链接</label>
            <input type="text" name="douban_link" id="douban-link" value="<?php echo $book["douban_link"] ?>"/>
        </p>

        <p>
            <input type="button" id="J_ActionAdd" value="提交" />
        </p>

        <input type="hidden" name="submitted" value="yes"/>
    </form>
    <script type="text/javascript" src="assets/js/admin.js"></script>
</body>
</html>
<?php
            } else {
                echo "<p>书籍未找到</p>";
                echo "<p><a href='list.php'>返回列表</a></p>";
            } // $book->num_rows
        } else {
            echo "<p>id参数丢失</p>";
        } // isset $_GET["id"]
    }
?>