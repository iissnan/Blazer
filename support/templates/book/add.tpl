{extends "layout.tpl"}
{block "safari"}
    <div class="nav-position clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">添加书籍</li>
        </ul>
    </div>
{/block}
{block name="content"}
    {include file="include/alert.tpl"}
    <form action="add.php" method="post" enctype="multipart/form-data"
          id="J_FormAdd" class="form-horizontal">

        <div class="form-divider">关键信息</div>

        <div class="control-group">
            <label for="title" class="control-label">标题</label>
            <div class="controls">
                <input type="text" name="title" id="title" value="{$title}"
                        class="input-xlarge"/>
                <span class="label label-important">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="pages">页数</label>
            <div class="controls">
                <input type="text" name="pages" id="pages" class="input-xlarge" />
                <span class="label label-important">必填</span>
            </div>
        </div>

        <div class="control-group">
            <label for="author" class="control-label">作者</label>
            <div class="controls">
                <input type="text" name="author" id="author" value="{$author}"
                        class="input-xlarge"/>
            </div>
        </div>

        <div class="control-group">
            <label for="cover" class="control-label">封面</label>
            <div class="controls">
                <input type="file" name="cover" id="cover" class="input-xlarge"/>
            </div>
        </div>



        <div class="form-divider">
            选填信息
        </div>

        <div class="control-group">
            <label for="category" class="control-label">类别</label>
            <div class="controls">
                <input type="text" name="category" id="category" value="{$category}"
                       class="input-xlarge"/>
            </div>
        </div>

        <div class="control-group">
            <label for="isbn" class="control-label">ISBN</label>
            <div class="controls">
                <input type="text" name="isbn" id="isbn" value="{$isbn}"
                       class="input-xlarge"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="intro">内容简介</label>
            <div class="controls">
                <textarea name="intro" id="intro" rows="6" class="input-xlarge"></textarea>
            </div>
        </div>

        {*
        <div class="control-group">
            <label for="douban-link" class="control-label">豆瓣链接</label>
            <div class="controls">
                <input type="text" name="douban_link" id="douban-link"
                       value="{$douban_link}" class="input-xlarge"/>
            </div>
        </div>
        *}

        <div class="control-group">
            <input type="hidden" name="submitted" value="yes"/>
            <div class="controls">
                <input type="submit" id="J_ActionAdd" value="添  加" class="btn btn-primary " />
            </div>
        </div>
    </form>
{/block}

{block name="sidebar"}{/block}

{block "footer_link"}
    <script type="text/javascript" src="/assets/js/book.js"></script>
{/block}

