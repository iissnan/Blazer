{extends "entry.tpl"}
{block "header_link"}
    {literal}
        <style type="text/css">
            .popover{width: 250px;}
        </style>
    {/literal}
{/block}
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
    <form action="register.php" method="post" class="J_RegisterForm">
            {$alert}

            <div class="control-group">
                <label for="email" class="control-label">登录邮箱</label>
                <input type="text" name="email" id="email"
                       class="control input-block-level" value="{$email}" />
                <div class="popover right">
                    <div class="arrow"></div>
                    <div class="popover-content">
                        用来登录网站，有效的邮箱格式形如：
                        <span class="label label-important">user@example.com</span>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label">登录密码</label>
                <input type="password" name="password" id="password"
                       class="control input-block-level" value="{$password}" />
                <div class="popover right">
                    <div class="arrow"></div>
                    <div class="popover-content">
                        密码要求包含 <span class="label label-important">字母和数字</span>
                        <br />并且至少要<span class="label label-important">8</span> 位以上
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="re-password" class="control-label">密码确认</label>
                <input type="password" name="re-password" id="re-password"
                       class="control input-block-level" value="{$re_password}" />
                <div class="popover right">
                    <div class="arrow"></div>
                    <div class="popover-content">
                        请确认登录密码
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="username" class="control-label">用户名</label>
                <input type="text" name="username" id="username"
                       class="control input-block-level" value="{$username}" />
                <div class="popover right">
                    <div class="arrow"></div>
                    <div class="popover-content">
                        让世界更好的认识 <span class="label label-important">你</span>
                    </div>
                </div>
            </div>
            {if !$is_first_user}
            <div class="control-group">
                <label for="invitation" class="control-label">邀请码</label>
                <input type="text" name="invitation" id="invitation"
                       class="control input-block-level" value="{$invitation}" data-toggle="popover" data-original-title="fwefwefwe" data-content="为开发及未来房价分解为克服" />
            </div>
            {/if}

            <div class="mt30">
                <input type="hidden" name="submitted" value="yes" />
                <input type="submit" class="btn btn-large btn-primary btn-block" value="注  册"/>
            </div>
        </form>
{/block}
{block "footer_link"}{/block}
