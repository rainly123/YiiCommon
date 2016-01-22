<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/29
 * Time: 17:26
 */
?>
<?php $this->beginBlock('content'); ?>
<div class="main-title cf">
    <h2><if condition="ACTION_NAME eq 'addaction'">新增<else/>编辑</if>行为</h2>
</div>
<!-- 表单 -->
<form id="form" action="<?=U('users/saveaction')?>" method="post" class="form-horizontal">
    <div class="form-item cf">
        <label class="item-label">行为标识<span class="check-tips">（输入行为标识 英文字母）</span></label>
        <div class="controls">
            <input type="text" class="text input-large" name="name" value="<?=isset($data['name'])?$data['name']:''?>">
        </div>
    </div>
    <div class="form-item cf">
        <label class="item-label">行为名称<span class="check-tips">（输入行为名称）</span></label>
        <div class="controls">
            <input type="text" class="text input-large" name="title" value="<?=isset($data['title'])?$data['title']:''?>">
        </div>
    </div>
    <div class="form-item cf">
        <label class="item-label">行为类型<span class="check-tips">（选择行为类型）</span></label>
        <div class="controls">
            <select name="type">
                <?php foreach(get_action_type(null,true) as $key=>$vo){?>
                    <option value="<?=$key?>"><?=$vo?></option>
                <?php }?>
            </select>
        </div>
    </div>
    <div class="form-item cf">
        <label class="item-label">行为描述<span class="check-tips">（输入行为描述）</span></label>
        <div class="controls">
            <label class="textarea input-large"><textarea name="remark"><?=isset($data['remark'])?$data['remark']:''?></textarea></label>
        </div>
    </div>
    <div class="form-item cf">
        <label class="item-label">行为规则<span class="check-tips">（输入行为规则，不写则只记录日志）</span></label>
        <div class="controls">
            <label class="textarea input-large"><textarea name="rule"><?=isset($data['rule'])?$data['rule']:''?></textarea></label>
        </div>
    </div>
    <div class="form-item cf">
        <label class="item-label">日志规则<span class="check-tips">（记录日志备注时按此规则来生成，支持[变量|函数]。目前变量有：user,time,model,record,data）</span></label>
        <div class="controls">
            <label class="textarea input-large"><textarea name="log"><?=isset($data['log'])?$data['log']:''?></textarea></label>
        </div>
    </div>

    <div class="form-item">
        <input type="hidden" name="id" value="<?=isset($data['id'])?$data['id']:0?>"/>
        <button type="submit" class="btn submit-btn ajax-post" target-form="form-horizontal">确 定</button>
        <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
    </div>
</form>
<?php $this->endBlock();?>
<?php $this->beginBlock('script');?>
<script type="text/javascript" src="<?=Yii::$app->homeUrl?>js/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" charset="utf-8">
    highlight_subnav('<?=U('users/index')?>');
    setValue('type',<?=isset($type)?$type:1?>);
    //导航高亮

</script>
<?php $this->endBlock();?>

