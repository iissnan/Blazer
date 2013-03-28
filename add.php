<?php
    header("Content-Type: text/html; charset=utf-8");
    require_once("dbc.class.php");

    $title = trim($_POST["title"]);
    $author = trim($_POST["author"]);
    $isbn = trim($_POST["isbn"]);

    // title为必需值
    if ($title == "") {
        echo "请输入标题";
        exit();
    }

    // 封面处理
    define("DIR_COVER", "cover");
    define("MAX_SIZE", 500000); // 500K
    if (! is_dir(DIR_COVER)) {
        mkdir(DIR_COVER);
    }

    $allow_mimes = array("image/png", "image/jpeg", "image/gif");
    $cover = $_FILES["cover"];
    if ($cover["size"] == 0) {}
    if ($cover["size"] > MAX_SIZE) {
        echo "图片大小必需小于500K";
        exit();
    }
    if (! in_array($cover["type"], $allow_mimes)) {
        echo "仅支持PNG, GIF和JPG格式的图片";
        exit();
    }
    if (!move_uploaded_file($cover["tmp_name"], DIR_COVER . '/' . $cover["name"])) {
        echo "图片上传失败";
    } else {
        $cover = DIR_COVER . "/" . $cover["name"];
    }

    $dbc = new DatabaseConnection("localhost", "root", "123456", "bookshelf");
    $result = $dbc->insert(
        "books",
        array("title", "author", "isbn", "cover"),
        array($title, $author, $isbn, $cover)
    );
    if ($result) {
        echo "添加成功!";
        echo "<script>window.location ='add.html';</script>";
    }
