<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/15
 * Time: 9:57
 */
?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2>
            <?=isset($info['id'])?'编辑':'新增'?>导航
           <?php if(!empty($parent)){?>
                [&nbsp;父导航：<a href="<?=U('channel/index','pid='.$pid)?>"><?=$parent['title']?></a>&nbsp;]
           <?php } ?>
        </h2>
    </div>
    <form action="<?=U()?>" method="post" class="form-horizontal">
        <input type="hidden" name="pid" value="<?=$pid?>">
        <div class="form-item">
            <label class="item-label">导航标题<span class="check-tips">（用于显示的文字）</span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="title" value="<?=isset($info['title'])?$info['title']:''?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">导航连接<span class="check-tips">（用于调转的URL，支持带http://的URL或U函数参数格式）</span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="url" value="<?=isset($info['url'])?$info['url']:''?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">新窗口打开<span class="check-tips">（是否新窗口打开链接）</span></label>
            <div class="controls">
                <select name="target">
                    <option value="0">否</option>
                    <option value="1">是</option>
                </select>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">优先级<span class="check-tips">（导航显示顺序）</span></label>
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
        highlight_subnav('<?=U('config/group')?>');
        setValue('target',<?=isset($info['target'])?$info['target']:0?>)
    </script>
<?php $this->endBlock(); ?>