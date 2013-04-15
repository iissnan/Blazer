   {include "include/header.tpl" title=$title}
            <div class="span9 box-wrap">
                <div class="admin-main box">
                    <p class="alert alert-{$alert_type}">添加{$result}</p>
                    {if $alert_type == "success"}
                    <p>
                        新生成的邀请码： <span class="label label-info">{$invitation}</span><br />
                        个数： <span class="label label-important">5</span>
                    </p>
                    {/if}
                    <p>
                        <a href="index.php">返回我的邀请码</a>
                        |
                        <a href="/index.php">返回书架</a>
                    </p>
                </div>
            </div>
            <div class="span3 box-wrap">
                <div class="box"></div>
            </div>
   {include "include/footer.tpl"}