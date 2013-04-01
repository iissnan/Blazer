<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");

    if (!isset($_SESSION["user"])) {
        echo "<script>location.href='login.php';</script>";
    }

    require_once("class/book.class.php");
    $book_instance = new Book();

    // 提交数据
    if ($_POST["submitted"] == "yes") {
        $title = $_POST["title"];

        if ($title == "") {
            echo "标题不能为空";
        }
        $id = $_POST["id"];
        $author = $_POST["author"];
        $category = $_POST["category"];
        $isbn = $_POST["isbn"];
        if ($_FILES["cover"]["name"] != "") {
            $cover = $_FILES["cover"];
        } else {
            $cover = $_POST["current-cover"];
        }
        $douban_link = $_POST["douban_link"];

        $result = $book_instance->update($id, $title, $author, $isbn, $category, $cover, $douban_link);
        echo "<script>location.href='edit_result.html?code=" . $result . "';</script>";
    } else {
        // 获取数据
        if (isset($_GET["id"])) {
            $id = (int)$_GET["id"];
            $book = $book_instance->get($id);
            if ($book->num_rows > 0) {
                $book = $book->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>编辑书籍</title>
    <link rel="stylesheet" href="assets/css/admin.css"/>
</head>

<body>
    <?php
        require_once("inc/admin_header.php");
    ?>
    <div id="error" class="error"></div>
    <form action="edit.php" method="post" enctype="multipart/form-data" id="J_FormAdd">
        <input type="hidden" name="id" value="<?php echo $book["id"];?>"/>
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
            <input type="hidden" name="current-cover" value="<?php echo $book["cover"]?>"/>
            <input type="file" name="cover" id="cover" />
        </p>
        <p>
            <label for="category">分类</label>
            <input type="text" name="category" id="category" value="<?php echo $book["category"]; ?>"/>
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