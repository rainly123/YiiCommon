<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/17
 * Time: 18:05
 */
$this->title = '权限管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content'); ?>
    <!-- 标题栏 -->
    <div class="main-title">
        <h2>权限管理</h2>
    </div>

    <div class="tools auth-botton">
        <a id="add-group" class="btn" href="<?=Yii::$app->homeUrl.'authmanager/creategroup'?>">新 增</a>
        <a url="<?=Yii::$app->homeUrl.'authmanager/changestatus?method=resumeGroup'?>" class="btn ajax-post" target-form="ids" >启 用</a>
        <a url="<?=Yii::$app->homeUrl.'authmanager/changestatus?method=forbidGroup '?>" class="btn ajax-post" target-form="ids" >禁 用</a>
        <a url="<?=Yii::$app->homeUrl.'authmanager/changestatus?method=deleteGroup'?>" class="btn ajax-post confirm" target-form="ids" >删 除</a>
    </div>
    <!-- 数据列表 -->
    <div class="data-table table-striped">
        <table class="">
            <thead>
            <tr>
                <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
                <th class="">用户组</th>
                <th class="">描述</th>

                <th class="">授权</th>
                <th class="">状态</th>
                <th class="">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($AuthGroup['list'])){ foreach($AuthGroup['list'] as $val){ ?>
                <tr>
                    <td><input class="ids" type="checkbox" name="id[]" value="<?=$val['id']?>" /></td>
                    <td><a href="<?=Yii::$app->homeUrl.'authmanager/editgroup?id='.$val['id']?>"><?=$val['title']?></a> </td>
                    <td><span><?=$val['description']?></span></td>
                    <td><a href="<?=Yii::$app->homeUrl.'authmanager/access?group_name='.$val['title'].'&group_id='.$val['id']?>" >访问授权</a>
                        <a href="<?=Yii::$app->homeUrl.'authmanager/user?group_name='.$val['title'].'&group_id='.$val['id']?>" >成员授权</a>
                    </td>
                    <td><?=$val['status_text']?></td>
                    <td>
                        <?php if($val['status']==1){?>
                            <a href="<?=Yii::$app->homeUrl.'authmanager/changestatus?method=forbidGroup&id='.$val['id']?>" class="ajax-get">禁用</a>
                        <?php }else{?>
                            <a href="<?=Yii::$app->homeUrl.'authmanager/changestatus?method=resumeGroup&id='.$val['id']?>" class="ajax-get">启用</a>
                        <?php }?>
                        <a href="<?=Yii::$app->homeUrl.'authmanager/changestatus?method=deleteGroup&id='.$val['id']?>" class="confirm ajax-get">删除</a>
                    </td>
                </tr>
            <?php }}else{ ?>
                <td colspan="6" class="text-center"> aOh! 暂时还没有内容! </td>
            <?php } ?>
            </tbody>
        </table>

    </div>
    <div class="page">
        <!--分页-->
        <?= \yii\widgets\LinkPager::widget(['pagination' =>$AuthGroup['pagination']]); ?>
        <!--/分页-->
    </div>
<?php $this->endBlock(); ?>