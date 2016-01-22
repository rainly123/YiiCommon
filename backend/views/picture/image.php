<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/12
 * Time: 9:35
 */
?>

    <div class="controls">
        <?php if(!empty($piclist['list'])){?>
            <?php foreach($piclist['list'] as $val){?>
                <div class="upload-img-box" style="margin-right: 10px; display: inline;float: left;margin-top: 10px;height: 120px">
                    <div class="upload-pre-item">
                        <img src="<?=$val['path']?>" style="min-height: 120px;max-height: 600px"/>
                    </div>
                    <!--        <span class="">图片信息</span>-->
                </div>
            <?php }?>
        <?php }?>
    </div>

<div class="page" style="bottom: 30px;position: absolute;width: 100%;">
    <!--分页-->
    <?= \yii\widgets\LinkPager::widget(['pagination' =>$piclist['pagination']]); ?>
    <!--/分页-->
</div>


