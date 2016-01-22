<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/13
 * Time: 10:58
 */

?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2><?=isset($info)?'编辑':'新增'?>图片类型</h2>
    </div>
    <form action="<?=U()?>" method="post" class="form-horizontal">
        <div class="form-item">
            <label class="item-label">名称<span class="check-tips">(一旦提交将不允许修改)</span></label>
            <div class="controls">
                <input type="text" readonly class="text input-large" name="type_name" value="<?=isset($info['type_name'])?$info['type_name']:''?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">标题<span class="check-tips"></span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="type_title" value="<?=isset($info['type_title'])?$info['type_title']:''?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">排序<span class="check-tips">（用于分组显示的顺序）</span></label>
            <div class="controls">
                <input type="text" class="text input-small" name="sort" value="<?=isset($info['sort'])?$info['sort']:0?>">
            </div>
        </div>
        <div class="form-item">
            <input type="hidden" name="id" value="<?=isset($info['id'])?$info['id']:''?>">
            <button class="btn submit-btn ajax-post" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
        </div>
    </form>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('script'); ?>
    <script type="text/javascript">
        //导航高亮
        highlight_subnav('<?=U('config/group')?>');
    </script>
<?php $this->endBlock(); ?>