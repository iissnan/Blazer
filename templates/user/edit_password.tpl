   {include "include/header.tpl" title=$title}
            <div class="span9 box-wrap">
                <div class="admin-main box">
                    {$alert}
                    <form action="edit_password.php" method="post" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="old-password">旧密码：</label>
                            <div class="controls">
                                <input type="password" name="old_password" id="old-password"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="new-password">新密码：</label>
                            <div class="controls">
                                <input type="password" name="new_password" id="new-password"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="re-password">确认新密码：</label>
                            <div class="controls">
                                <input type="password" name="re_password" id="re-password"/>
                            </div>
                        </div>
                        <div class="control-group mt30">
                            <label for="submit" class="control-label"></label>
                            <div class="controls">
                                <input type="submit" value="更  改" class="btn-primary"/>
                            </div>
                        </div>
                        <input type="hidden" name="submit" value="yes"/>
                    </form>
                </div>
            </div>
            <div class="span3 box-wrap">
                <div class="box"></div>
            </div>
   {include "include/footer.tpl"}
