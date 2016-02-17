<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\help\HTMLHelper;
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
    <div class="tab-wrap">
        <ul class="tab-nav nav">
            <li><a href="<?=U('authmanager/access?group_name='.$_GET['group_name'].'&group_id='.$_GET['group_id'].'')?>">访问授权</a></li>
            <li class="current"><a href="javascript:;">成员授权</a></li>
            <li class="fr">
                <select name="group">
                    <?php foreach($data['auth_group'] as $val){?>
                        <?php if(Yii::$app->request->get('group_id')==$val['id']){?>
                            <option selected value="<?=Yii::$app->homeUrl.'authmanager/user?group_name='.$val['title'].'&group_id='.$val['id'].''?>"><?=$val['title']?></option>
                        <?php }else{?>
                            <option value="<?=Yii::$app->homeUrl.'authmanager/user?group_name='.$val['title'].'&group_id='.$val['id'].''?>"><?=$val['title']?></option>
                        <?php }?>
                    <?php }?>
                </select>
            </li>
        </ul>
        <!-- 数据列表 -->
        <div class="data-table table-striped">
            <table class="">
                <thead>
                <tr>
                    <th class="">UID</th>
                    <th class="">昵称</th>
                    <th class="">最后登录时间</th>
                    <th class="">最后登录IP</th>
                    <th class="">状态</th>
                    <th class="">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($data['_list']['user_list'])){ ?>
                <?php foreach($data['_list']['user_list'] as $vo){?>
                    <tr>
                        <td><?=$vo['uid']?> </td>
                        <td><?=$vo['nickname']?></td>
                        <td><span><?=HTMLHelper::ToDate($vo['last_login_time'])?></span></td>
                        <td><span><?=long2ip($vo['last_login_ip'])?></span></td>
                        <td><?=$vo['status_text']?></td>
                        <td><a href="{:U('AuthManager/removeFromGroup?uid='.$vo['uid'].'&group_id='.I('group_id'))}" class="ajax-get">解除授权</a>

                        </td>
                    </tr>
                <?php }?>
                <?php }else{ ?>
                    <td colspan="9" class="text-center"> aOh! 暂时还没有内容! </td>
                <?php }?>
                </tbody>
            </table>
            <div class="page">
                <?= \yii\widgets\LinkPager::widget(['pagination' =>$data['_list']['pages']]); ?>
            </div>

        </div>
        <div class="main-title">
            <div id="add-to-group" class="tools fr">
                <form class="add-user" action="{:U('addToGroup')}" method="post" enctype="application/x-www-form-urlencoded" >
                    <input class="text input-4x" type="text" name="uid" placeholder="请输入uid,多个用英文逗号分隔">
                    <input type="hidden" name="group_id" value="{:I('group_id')}">
                    <button type="submit" class="btn ajax-post" target-form="add-user">新 增</button>
                </form>
            </div>
        </div>

    </div>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('script');?>
    <script type="text/javascript" charset="utf-8">
        $('select[name=group]').change(function(){
            location.href = this.value;
        });
        //导航高亮
//        highlight_subnav('{:U('AuthManager/index')}');
    </script>
<?php $this->endBlock();?>