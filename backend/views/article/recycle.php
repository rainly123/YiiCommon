<?php
use backend\assets\AppAsset;
use common\help\HTMLHelper;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/17
 * Time: 18:05
 * /* @var $this \yii\web\View */
/* @var $content string */

$this->title = '回收站';
$this->params['breadcrumbs'][] = $this->title;
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
    <!-- 标题栏 -->
    <div class="main-title">
        <h2>回收站(<?=$list['pagination']->totalCount?>)</h2>
    </div>
    <div class="tools auth-botton">
        <button url="<?=U('article/clear')?>" class="btn ajax-get">清 空</button>
        <button url="<?=U('article/permit')?>" class="btn ajax-post" target-form="ids">还 原</button>
    </div>
    <!-- 数据列表 -->
    <div class="data-table table-striped">
        <table class="">
            <thead>
            <tr>
                <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
                <th class="">编号</th>
                <th class="">标题</th>
                <th class="">创建者</th>
                <th class="">类型</th>
                <th class="">分类</th>
                <th class="">删除时间</th>
                <th class="">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($list['list'])){?>
                <?php foreach($list['list'] as $vo){?>
                    <tr>
                        <td><input class="ids" type="checkbox" name="ids[]" value="<?=$vo['id']?>" /></td>
                        <td><?=$vo['id']?> </td>
                        <td><?=$vo['title']?></td>
                        <td><?=get_nickname($vo['uid'])?> </td>
                        <td><span><?=get_document_type($vo['type'])?></span></td>
                        <td><span><?=get_cate($vo['category_id'])?></span></td>
                        <td><span><?=time_format($vo['update_time'])?></span></td>
                        <td><a href="<?=U('article/permit?ids='.$vo['id'])?>" class="ajax-get">还原</a>
                        </td>
                    </tr>
                <?php }?>
            <?php }?>
            </tbody>
        </table>

    </div>
    <div class="page">
        <?= \yii\widgets\LinkPager::widget(['pagination' =>$list['pagination']]); ?>
    </div>
<?php $this->endBlock();?>
<?php $this->beginBlock('script'); ?>

<?php $this->endBlock();?>