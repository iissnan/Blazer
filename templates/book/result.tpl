    {include "../include/header.tpl" title=$title}
            <div class="span9 box-wrap">
                <div class="admin-main box">
                    <p class="alert alert-{$alert_type}">{$action}{$result}</p>
                    <p>
                        <a href="/index.php">返回书架</a>
                        |
                        <a href="add.php">添加书籍</a>
                    </p>
                </div>
            </div>
            <div class="span3 box-wrap">
                <div class="box"></div>
            </div>
    {include "include/footer.tpl"}
