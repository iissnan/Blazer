<?php
    require_once("class/book.class.php");

    $book = new Book();
    $books_all = $book->all();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>列表</title>
    </head>
    <body>
        <?php
            if ($books_all) {
                echo "<table>";
                $books_length = $books_all->num_rows;
                for ($i = 0; $i < $books_length; $i++) {
                    $book = $books_all->fetch_assoc();
                    echo "<tr>";
                    echo "<td>" . "<img width='106' height='150' src='" . $book["cover"] . "'/>" . "</td>";
                    echo "<td>" . $book["title"] . "</td>";
                    echo "<td>" . $book["author"] . "</td>";
                    echo "<td>" . $book["isbn"] . "</td>";
                    echo "<td>" . $book["category"] . "</td>";
                    echo "<td><a href='edit.php?id=" . $book["id"] . "'>编辑</a></td>";
                    echo "<td><a onclick='return confirmDelete(this)' href='delete.php?id=" . $book["id"] . "'>删除</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "没有书籍";
            }
        ?>
        <script type="text/javascript" src="assets/js/admin.js"></script>
    </body>
</html>
