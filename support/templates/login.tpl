{extends "entry.tpl"}
{block "header_link"}{/block}
{block "safari"}
    <div class="safari">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php"><i class="icon-home"></i>返回首页</a>
            </li>
        </ul>
        <a href="/register.php" class="btn btn-small action-register">帐号注册</a>
    </div>
{/block}
{block "main"}
    <form action="login.php" method="post" class="J_LoginForm">
        {include file="include/alert.tpl"}
        <div class="control-group">
            <label for="email" class="control-label">登录邮箱</label>
            <input type="text" name="email" id="email"
                   class="input-block-level" value="{$email}" />
        </div>

        <div class="control-group">
            <label for="password" class="control-label">登录密码</label>
            <input type="password" name="password" id="password"
                   class="input-block-level" value="{$password}" />
        </div>

        {if $recaptcha}
            <div class="control-group">
                <label class="control-label" for="recaptcha">验证码</label>
                <div class="controls">
                    {$recaptcha}
                </div>
            </div>
        {/if}

        <label for="remember" class="checkbox">
            <input type="checkbox" name="remember" id="remember" />  下次自动登录?
        </label>

        <div class="mt30">
            <input type="submit" class="btn btn-primary btn-block btn-large" value="登    录"/>
            <input type="hidden" name="submitted" value="yes"/>
        </div>
    </form>
{/block}
{block "footer_link"}{/block}
