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
    <div class="tab-wrap">
        <ul class="tab-nav nav">
            <li class="current"><a href="javascript:;">访问授权</a></li>
            <li><a href="<?=U('authManager/category?group_name='.\common\help\HTMLHelper::_GET('group_name').'&group_id='.\common\help\HTMLHelper::_GET('group_id').'')?>">分类授权</a></li>
            <li><a href="<?=Yii::$app->homeUrl.'authmanager/user?group_name='.$_GET['group_name'].'&group_id='.$_GET['group_id']?>">成员授权</a></li>
            <li class="fr">
                <select name="group">
                    <?php foreach($data['auth_group'] as $val){?>
                        <?php if(Yii::$app->request->get('group_id')==$val['id']){?>
                            <option selected value="<?=Yii::$app->homeUrl.'authmanager/access?group_name='.$val['title'].'&group_id='.$val['id'].''?>"><?=$val['title']?></option>
                        <?php }else{?>
                            <option value="<?=Yii::$app->homeUrl.'authmanager/access?group_name='.$val['title'].'&group_id='.$val['id'].''?>"><?=$val['title']?></option>
                        <?php }?>
                    <?php }?>
                </select>
            </li>
        </ul>
        <div class="tab-content">
            <!-- 访问授权 -->
            <div class="tab-pane in">
                <form action="<?=Yii::$app->homeUrl.'authmanager/writegroup'?>" enctype="application/x-www-form-urlencoded" method="POST" class="form-horizontal auth-form">
                    <?php foreach($data['node_list'] as $node){?>
                        <!--                        --><?php //print_r($data['main_rules']); die();?>
                        <dl class="checkmod">
                            <dt class="hd">
                                <label class="checkbox"><input class="auth_rules rules_all" type="checkbox" name="rules[]" value="<?=$data['main_rules'][$node['url']]?>"><?=$node['title']?>管理</label>
                            </dt>
                            <dd class="bd">
                                <?php if(!empty($node['child'])){?>
                                    <?php foreach($node['child'] as $child){?>
                                        <div class="rule_check">
                                            <div>
                                                <label class="checkbox" <?php if(!empty($child['tip'])) echo 'title='.$child['tip']?>>
                                                    <input class="auth_rules rules_row" type="checkbox" name="rules[]" value="<?php echo $data['auth_rules'][$child['url']] ?>"/><?=$child['title']?>
                                                </label>
                                            </div>
                                            <?php if(!empty($child['operator'])){?>
                                                <span class="divsion">&nbsp;</span>
                                                <span class="child_row">
                                               <?php foreach($child['operator'] as $op){?>
                                                   <label class="checkbox" <?php if(!empty($op['tip'])) echo "title=".$op['tip']?>>
                                                       <input class="auth_rules" type="checkbox" name="rules[]"
                                                              value="<?php echo $data['auth_rules'][$op['url']] ?>"/><?=$op['title']?>
                                                   </label>
                                               <?php } ?>
                                           </span>
                                            <?php }?>
                                        </div>
                                    <?php }?>
                                <?php }?>
                            </dd>
                        </dl>
                    <?php } ?>

                    <input type="hidden" name="id" value="<?=$data['this_group']['id']?>" />
                    <button type="submit" class="btn submit-btn ajax-post" target-form="auth-form">确 定</button>
                    <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
                </form>
            </div>

            <!-- 成员授权 -->
            <div class="tab-pane"></div>
            <!-- 分类 -->
            <div class="tab-pane"></div>
        </div>
    </div>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('script')?>
    <script type="text/javascript" src="<?=Yii::$app->homeUrl.'js/qtip/jquery.qtip.min.js'?>"></script>
    <link rel="stylesheet" type="text/css" href="<?=Yii::$app->homeUrl.'js/qtip/jquery.qtip.min.css'?>" media="all">
    <script type="text/javascript" charset="utf-8">
        +function($){
            var rules =[<?=$data['this_group']['rules']?>];
            $('.auth_rules').each(function(){
                if( $.inArray( parseInt(this.value,10),rules )>-1 ){
                    $(this).prop('checked',true);
                }
//                if(this.value==''){
//                    $(this).closest('span').remove();
//                }
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
            //        highlight_subnav('{:U('AuthManager/index')}');
        }(jQuery);
    </script>
<?php $this->endBlock();?>