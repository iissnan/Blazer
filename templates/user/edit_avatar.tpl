   {include "include/header.tpl" title=$title}
            <div class="span9 box-wrap">
                <div class="admin-main box">
                    {$alert}
                    <form action="edit_avatar.php" method="post" enctype="multipart/form-data" class="form-inline">
                        <div class="current-avatar">
                            <span>当前头像：</span>
                            <span class="controls">
                                {if $current_avatar != ""}
                                    <img src="{$current_avatar}" class="img-rounded" alt="" width="120" />
                                    &nbsp;
                                    <img src="{$current_avatar}" class="img-rounded" alt="" width="80" />
                                    &nbsp;
                                    <img src="{$current_avatar}" class="img-rounded" alt="" width="40" />
                                {else}
                                    <img src="/assets/img/default_avatar.png" alt="默认头像"
                                            width="120" class="img-rounded"/>
                                    &nbsp;
                                    <img src="/assets/img/default_avatar.png" alt="默认头像"
                                         width="80" class="img-rounded"/>
                                    &nbsp;
                                    <img src="/assets/img/default_avatar.png" alt="默认头像"
                                         width="40" class="img-rounded"/>
                                {/if}
                            </span>
                        </div>
                        <div class="control-group mt30">
                            <label for="update-custom" class="control-label inline">更新头像： </label>
                            <input type="file" name="avatar" id="update-custom" class="inline"/>
                        </div>
                        <div class="control-group mt30">
                            <input type="submit" value="立即更新" class="btn-primary"/>
                        </div>
                        <input type="hidden" name="submit" value="yes"/>
                    </form>
                </div>
            </div>
            <div class="span3 box-wrap">
                <div class="box"></div>
            </div>
   {include "include/footer.tpl"}
