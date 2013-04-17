{extends "layout.tpl"}
{block "safari"}
    <div class="nav-position clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">
                更新书籍 {if !$error}《{$book->title|escape:'html'}》{/if}
            </li>
        </ul>
    </div>
{/block}
{block name="content"}

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
                    <img width="106" height="150" src="/assets/cover/{$book->cover}" />
                    <input type="hidden" name="current-cover" value="{$book->cover}"/>
                    <input type="file" name="cover" id="cover" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="intro">内容简介</label>
                <div class="controls">
                    <textarea name="intro" id="intro" rows="6" class="input-xlarge">{$book->intro}</textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="pages">页数</label>
                <div class="controls">
                    <input type="text" name="pages" id="pages" value="{$book->pages}" class="input-xlarge"/>
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
        </form>
    {/if}
{/block}
{block name="sidebar"}

{/block}
