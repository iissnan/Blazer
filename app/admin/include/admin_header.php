<?php
    session_start();

    echo "<div id='header'>";
    echo "<ul>";
    echo "<li><a href='list.php'>列表页</a>";
    echo "<li><a href='add.php'>添加书籍</a>";
    if (isset($_SESSION["user"])) {
        echo "<li><a href='../logout.php'>退出登录</a></li>";
    }
    echo "</ul>";
    echo "</div>";
