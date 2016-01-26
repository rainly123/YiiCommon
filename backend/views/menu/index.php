<?php
use common\help\HTMLHelper;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/11
 * Time: 17:40
 */
$this->title='菜单管理';
?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2><?php if(!empty($data)){?>[ <?=$data['title']?>] 子<?php }?>菜单管理 </h2>
    </div>
    <div class="cf">
        <a class="btn" href="<?=U('menu/add?pid='.HTMLHelper::_GET('pid'))?>">新 增</a>
        <button class="btn ajax-post confirm" url="<?=U('menu/del')?>" target-form="ids">删 除</button>
        <button class="btn list_sort" url="<?=U('menu/sort?pid='.HTMLHelper::_GET('pid').'')?>">排序</button>
        <!-- 高级搜索 -->
        <div class="search-form fr cf">
            <div class="sleft">
                <input type="text" name="title" class="search-input" value="<?=Yii::$app->request->get('title')?>" placeholder="请输入菜单名称">
                <a class="sch-btn" href="javascript:;" id="search" url="<?=U('menu/index')?>"><i class="btn-search"></i></a>
            </div>
        </div>
    </div>

    <div class="data-table table-striped">
        <form class="ids">
            <table>
                <thead>
                <tr>
                    <th class="row-selected">
                        <input class="checkbox check-all" type="checkbox">
                    </th>
                    <th>ID</th>
                    <th>名称</th>
                    <th>上级菜单</th>
                    <th>分组</th>
                    <th>URL</th>
                    <th>排序</th>
                    <th>仅开发者模式显示</th>
                    <th>隐藏</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
              <?php if(!empty($list)){?>
                    <?php foreach($list as $menu){?>
                        <tr>
                            <td><input class="ids row-selected" type="checkbox" name="id[]" value="<?=$menu['id']?>"></td>
                            <td><?=$menu['id']?></td>
                            <td>
                                <a href="<?=U('menu/index?pid='.$menu['id'])?>"><?=$menu['title']?></a>
                            </td>
                            <td><?=isset($menu['up_title'])?$menu['up_title']:"无"?></td>
                            <td><?=$menu['group']?></td>
                            <td><?=$menu['url']?></td>
                            <td><?=$menu['sort']?></td>
                            <td>
                                <a href="<?=U('menu/toogledev?id='.$menu['id'].'&value='.abs($menu['is_dev']-1))?>" class="ajax-get">
                                    <?=$menu['is_dev_text']?>
                                </a>
                            </td>
                            <td>
                                <a href="<?=U('menu/tooglehide?id='.$menu['id'].'&value='.abs($menu['hide']-1))?>" class="ajax-get">
                                    <?=$menu['hide_text']?>
                                </a>
                            </td>
                            <td>
                                <a title="编辑" href="<?=U('menu/edit?id='.$menu['id'])?>">编辑</a>
                                <a class="confirm ajax-get" title="删除" href="<?=U('menu/del?id='.$menu['id'])?>">删除</a>
                            </td>
                        </tr>
                  <?php }?>
                    <?php }else{?>
                    <td colspan="10" class="text-center"> aOh! 暂时还没有内容! </td>
               <?php }?>
                </tbody>
            </table>
        </form>
        <!-- 分页 -->
        <div class="page">

        </div>
    </div>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('script'); ?>
    <script type="text/javascript">
        $(function() {
            //搜索功能
            $("#search").click(function() {
                var url = $(this).attr('url');
                var query = $('.search-form').find('input').serialize();
                query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g, '');
                query = query.replace(/^&/g, '');
                if (url.indexOf('?') > 0) {
                    url += '&' + query;
                } else {
                    url += '?' + query;
                }
                window.location.href = url;
            });
            //回车搜索
            $(".search-input").keyup(function(e) {
                if (e.keyCode === 13) {
                    $("#search").click();
                    return false;
                }
            });
            //导航高亮
            highlight_subnav('<?=U('config/group')?>');
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
                    window.location.href = url + '&ids=' + param;
                }
            });
        });
    </script>
<?php $this->endBlock();?>