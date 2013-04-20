{extends "layout.tpl"}
{block "header_link"}
    {literal}
        <style type="text/css">
            .table td{vertical-align: middle;}
            .table .progress{margin-bottom: 0}
        </style>
    {/literal}
{/block}
{block "safari"}
    <div class="nav-position clearfix">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php">首页</a>
                <span class="divider">&gt;</span>
            </li>
            <li>
                <a href="/user/index.php">{$user->username|escape:'html'}</a>
                <span class="divider">&gt;</span>
            </li>
            <li class="active">阅读进度</li>
        </ul>
    </div>
{/block}
{block "content"}
    {include "include/alert.tpl"}
    {if $total > 0}
        <table class="position-list table table-striped">
            <thead>
                <tr>
                    <th>书籍封面</th>
                    <th>书籍标题</th>
                    <th style="width: 120px;">进度@时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            {while $position = $positions->fetch_object()}
                <tr>
                    <td>
                        <a href="/book/detail.php?id={$position->book_id}">
                            <img src="/assets/cover/{$position->cover}" width="60"
                                 alt="{$position->title|escape:'html'}"/>
                        </a>
                    </td>
                    <td>
                        <a href="/book/detail.php?id={$position->book_id}">
                            {$position->title|escape:'html'}
                        </a>
                    </td>
                    <td>
                        <div class="progress progress-striped active">
                            <div class="bar"
                                 style="width: {$position->position|escape:'html'/$position->pages * 100}%;">
                            </div>
                        </div>
                        <span class="label">{$position->create_at|escape:'html'}</span>
                    </td>
                    <td>
                        <a href="/position/delete.php?id={$position->id}"
                           class="btn btn-danger btn-mini action-position-delete">&times;</a>
                    </td>
                </tr>
            {/while}
        </table>
    {else}
        进度表为空
    {/if}
{/block}
{block "sidebar"}{/block}
{block "footer_link"}
    {literal}
        <script type="text/javascript">
            $(".action-position-delete").on("click", function(){
                return window.confirm("确认删除此条进度信息?");
            });
        </script>
    {/literal}
{/block}
