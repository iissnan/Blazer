<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>列表</title>
</head>
<body>
    {include file="./include/header.tpl"}
    {if $books_size > 0}
        <table>
            {while $book = $books->fetch_object()}
                <tr>
                    <td>
                        <img src="../{$book->cover}" width="80" alt="{$book->title}"/>
                    </td>
                    <td>{$book->title}</td>
                    <td>{$book->author}</td>
                    <td>{$book->isbn}</td>
                    <td>{$book->category}</td>
                    <td>
                        <a href="edit.php?id={$book->id}">编辑</a>
                    </td>
                    <td>
                        <a href="delete.php?id={$book->id}" onclick="return confirmDelete(this)">删除</a>
                    </td>
                </tr>
            {/while}
        </table>
    {else}
        <p>没有书籍</p>
    {/if}
    <script type="text/javascript" src="../assets/js/admin.js"></script>
</body>
</html>