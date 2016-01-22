<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/23
 * Time: 16:38
 */
?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2>新增用户</h2>
    </div>
    <form action="<?=Yii::$app->homeUrl.'users/add'?>" method="post" class="form-horizontal">
        <input type="hidden" name="_csrf" value="<?php echo Yii::$app->getRequest()->getCsrfToken(); ?>" />
        <div class="form-item">
            <label class="item-label">用户名<span class="check-tips">（用户名会作为默认的昵称）</span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="LeUcenterMemberDB[username]" value="">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">密码<span class="check-tips">（用户密码不能少于6位）</span></label>
            <div class="controls">
                <input type="password" class="text input-large" name="LeUcenterMemberDB[password]" value="">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">确认密码</label>
            <div class="controls">
                <input type="password" class="text input-large" name="LeUcenterMemberDB[repassword]" value="">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">邮箱<span class="check-tips">（用户邮箱，用于找回密码等安全操作）</span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="LeUcenterMemberDB[email]" value="">
            </div>
        </div>
        <div class="form-item">
            <button class="btn submit-btn ajax-post" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
        </div>
    </form>
<?php $this->endBlock();?>