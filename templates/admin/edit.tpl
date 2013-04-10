<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>编辑书籍</title>
    <link rel="shortcut icon" href="../assets/img/favicon.ico"/>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/gbootstrap.css"/>
    <link rel="stylesheet" href="../assets/css/main.css"/>
    <style type="text/css">
        h2 span{
            font-size: 20px;
            font-weight: normal;
        }
    </style>
</head>

<body>
    {include file="./include/header.tpl"}
    <div class="admin-wrap container">
        <div class="row">
            <div class="span12">
                <div class="admin-main">
                <h2>更新 {if !$error}<span class="text-info">《{$book->title}》</span>{/if}</h2>
                    {$alert}
                    {if $error}
                        <p><a href='index.php'>返回列表</a></p>
                    {else}
                        <form action="edit.php" method="post" enctype="multipart/form-data"
                              id="J_FormAdd" class="form-horizontal">
                            <input type="hidden" name="id" value="{$book->id}"/>
                            <div class="control-group">
                                <label for="title" class="control-label">标题</label>
                                <div class="controls">
                                    <input type="text" name="title" id="title" value="{$book->title}"
                                           class="input-xlarge"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="author" class="control-label">作者</label>
                                <div class="controls">
                                    <input type="text" name="author" id="author" value="{$book->author}"
                                            class="input-xlarge"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="isbn"  class="control-label">ISBN</label>
                                <div class="controls">
                                    <input type="text" name="isbn" id="isbn" value="{$book->isbn}"
                                            class="input-xlarge"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="cover"  class="control-label">封面</label>
                                <div class="controls">
                                    <img width="106" height="150" src="{$book->cover}" />
                                    <input type="hidden" name="current-cover" value="{$book->cover}"/>
                                    <input type="file" name="cover" id="cover" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="category"  class="control-label">分类</label>
                                <div class="controls">
                                    <input type="text" name="category" id="category" value="{$book->category}"
                                           class="input-xlarge"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="douban-link"  class="control-label">豆瓣链接</label>
                                <div class="controls">
                                    <input type="text" name="douban_link" id="douban-link" value="{$book->douban_link}"
                                           class="input-xlarge"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <input type="hidden" name="submitted" value="yes"/>
                                <div class="controls">
                                    <input type="submit" id="J_ActionAdd" class="btn btn-primary" value="更  新" />
                                </div>
                            </div>

                            <script type="text/javascript" src="../assets/vendor/jquery/jquery.min.js"></script>
                        </form>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</body>
</html>