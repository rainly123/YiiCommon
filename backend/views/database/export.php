<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/16
 * Time: 11:58
 */
$this->title='数据库备份';
?>
<?php $this->beginBlock('content'); ?>
<!-- 标题栏 -->
<div class="main-title">
    <h2>数据备份</h2>
</div>
<!-- /标题栏 -->

<div class="cf">
    <a id="export" class="btn" href="javascript:;" autocomplete="off">立即备份</a>
    <a id="optimize" class="btn" href="<?=U('database/optimize')?>">优化表</a>
    <a id="repair" class="btn" href="<?=U('database/repair')?>">修复表</a>
</div>

<!-- 应用列表 -->
<div class="data-table table-striped">
    <form id="export-form" method="post" action="<?=U('database/export')?>">
        <table>
            <thead>
            <tr>
                <th width="48"><input class="check-all" checked="chedked" type="checkbox" value=""></th>
                <th>表名</th>
                <th width="120">数据量</th>
                <th width="120">数据大小</th>
                <th width="160">创建时间</th>
                <th width="160">备份状态</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($list as $table){?>
                <tr>
                    <td class="num">
                        <input class="ids" checked="chedked" type="checkbox" name="tables[]" value="<?=$table['Name']?>">
                    </td>
                    <td><?=$table['Name']?></td>
                    <td><?=$table['Rows']?></td>
                    <td><?=format_bytes($table['Data_length'])?></td>
                    <td><?=$table['Create_time']?></td>
                    <td class="info">未备份</td>
                    <td class="action">
                        <a class="ajax-get no-refresh" href="<?=U('database/optimize?tables='.$table['Name'])?>">优化表</a>&nbsp;
                        <a class="ajax-get no-refresh" href="<?=U('database/repair?tables='.$table['Name'])?>">修复表</a>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </form>
</div>
<!-- /应用列表 -->
<?php $this->endBlock();?>
<?php $this->beginBlock('script'); ?>
<script type="text/javascript">
    (function($){
        var $form = $("#export-form"), $export = $("#export"), tables
        $optimize = $("#optimize"), $repair = $("#repair");

        $optimize.add($repair).click(function(){
            $.post(this.href, $form.serialize(), function(data){
                console.log(data);
                if(data.status){
                    updateAlert(data.info,'alert-success');
                } else {
                    updateAlert(data.info,'alert-error');
                }
                setTimeout(function(){
                    $('#top-alert').find('button').click();
                    $(that).removeClass('disabled').prop('disabled',false);
                },1500);
            }, "json");
            return false;
        });

        $export.click(function(){
            $export.parent().children().addClass("disabled");
            $export.html("正在发送备份请求...");
            $.post(
                $form.attr("action"),
                $form.serialize(),
                function(data){
                    if(data.status){
                        tables = data.data.tables;
                        $export.html(data.info + "开始备份，请不要关闭本页面！");;
                        backup(data.data.tab);
                        window.onbeforeunload = function(){ return "正在备份数据库，请不要关闭！" }
                    } else {
                        updateAlert(data.info,'alert-error');
                        $export.parent().children().removeClass("disabled");
                        $export.html("立即备份");
                        setTimeout(function(){
                            $('#top-alert').find('button').click();
                            $(that).removeClass('disabled').prop('disabled',false);
                        },1500);
                    }
                },
                "json"
            );
            return false;
        });

        function backup(tab, status){
            status && showmsg(tab.id, "开始备份...(0%)");
            $.get($form.attr("action"), tab, function(data){
                console.log(data);
                if(data.status){
                    showmsg(tab.id, data.info);
                    if(!$.isPlainObject(data.data.tab)){
                        $export.parent().children().removeClass("disabled");
                        $export.html("备份完成，点击重新备份");
                        window.onbeforeunload = function(){ return null }
                        return;
                    }
                    backup(data.data.tab, tab.id != data.data.tab.id);
                } else {
                    updateAlert(data.info,'alert-error');
                    $export.parent().children().removeClass("disabled");
                    $export.html("立即备份");
                    setTimeout(function(){
                        $('#top-alert').find('button').click();
                        $(that).removeClass('disabled').prop('disabled',false);
                    },1500);
                }
            }, "json");

        }
        function showmsg(id, msg){
            $form.find("input[value=" + tables[id] + "]").closest("tr").find(".info").html(msg);
        }
    })(jQuery);
</script>
<?php $this->endBlock();?>
