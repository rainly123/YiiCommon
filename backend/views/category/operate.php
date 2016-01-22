<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/22
 * Time: 15:15
 */
?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2><?=$operate?>分类</h2>
    </div>
    <div class="tab-wrap">
        <div class="tab-content">
            <form action="<?=U('category/'.$type.'')?>" method="post" class="form-horizontal">
                <div id="tab1" class="tab-pane in tab1">
                    <div class="form-item">
                        <label class="item-label">目标分类<span class="check-tips">（将<?=$operate?>至的分类）</span></label>
                        <div class="controls">
                            <select name="to">
                                <?php foreach($list as $vo){?>
                                    <option value="<?=$vo['id']?>"><?=$vo['title']?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-item">
                    <input type="hidden" name="from" value="<?=$from?>">
                    <button type="submit" id="submit" class="btn submit-btn ajax-post" target-form="form-horizontal">确 定</button>
                    <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
                </div>
            </form>
        </div>
    </div>
<?php $this->endBlock(); ?>