<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/29
 * Time: 13:07
 */
$this->title='草稿箱';
?>
<?php $this->beginBlock('leftNav');?>
    <h3>
        <i class="icon icon-unfold" ></i>
        个人中心
    </h3>
    <ul class="side-sub-menu" >
        <li><a href="<?=U('article/mydocument')?>" class="item">我的文档</a></li>
        <li><a href="<?=U('article/draftbox')?>" class="item">草稿箱</a></li>
        <li><a href="<?=U('article/examine')?>" class="item">待审核</a></li>
    </ul>
    <!-- 子导航 -->
<?php foreach($MENU['nodes'] as $Akeys=>$Aval){ ?>
    <h3>
        <i class="icon icon icon-unfold"></i>
        <?= $Aval['title'] ?>
    </h3>
    <ul class="side-sub-menu" >
        <?php foreach($Aval['_child'] as $val){ ?>
            <li><a href="<?=U($val['url'])?>" class="item"><?=$val['title']?></a></li>
        <?php } ?>
    </ul>
<?php } ?>
    <!-- /子导航 -->
    <!-- 回收站 -->
    <h3>
        <em class="recycle"></em>
        <a href="<?=U('article/recycle')?>">回收站</a>
    </h3>
<?php $this->endBlock();?>
<?php $this->beginBlock('content'); ?>
    <!-- 标题 -->
    <div class="main-title">
        <h2>
            草稿箱(<?=$list['pagination']->totalCount?>)
        </h2>
    </div>

    <!-- 按钮工具栏 -->
    <div class="cf">
    <div class="fl">
        <button class="btn ajax-post confirm" target-form="ids" url="<?=U('article/setstatus?status=-1')?>">删 除</button>
    </div>
    <!-- 数据表格 -->
    <div class="data-table">
        <table class="">
            <thead>
            <tr>
                <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
                <th class="">编号</th>
                <th class="">标题</th>
                <th class="">子文档</th>
                <th class="">类型</th>
                <th class="">分类</th>
                <th class="">优先级</th>
                <th class="">最后更新</th>
                <th class="">浏览</th>
                <th class="">状态</th>
                <th class="">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($list['list'])){
                foreach($list['list'] as $vo) {
                    ?>
                    <tr>
                        <td><input class="ids" type="checkbox" name="ids[]" value="<?=$vo['id']?>"/></td>
                        <td><?=$vo['id']?></td>
                        <td><a href="<?=U('article/index?cate_id='.$vo['category_id'].'&pid='.$vo['id'])?>"><?=$vo['title']?></a>
                        </td>
                        <td><span><?=get_subdocument_count($vo['id'])?></span></td>
                        <td><span><?=get_document_type($vo['type'])?></span></td>
                        <td><span><?get_cate($vo['category_id'])?></span></td>
                        <td><?=$vo['level']?></td>
                        <td><span><?=time_format($vo['update_time'])?></span></td>
                        <td><?=$vo['view']?></td>
                        <td><?=$vo['status_text']?></td>
                        <td><a href="<?=U('article/edit?cate_id='.$vo['category_id'].'&id='.$vo['id'])?>">编辑</a>
                            <a href="<?=U('article/setstatus?ids='.$vo['id'].'&status='.abs(1-$vo['status']))?>"
                               class="ajax-get"><?=show_status_op($vo['status'])?></a>
                            <a href="<?=U('article/setstatus?status=-1&ids='.$vo['id'])?>" class="confirm ajax-get">删除</a>
                        </td>
                    </tr>
                <?php
                }}else{?>
                <td colspan="11" class="text-center"> aOh! 暂时还没有内容! </td>
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
<?php $this->endBlock();?>
<?php $this->beginBlock('script'); ?>
<script type="text/javascript">
    $(function(){
        highlight_subnav('<?=U('article/mydocument')?>');
    })
</script>
<?php $this->endBlock();?>