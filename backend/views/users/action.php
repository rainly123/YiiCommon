<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/29
 * Time: 16:21
 */
$this->title="用户行为";
?>
<?php $this->beginBlock('content'); ?>
<!-- 标题栏 -->
<div class="main-title">
    <h2>行为列表</h2>
</div>

<div>
    <button class="btn" id="action_add" url="<?=U('users/addaction')?>">新 增</button>
    <button class="btn ajax-post" target-form="ids" url="<?=U('users/setstatus?status=1')?>" >启 用</button>
    <button class="btn ajax-post" target-form="ids" url="<?=U('users/setstatus?status=0')?>">禁 用</button>
    <button class="btn ajax-post confirm" target-form="ids" url="<?=U('users/setstatus?status=-1')?>">删 除</button>
</div>
<!-- 数据列表 -->
<div class="data-table">
    <table class="">
        <thead>
        <tr>
            <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
            <th class="">编号</th>
            <th class="">标识</th>
            <th class="">名称</th>
            <th class="">类型</th>
            <th class="">规则</th>
            <th class="">状态</th>
            <th class="">操作</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($list['list'] as $key=>$vo){?>
            <tr>
                <td><input class="ids" type="checkbox" name="ids[]" value="<?=$vo['id']?>" /></td>
                <td><?=$vo['id']?><?=$vo['id']?> </td>
                <td><?=$vo['name']?></td>
                <td><a href="<?=U('users/editaction?id='.$vo['id'])?>"><?=$vo['title']?></a></td>
                <td><span><?=get_action_type($vo['type'])?></span></td>
                <td><?=$vo['remark']?></td>
                <td><?=$vo['status_text']?></td>
                <td><a href="<?=U('users/editaction?id='.$vo['id'].'&type='.$vo['type'])?>">编辑</a>
                    <a href="<?=U('users/setstatus?model=action&ids='.$vo['id'].'&status='.abs(1-$vo['status']))?>" class="ajax-get"><?=show_status_op($vo['status'])?></a>
                    <a href="<?=U('users/setstatus?model=action&status=-1&ids='.$vo['id'])?>" class="confirm ajax-get">删除</a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>

</div>
<!-- 分页 -->
<div class="page">
    <!--分页-->
    <?= \yii\widgets\LinkPager::widget(['pagination' =>$list['pagination']]); ?>
    <!--/分页-->
</div>
<!-- /分页 -->
<?php $this->endBlock(); ?>
<?php $this->beginBlock('script');?>
<script type="text/javascript">
    $(function(){
        $("#action_add").click(function(){
            window.location.href = $(this).attr('url');
        })
        highlight_subnav('<?=U('users/index')?>');
    })
</script>
<?php $this->endBlock(); ?>
