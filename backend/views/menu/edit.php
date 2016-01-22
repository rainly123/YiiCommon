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
        <h2><?=isset($info)?'编辑':'新增'?>后台菜单</h2>
    </div>
    <form action="<?=U()?>" method="post" class="form-horizontal">
        <div class="form-item">
            <label class="item-label">标题<span class="check-tips">（用于后台显示的配置标题）</span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="title" value="<?=isset($info['title'])?$info['title']:''?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">排序<span class="check-tips">（用于分组显示的顺序）</span></label>
            <div class="controls">
                <input type="text" class="text input-small" name="sort" value="<?=isset($info['sort'])?$info['sort']:0?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">链接<span class="check-tips">（U函数解析的URL或者外链）</span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="url" value="<?=isset($info['url'])?$info['url']:''?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">上级菜单<span class="check-tips">（所属的上级菜单）</span></label>
            <div class="controls">
                <select name="pid">
                    <volist name="Menus" id="menu">
                        <?php foreach($Menus as $menu) {?>
                        <option value="<?=$menu['id']?>"><?=$menu['title_show']?></option>
                        <?php }?>
                    </volist>
                </select>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">分组<span class="check-tips">（用于左侧分组二级菜单）</span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="group" value="<?=isset($info['group'])?$info['group']:''?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">是否隐藏<span class="check-tips"></span></label>
            <div class="controls">
                <label class="radio"><input type="radio" name="hide" value="1">是</label>
                <label class="radio"><input type="radio" name="hide" value="0">否</label>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">仅开发者模式可见<span class="check-tips"></span></label>
            <div class="controls">
                <label class="radio"><input type="radio" name="is_dev" value="1">是</label>
                <label class="radio"><input type="radio" name="is_dev" value="0">否</label>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">说明<span class="check-tips">（菜单详细说明）</span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="tip" value="<?=isset($info['tip'])?$info['tip']:''?>">
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
        setValue("pid", <?=\common\help\HTMLHelper::_GET('pid')?>);
        setValue("hide",<?=isset($info['hide'])?$info['hide']:0?>);
        setValue("is_dev",<?=isset($info['is_dev'])?$info['is_dev']:0?>);
        //导航高亮
        highlight_subnav('<?=U('config/group')?>');
    </script>
<?php $this->endBlock(); ?>