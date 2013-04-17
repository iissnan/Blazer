{extends "entry.tpl"}
{block "header_link"}{/block}
{block "safari"}
    <div class="safari">
        <ul class="breadcrumb">
            <li>
                <a href="/index.php"><i class="icon-home"></i>返回首页</a>
            </li>
        </ul>
        <a class="btn btn-small action-login" href="/login.php">登录</a>
    </div>
{/block}
{block "main"}
    <form action="register.php" method="post" id="registerForm">
            {$alert}
            <div class="control-group">
                <label for="username" class="control-label">用户名</label>
                <input type="text" name="username" id="username"
                       class="control input-block-level" value="{$username}" />
            </div>
            <div class="control-group">
                <label for="email" class="control-label">登录邮箱</label>
                <input type="text" name="email" id="email"
                       class="control input-block-level" value="{$email}" />
            </div>
            <div class="control-group">
                <label for="password" class="control-label">登录密码</label>
                <input type="password" name="password" id="password"
                       class="control input-block-level" value="{$password}" />
            </div>
            <div class="control-group">
                <label for="re-password" class="control-label">密码确认</label>
                <input type="password" name="re-password" id="re-password"
                       class="control input-block-level" value="{$re_password}" />
            </div>
            <div class="control-group">
                <label for="invitation" class="control-label">邀请码</label>
                <input type="text" name="invitation" id="invitation"
                       class="control input-block-level" value="{$invitation}" />
            </div>
            <div class="mt30">
                <input type="hidden" name="submitted" value="yes" />
                <input type="submit" class="btn btn-large btn-primary btn-block" value="注  册"/>
            </div>
        </form>
{/block}
{block "footer_link"}{/block}
