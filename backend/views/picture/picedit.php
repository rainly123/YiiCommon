<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/15
 * Time: 9:26
 */
?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2>编辑图片类型</h2>
    </div>
    <form action="<?=U()?>" method="post" class="form-horizontal">
        <div class="form-item">
            <label class="item-label">图片<span class="check-tips"></span></label>
            <input type="hidden" name="path" value="<?=$info['path']?>">
            <div class="controls">
                <div class="upload-img-box">
                    <div class="upload-pre-item">
                        <img src="<?=$info['path']?>" style="min-height: 120px;max-height: 600px"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">title<span class="check-tips">用于图片alt属性</span></label>
            <div class="controls">
                <input type="text"  class="text input-large" name="title" value="<?=$info['title']?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">md5<span class="check-tips"></span></label>
            <div class="controls">
                <input type="text" readonly class="text input-large" name="md5" value="<?=$info['md5']?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">sha1<span class="check-tips"></span></label>
            <div class="controls">
                <input type="text" readonly class="text input-large" name="sha1" value="<?=$info['sha1']?>">
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
<?php $this->endBlock(); ?>