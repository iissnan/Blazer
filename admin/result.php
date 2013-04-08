<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    !isset($_SESSION["user"]) and header("Location: ../login.php");

    $action = $_GET["action"];
    $code = $_GET["code"];

    if (!isset($action) || $action == "") {
        die("无效操作");
    }

    switch($action) {
        case "add":
            $title = "添加";
            break;
        case "edit":
            $title = "更新";
            break;
        case "delete":
            $title = "删除";
            break;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title><?php echo $title ?>操作结果</title>
</head>
<body>
    <?php
        echo "<p>" . $title . ($code == "1" ?  "成功" : "失败" ) . "</p>";
    ?>
    <p>
        <a href="list.php">返回列表</a>
        |
        <a href="add.php">添加书籍</a>
    </p>
</body>
</html>
