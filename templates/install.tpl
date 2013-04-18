{extends "entry.tpl"}
{block "header_link"}
    {literal}
    <style type="text/css">
        .result{margin: 30px;}
        ul{list-style: none;}
        .test-item{margin: 5px 0; width: 150px;}
        .divider{margin: 30px 0; width: 100%; height: 3px; background: #eee;}
    </style>
    {/literal}
{/block}
{block "main"}
    <div class="result">
        <p>正在确认数据连接...</p>
        {$result_string}
        {if $ok}
            <div class="divider"></div>
            <a class="btn btn-block btn-danger" href="../register.php">管理员注册</a>
        {else}
            <p class="alert alert-warn">请确认环境配置是否正确</p>
        {/if}
    </div>
{/block}