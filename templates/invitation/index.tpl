{extends "layout.tpl"}
{block name="content"}
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
            <li class="active">我的邀请码</li>
        </ul>
    </div>
    {if $user->group == "admin"}
        <div class="action">
            <a href="add.php" class="btn btn-primary pull-right">生  成</a>
        </div>
    {/if}
    {if $invitations_size > 0}
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>邀请码</th>
                <th>剩余次数</th>
            </tr>
            </thead>
            {while $invitation = $invitations->fetch_object()}
                <tr>
                    <td>{$invitation->value}</td>
                    <td>{$invitation->number}</td>
                </tr>
            {/while}
        </table>
        {*分页*}
        {if $pagination}
            <div class="pagination">
                <ul>
                    {for $i = 1 to $page_total}
                        <li class="{if $i == $page_current}active{/if}">
                            <a href="index.php?page={$i}">{$i}</a>
                        </li>
                    {/for}
                </ul>
            </div>
        {/if}
    {else}
        <p>没有邀请码</p>
    {/if}
{/block}

{block name="sidebar"}

{/block}
