<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/18
 * Time: 15:54
 */
$this->title = '配置管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2>配置管理 [
            <?php if($group_id!=0&&!empty($group_id)){?>
                <a href="<?=Yii::$app->homeUrl.'config/index'?>">全部</a>
            <?php }else{?>
                <strong>全部</strong>
            <?php }?>&nbsp;
            <?php foreach($group as $key=>$vo){?>
                <?php if($group_id!=$key){?>
                    <a href="<?=Yii::$app->homeUrl.'config/index?group='.$key?>"><?=$vo?></a><?php }else{?><strong><?=$vo?></strong><?php }?>&nbsp;
            <?php }?>
            ]</h2>
    </div>

    <div class="cf">
        <a class="btn" href="<?=U('config/add')?>">新 增</a>
        <a class="btn ajax-post confirm" url="<?=U('config/del')?>" target-form="ids">删 除</a>
        <button class="btn list_sort" url="<?=U('config/sort')?>">排序</button>

        <!-- 高级搜索 -->
        <div class="search-form fr cf">
            <div class="sleft">
                <input type="text" name="name" class="search-input" value="<?=Yii::$app->request->get('name')?>" placeholder="请输入配置名称">
                <a class="sch-btn" href="javascript:;" id="search" url="<?=Yii::$app->homeUrl.'config/index'?>"><i class="btn-search"></i></a>
            </div>
        </div>
    </div>

    <div class="data-table table-striped">
        <table>
            <thead>
            <tr>
                <th class="row-selected">
                    <input class="checkbox check-all" type="checkbox">
                </th>
                <th>ID</th>
                <th>名称</th>
                <th>标题</th>
                <th>分组</th>
                <th>类型</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($list['list'])){?>
                <?php foreach($list['list'] as $config){ ?>
                    <tr>
                        <td><input class="ids row-selected" type="checkbox" name="id[]" value="<?=$config['id']?>"></td>
                        <td><?=$config['id']?></td>
                        <td><a href="<?=U('config/edit?id='.$config['id'])?>"><?=$config['name']?></a></td>
                        <td><?=$config['title']?></td>
                        <td><?=\common\help\CommonHelper::get_config_group($config['group'])?></td>
                        <td><?= \common\help\CommonHelper::get_config_type($config['type']+1);//$config['type']?></td>
                        <td>
                            <a title="编辑" href="<?=U('config/edit?id='.$config['id'])?>">编辑</a>
                            <a class="confirm ajax-get" title="删除" href="<?=U('config/del?id='.$config['id'])?>">删除</a>
                        </td>
                    </tr>
                <?php }?>
            <?php }else{?>
            <td colspan="6" class="text-center"> aOh! 暂时还没有内容! </td>
            <?php } ?>
            </tbody>
        </table>
        <!-- 分页 -->
        <div class="page">
            <!--分页-->
            <?= \yii\widgets\LinkPager::widget(['pagination' =>$list['pagination']]); ?>
            <!--/分页-->
        </div>
    </div>
    <?php $this->endBlock(); ?>
    <?php $this->beginBlock('script'); ?>
    <script type="text/javascript">
        $(function(){
            //搜索功能
            $("#search").click(function(){
                var url = $(this).attr('url');
                var query  = $('.search-form').find('input').serialize();
                query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
                query = query.replace(/^&/g,'');
                if( url.indexOf('?')>0 ){
                    url += '&' + query;
                }else{
                    url += '?' + query;
                }
                window.location.href = url;
            });
            //回车搜索
            $(".search-input").keyup(function(e){
                if(e.keyCode === 13){
                    $("#search").click();
                    return false;
                }
            });
            //点击排序
            $('.list_sort').click(function(){
                var url = $(this).attr('url');
                var ids = $('.ids:checked');
                var param = '';
                if(ids.length > 0){
                    var str = new Array();
                    ids.each(function(){
                        str.push($(this).val());
                    });
                    param = str.join(',');
                }

                if(url != undefined && url != ''){
                    window.location.href = url + '?ids=' + param;
                }
            });
        });
        highlight_subnav('<?=U('config/group')?>');
        highLight_page('<?=U('config/index?page='.Yii::$app->request->get('page'))?>');
    </script>
    <?php $this->endBlock();?>