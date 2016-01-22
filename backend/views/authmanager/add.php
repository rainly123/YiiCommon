<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/17
 * Time: 18:05
 */
$this->title = '权限管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2><?php echo isset($auth_group['id'])?"编辑":"新增" ?>用户组</h2>
    </div>
    <form action="<?=Yii::$app->homeUrl.'authmanager/writegroup'?>" enctype="application/x-www-form-urlencoded" method="POST"
          class="form-horizontal">
        <div class="form-item">
            <label for="auth-title" class="item-label">用户组</label>
            <div class="controls">
                <input id="auth-title" type="text" name="title" class="text input-large" value="<?php echo isset($auth_group['title'])?$auth_group['title']:"" ?>"/>
            </div>
        </div>
        <div class="form-item">
            <label for="auth-description" class="item-label">描述</label>
            <div class="controls">
                <label class="textarea input-large"><textarea id="auth-description" type="text" name="description"><?php echo isset($auth_group['description'])?$auth_group['description']:"" ?></textarea></label>
            </div>
        </div>
        <div class="form-item">
            <input type="hidden" name="id" value="<?php echo isset($auth_group['id'])?$auth_group['id']:"" ?>" />
            <button type="submit" class="btn submit-btn ajax-post" target-form="form-horizontal">确 定</button>
            <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
        </div>
    </form>
<?php $this->endBlock(); ?>