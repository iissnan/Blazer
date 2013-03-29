<?php
    header("Content-Type: text/html; charset=utf-8");

    if ($_POST["submitted"] == "yes") {
        require_once("class/dbc.class.php");
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
            echo "<script>window.location ='add_success.html';</script>";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>添加书籍</title>
        <style type="text/css">
            .error {
                display: none;
                padding: 5px;
                color: white;
                font-weight: bold;
                background: red;
            }
        </style>
    </head>

    <body>
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
                <label for="douban-link">豆瓣链接</label>
                <input type="text" name="douban_link" id="douban-link"/>
            </p>

            <p>
                <input type="button" id="J_ActionAdd" value="提交" />
            </p>

            <input type="hidden" name="submitted" value="yes"/>
        </form>
        <script type="text/javascript">
            (function () {
                var form = document.getElementById("J_FormAdd");
                var inputTitle = document.getElementById("title");
                var inputAuthor = document.getElementById("author");
                var actionAdd = document.getElementById("J_ActionAdd");
                var error = document.getElementById("error");
                if (actionAdd) {
                    actionAdd.onclick = function () {
                        if (inputTitle.value !== "") {
                            form.submit();
                        } else {
                            error.innerHTML = "请输入标题";
                            error.style.display = "block";
                        }
                    }
                }
            }());
        </script>
    </body>
</html>
