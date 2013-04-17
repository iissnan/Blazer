{extends "layout.tpl"}
    {block "safari"}
        <div class="safari clearfix">
            <ul class="breadcrumb">
                <li><a href="/index.php">首页</a></li>
            </ul>
            {if $is_login}
                <a href="book/add.php" class="btn btn-primary btn-small action-add-book">添  加</a>
            {/if}
        </div>
    {/block}
    {block name="content"}
        {if $total > 0}
            <ul class="cover-list clearfix">
                {foreach $books as $book}
                    <li {if ($book@index+1) % 5 == 0}class="last"{/if}>
                        <a href="book/detail.php?id={$book["id"]|escape:'url'}">
                            <div class="book-info">
                                <dl>
                                    <dt>{$book["title"]|escape:'html'}</dt>
                                    <dd>{$book["author"]|escape:'html'}</dd>
                                </dl>
                            </div>
                            <img src="/assets/cover/{$book["cover"]|escape:'html'|default:"default.png"}"
                                 alt="{$book["title"]|escape:'html'}"/>
                        </a>
                    </li>
                {/foreach}
            </ul>

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
            <p>没有书籍</p>
        {/if}
    {/block}
    {block name="sidebar"}
        {if not $is_login}
            <div class="box">
                <div class="box-header">
                    <i class="icon-user"></i>
                    用户登录
                    <a href="register.php" class="pull-right btn btn-mini btn-danger">注  册 &raquo;</a>
                </div>
                <div class="box-body">
                    <form action="login.php" method="post" >
                        <input id="email" type="text"  name="email" placeholder="登录邮箱"
                                class="email input-block-level"/>
                        <input type="password" name="password" placeholder="登录密码"
                             class="password input-block-level" id="password" />
                        <div class="control-group">
                            <label class="checkbox">
                                <input type="checkbox" name="remember" />下次自动登录？
                            </label>
                        </div>
                        {if $recaptcha}
                            <div class="modal hide fade modal-recaptcha">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3>请输入验证码：</h3>
                                </div>
                                <div class="modal-body">
                                        {$recaptcha}
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn" data-dismiss="modal">关闭</a>
                                    <a href="#" class="btn btn-primary" id="J_ActionLoginWithCaptcha">提交</a>
                                </div>
                            </div>
                            <input type="button" class="btn btn-primary btn-block" value="登  录" id="J_ActionLogin"/>
                        {else}
                            <input class="btn btn-primary btn-block" type="submit" value="登  录"/>
                        {/if}
                        <input type="hidden" name="submitted" value="yes"/>
                    </form>
                </div>
            </div>
        {/if}
    {/block}

    {block "footer_link"}
        <script type="text/javascript">
            $("#J_ActionLoginWithCaptcha").on("click", function(){
                $("form").submit();
            });
            $("#J_ActionLogin").on("click", function(){
                $(".modal-recaptcha").modal();
                return false;
            });
        </script>
    {/block}
