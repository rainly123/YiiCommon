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

$this->title = '我的文档';
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
    <!-- 标题 -->
    <div class="main-title">
        <h2>
            我的文档(<?=$list['pagination']->totalCount?>)
        </h2>
    </div>

    <!-- 按钮工具栏 -->
    <div class="cf">
        <div class="fl">
            <button class="btn document_add" url="<?=U('article/add?cate_id='.$cate_id.'&model_id=2&pid='.HTMLHelper::_GET('pid').'')?>">新 增
            </button>
            <button class="btn"  id="change_memcahce">更新缓存</button>
            <button class="btn ajax-post" target-form="ids" url="<?=U('article/setstatus?status=1')?>">启 用</button>
            <button class="btn ajax-post" target-form="ids" url="<?=U('article/setstatus?status=0')?>">禁 用</button>
            <button class="btn ajax-post confirm" target-form="ids" url="<?=U('article/setstatus?status=-1')?>">删 除</button>
            <button class="btn list_sort" url="<?=U('article/sort?cate_id='.$cate_id.'')?>">排序</button>
        </div>

        <!-- 高级搜索 -->
        <div class="search-form fr cf">
            <div class="sleft">
                <div class="drop-down">
                    <span id="sch-sort-txt" class="sort-txt" data="<?=$status?>"><?php if(get_status_title($status)==''){?>所有<?php }else{?><?=get_status_title($status)?><?php }?></span>
                    <i class="arrow arrow-down"></i>
                    <ul id="sub-sch-menu" class="nav-list hidden">
                        <li><a href="javascript:;" value="">所有</a></li>
                        <li><a href="javascript:;" value="1">正常</a></li>
                        <li><a href="javascript:;" value="0">禁用</a></li>
                        <li><a href="javascript:;" value="2">待审核</a></li>
                    </ul>
                </div>
                <input type="text" name="title" class="search-input" value="<?=Yii::$app->request->get('title')?>" placeholder="请输入标题文档">
                <a class="sch-btn" href="javascript:;" id="search" url="<?=U('article/mydocument?pid='.I('pid').'')?>"><i class="btn-search"></i></a>
            </div>
            <div class="btn-group-click adv-sch-pannel fl">
                <button class="btn">高 级<i class="btn-arrowdown"></i></button>
                <div class="dropdown cf">
                    <div class="row">
                        <label>创建时间：</label>
                        <input type="text" id="time-start" name="time-start" class="text input-2x" value="" placeholder="起始时间" /> -
                        <div class="input-append date" id="datetimepicker"  style="display:inline-block">
                            <input type="text" id="time-end" name="time-end" class="text input-2x" value="" placeholder="结束时间" />
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <td><?=$vo['status_text']?> </td>
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
    <link href="/public/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
    <?php if(C('COLOR_STYLE')=='blue_color'){?> <link href="/public/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css"><?php }?>
    <link href="/public/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/public/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/public/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script type="text/javascript">
        $(function(){
            highlight_subnav('<?=U('article/mydocument')?>');
            //搜索功能
            $("#search").click(function(){
                var url = $(this).attr('url');
                var status = $("#sch-sort-txt").attr("data");
                var query  = $('.search-form').find('input').serialize();
                query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
                query = query.replace(/^&/g,'');
                if(status != ''){
                    query += 'status=' + status + "&" + query;
                }
                if( url.indexOf('?')>0 ){
                    url += '&' + query;
                }else{
                    url += '?' + query;
                }
                window.location.href = url;
            });

            /* 状态搜索子菜单 */
            $(".search-form").find(".drop-down").hover(function(){
                $("#sub-sch-menu").removeClass("hidden");
            },function(){
                $("#sub-sch-menu").addClass("hidden");
            });
            $("#sub-sch-menu li").find("a").each(function(){
                $(this).click(function(){
                    var text = $(this).text();
                    $("#sch-sort-txt").text(text).attr("data",$(this).attr("value"));
                    $("#sub-sch-menu").addClass("hidden");
                })
            });

            //只有一个模型时，点击新增
            $('.document_add').click(function(){
                var url = $(this).attr('url');
                if(url != undefined && url != ''){
                    window.location.href = url;
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
                    window.location.href = url + '&ids=' + param;
                }
            });

            //回车自动提交
            $('.search-form').find('input').keyup(function(event){
                if(event.keyCode===13){
                    $("#search").click();
                }
            });

            $('#time-start').datetimepicker({
                format: 'yyyy-mm-dd',
                language:"zh-CN",
                minView:2,
                autoclose:true
            });

            $('#time-end').datetimepicker({
                format: 'yyyy-mm-dd',
                language:"zh-CN",
                minView:2,
                autoclose:true
            });

        })
    </script>
<?php $this->endBlock();?>