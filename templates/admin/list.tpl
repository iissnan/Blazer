<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>列表</title>
    <link rel="shortcut icon" href="../assets/img/favicon.ico"/>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
</head>
<body>
    {include file="./include/header.tpl"}
    <div class="admin-wrap container">
        <div class="row">
            <div class="span12">
                <div class="admin-main">
                    {if $books_size > 0}
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>封面</th>
                                    <th>名称</th>
                                    <th>作者</th>
                                    <th>ISBN</th>
                                    <th>分类</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            {while $book = $books->fetch_object()}
                                <tr>
                                    <td>
                                        <img src="{$book->cover}" width="80" alt="{$book->title}"/>
                                    </td>
                                    <td>{$book->title}</td>
                                    <td>{$book->author}</td>
                                    <td>{$book->isbn}</td>
                                    <td>{$book->category}</td>
                                    <td>
                                        <a href="edit.php?id={$book->id}"
                                           class="btn btn-mini btn-primary">编辑</a>
                                        &nbsp;
                                        <a href="delete.php?id={$book->id}"
                                           class="btn btn-mini btn-danger"
                                           onclick="return confirmDelete()">删除</a>
                                    </td>
                                </tr>
                            {/while}
                        </table>
                    {else}
                        <p>没有书籍</p>
                    {/if}
                </div>
           </div>
        </div>
    </div>
    <script type="text/javascript" src="../assets/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/admin.js"></script>
</body>
</html>