<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/18
 * Time: 15:54
 */
$this->title = '用户信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content'); ?>
    <!-- 标题栏 -->
    <div class="main-title">
        <h2>用户列表</h2>
    </div>
    <div class="cf">
        <div class="fl">
            <a class="btn" href="<?=Yii::$app->homeUrl.'users/add'?>">新 增</a>
            <button class="btn" id="sendEmail" >发 邮</button>
            <button class="btn ajax-post" url="<?=Yii::$app->homeUrl.'users/changestatu?method=resumeUser'?>" target-form="ids">启 用</button>
            <button class="btn ajax-post" url="<?=Yii::$app->homeUrl.'users/changestatu?method=forbidUser'?>" target-form="ids">禁 用</button>
            <button class="btn ajax-post confirm" url="<?=Yii::$app->homeUrl.'users/changestatu?method=deleteUser'?>" target-form="ids">删 除</button>
        </div>

        <!-- 高级搜索 -->
        <div class="search-form fr cf">
            <div class="sleft">
                <input type="text" name="nickname" class="search-input" value="<?=Yii::$app->request->get('nickname')?>" placeholder="请输入用户昵称">
                <a class="sch-btn" href="javascript:;" id="search" url="<?=Yii::$app->homeUrl.'users/index'?>"><i class="btn-search"></i></a>
            </div>
        </div>
    </div>
    <!-- 数据列表 -->
    <div class="data-table table-striped">
        <table class="">
            <thead>
            <tr>
                <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
                <th class="">UID</th>
                <th class="">昵称</th>
                <th class="">邮箱</th>
                <th class="">积分</th>
                <th class="">登录次数</th>
                <th class="">最后登录时间</th>
                <th class="">最后登录IP</th>
                <th class="">状态</th>
                <th class="">操作</th>
            </tr>
            </thead>
            <tbody>

            <?php if(!empty($_Member['list'])){ ?>
                <?php foreach($_Member['list'] as $val){ ?>
                    <tr>
                        <td><input class="ids" type="checkbox" name="id[]" value="<?=$val['uid']?>" email="<?=$val['email']?>"/></td>
                        <td><?=$val['uid']?></td>
                        <td><?=$val['nickname']?></td>
                        <td><?=$val['email']?></td>
                        <td><?=$val['score']?></td>
                        <td><?=$val['login']?></td>
                        <td><span><?=date('Y-m-d H:i:s',$val['last_login_time'])?></span></td>
                        <td><span><?=long2ip($val['last_login_ip'])?></span></td>
                        <td><?=$val['status_text']?></td>
                        <td><?php if($val['status']==1){ ?>
                                <a href="<?=Yii::$app->homeUrl.'users/changestatu?method=forbidUser&id='.$val['uid'].''?>" class="ajax-get">禁用</a>
                            <?php }else{ ?>
                                <a href="<?=Yii::$app->homeUrl.'users/changestatu?method=resumeUser&id='.$val['uid'].''?>" class="ajax-get">启用</a>
                            <?php } ?>
                            <a href="<?=Yii::$app->homeUrl.'users/changestatu?method=deleteUser&id='.$val['uid'].''?>" class="confirm ajax-get">删除</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php }else{ ?>
                <td colspan="9" class="text-center"> aOh! 暂时还没有内容! </td>
            <?php } ?>
        </table>
    </div>
    <div class="page">
        <!--分页-->
        <?= \yii\widgets\LinkPager::widget(['pagination' =>$_Member['pagination']]); ?>
        <!--/分页-->
    </div>
    <div id="dialog" style="width: 300px;padding:10px;display: none">
        <input type="text" id="subject" placeholder="请输入邮件主题" class="form-control">
        <select class="selectCompose span2" id="emailcontent">

            <volist name="emailTitile" id="title"><option value="">{$title.title}</option></volist>
            <input class="btn" id="btn_send" type="button" value="发送">
        </select>
    </div>
<?php $this->endBlock();?>
<?php $this->beginBlock('script');?>
    <script type="text/javascript" src="<?=Yii::$app->homeUrl.'js/qtip/jquery.qtip.min.js'?>"></script>
    <link rel="stylesheet" type="text/css" href="<?=Yii::$app->homeUrl.'js/qtip/jquery.qtip.min.css'?>" media="all">
    <script type="text/javascript" charset="utf-8">
        +function($){
            var rules = [{$this_group.rules}];
        $('.auth_rules').each(function(){
            if( $.inArray( parseInt(this.value,10),rules )>-1 ){
                $(this).prop('checked',true);
            }
            if(this.value==''){
                $(this).closest('span').remove();
            }
        });

        //全选节点
        $('.rules_all').on('change',function(){
            $(this).closest('dl').find('dd').find('input').prop('checked',this.checked);
        });
        $('.rules_row').on('change',function(){
            $(this).closest('.rule_check').find('.child_row').find('input').prop('checked',this.checked);
        });

        $('.checkbox').each(function(){
            $(this).qtip({
                content: {
                    text: $(this).attr('title'),
                    title: $(this).text()
                },
                position: {
                    my: 'bottom center',
                    at: 'top center',
                    target: $(this)
                },
                style: {
                    classes: 'qtip-dark',
                    tip: {
                        corner: true,
                        mimic: false,
                        width: 10,
                        height: 10
                    }
                }
            });
        });

        $('select[name=group]').change(function(){
            location.href = this.value;
        });
        //导航高亮

        }(jQuery);
    </script>

<?php $this->endBlock(); ?>