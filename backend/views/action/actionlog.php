<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/30
 * Time: 11:13
 */
$this->title="用户行为";
?>
<?php $this->beginBlock('content'); ?>
<!-- 标题栏 -->
<div class="main-title">
    <h2>行为日志</h2>
</div>

<div>
    <button class="btn ajax-get confirm" url="<?=U('action/clear')?>">清 空</button>
    <button class="btn ajax-post confirm" target-form="ids" url="<?=U('action/remove')?>">删 除</button>
</div>
<!-- 数据列表 -->
<div class="data-table">
    <table class="">
        <thead>
        <tr>
            <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
            <th class="">编号</th>
            <th class="">行为名称</th>
            <th class="">执行者</th>
            <th class="">执行时间</th>
            <th class="">操作</th>
        </tr>
        </thead>
        <tbody>
            <?php if(!empty($list['list'])){ ?>
                <?php foreach($list['list'] as $key=>$vo){?>
                <tr>
                    <td><input class="ids" type="checkbox" name="ids[]" value="<?=$vo['id']?>" /></td>
                    <td><?=$vo['id']?> </td>
                    <td><?=get_action($vo['action_id'],'title')?></td>
                    <td><?=get_nickname($vo['user_id'])?></td>
                    <td><span><?=time_format($vo['create_time'])?></span></td>
                    <td><a href="<?=U('action/edit?id='.$vo['id'])?>">详细</a>
                        <a class="confirm ajax-get" href="<?=U('action/remove?ids='.$vo['id'])?>">删除</a>
                    </td>
                </tr>
            <?php }?>
            <?php }else{ ?>
            <td colspan="6" class="text-center"> aOh! 暂时还没有内容! </td>
    <?php }?>
        </tbody>
    </table>
</div>
    <div class="page">
        <!--分页-->
        <?= \yii\widgets\LinkPager::widget(['pagination' =>$list['pagination']]); ?>
        <!--/分页-->
    </div>
<?php $this->endBlock();?>

<?php $this->beginBlock('script'); ?>

<?php $this->endBlock();?>