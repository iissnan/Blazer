{extends "layout.tpl"}
{block "safari"}
    <div class="safari clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li>
                <a href="/position/index.php">阅读进度</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">进度更新</li>
        </ul>
    </div>
{/block}
{block "content"}
    {if $error || $show_alert}
        <div class="alert {$alert_mode}">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {$alert_message}
        </div>
    {/if}
    {if !$error}
        <div class="clearfix">
            <h3>{$book->title}</h3>
            <form action="/position/add.php" method="post" class="pull-left">
                <input type="hidden" name="book_id" value="{$book->id}" readonly="readonly"/>
                <div class="control-group">
                    <label class="control-label" for="position">当前进度：</label>
                    <input type="text" name="position" id="position" class="control input-xlarge" />
                    <span class="label label-important">必填</span>
                </div>
                <div class="control-group">
                    <label class="control-label" for="position-note">进度备注</label>
                    <textarea name="position_note" id="position-note" rows="6" class="input-xlarge"></textarea>
                </div>
                <input type="submit" class="control btn btn-primary" value="更新"/>
                <input type="hidden" name="submitted" value="yes"/>
            </form>
            <div class="book-cover pull-right">
                <img src="/assets/cover/{$book->cover|escape}" class="cover img-polaroid" alt="{$book->title|escape}" />
            </div>
        </div>

        {if $positions}
            <div class="position-list">
                <table class="table table-striped table-hover">
                    <caption>历史进度</caption>
                    <thead>
                        <tr>
                            <th>进度页码</th>
                            <th style="180px">进度比例</th>
                            <th>更新时间</th>
                        </tr>
                    </thead>
                    {while $position = $positions->fetch_object()}
                        <tr>
                            <td>{$position->position|escape}</td>
                            <td>
                                <div class="progress progress-striped active">
                                    <div class="bar"
                                            style="width: {$position->position|escape / $book->pages|escape * 100}%">
                                    </div>
                                </div>
                                </td>
                            <td>{$position->create_at}</td>
                        </tr>
                    {/while}
                </table>
            </div>
        {else}
            <span class="label label-warning">新进度记录!</span>
        {/if}
    {else}
        <a href="javascript:history.go(-1)" class="btn btn-primary">返回</a>
    {/if}
{/block}