<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/15
 * Time: 14:33
 */
?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2>分类管理</h2>
    </div>

    <!-- 表格列表 -->
    <div class="tb-unit posr">
        <div class="tb-unit-bar">
            <a class="btn" href="<?=U('category/add')?>">新 增</a>
        </div>
        <div class="category">
            <div class="hd cf">
                <div class="fold">折叠</div>
                <div class="order">排序</div>
                <div class="order">发布</div>
                <div class="name">名称</div>
            </div>
            <?php  foreach($tree as $list){?>
                <dl class="cate-item">
                    <dt class="cf">
                    <form action="<?=U('category/edit')?>" method="post">
                        <div class="btn-toolbar opt-btn cf">
                            <a title="编辑" href="<?=U('category/edit?id='.$list['id'].'&pid='.$list['pid'])?>">编辑</a>
                            <a title="<?=show_status_op($list['status'])?>" href="<?=U('category/setstatus?ids='.$list['id'].'&status='.abs(1-$list['status']))?>" class="ajax-get"><?=show_status_op($list['status'])?></a>
                            <a title="删除" href="<?=U('category/remove?id='.$list['id'].'')?>" class="confirm ajax-get">删除</a>
                            <a title="移动" href="<?=U('category/operate?type=move&from='.$list['id'])?>">移动</a>
                        </div>
                        <div class="fold"><i></i></div>
                        <div class="order"><input type="text" name="sort" class="text input-mini" value="<?=$list['sort']?>"></div>
                        <div class="order"><?=$list['allow_publish']?'是':'否'?></div>
                        <div class="name">
                            <span class="tab-sign"></span>
                            <input type="hidden" name="id" value="<?=$list['id']?>">
                            <input type="text" name="title" class="text" value="<?=$list['title']?>">
                            <a class="add-sub-cate" title="添加子分类" href="<?=U('category/add?pid='.$list['id'])?>">
                                <i class="icon-add"></i>
                            </a>
                            <span class="help-inline msg"></span>
                        </div>
                    </form>
                    </dt>

                    <?php if(!empty($list['_'])){?>
                        <dd>
                            <?= Tree($list['_'])?>
                        </dd>
                    <?php }?>

                </dl>
            <?php }?>
        </div>
    </div>
    <!-- /表格列表 -->
<?php $this->endBlock(); ?>
<?php $this->beginBlock('script'); ?>
    <link href="/public/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<?php if(C('COLOR_STYLE')=='blue_color') { ?><link href="/public/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">';<?php }?>
    <link href="/public/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/public/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/public/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script type="text/javascript">
        (function($){
            highlight_subnav('<?=U('config/group')?>');
            /* 分类展开收起 */
            $(".category dd").prev().find(".fold i").addClass("icon-unfold")
                .click(function(){
                    var self = $(this);
                    if(self.hasClass("icon-unfold")){
                        self.closest("dt").next().slideUp("fast", function(){
                            self.removeClass("icon-unfold").addClass("icon-fold");
                        });
                    } else {
                        self.closest("dt").next().slideDown("fast", function(){
                            self.removeClass("icon-fold").addClass("icon-unfold");
                        });
                    }
                });

            /* 三级分类删除新增按钮 */
            $(".category dd dd .add-sub").remove();

            /* 实时更新分类信息 */
            $(".category")
                .on("submit", "form", function(){
                    var self = $(this);
                    $.post(
                        self.attr("action"),
                        self.serialize(),
                        function(data){
                            /* 提示信息 */
                            var name = data.status ? "success" : "error", msg;
                            msg = self.find(".msg").addClass(name).text(data.info)
                                .css("display", "inline-block");
                            setTimeout(function(){
                                msg.fadeOut(function(){
                                    msg.text("").removeClass(name);
                                });
                            }, 1000);
                        },
                        "json"
                    );
                    return false;
                })
                .on("focus","input",function(){
                    $(this).data('param',$(this).closest("form").serialize());

                })
                .on("blur", "input", function(){
                    if($(this).data('param')!=$(this).closest("form").serialize()){
                        $(this).closest("form").submit();
                    }
                });
        })(jQuery);
    </script>
<?php $this->endBlock(); ?>