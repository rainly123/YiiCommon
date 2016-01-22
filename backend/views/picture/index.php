<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/11
 * Time: 14:27
 */
$this->title = '图片管理';
?>
<?php $this->beginBlock('content'); ?>
<ul class="tab-nav nav">
    <li data-tab="tab1" class="current" ><a href="javascript:void(0);" >图片信息</a></li>
    <li data-tab="tab2"><a href="javascript:void(0);" >图片类型</a></li>
</ul>
<div class="tab-content">
    <div id="tab1" class="tab-pane in tab1">
        <div style="text-align: right">
            <select name="pic_method" id="pic_method">
                <option value="0">请选择浏览方式</option>
                <option value="1">平铺</option>
                <option value="2">列表</option>
            </select>
            <select name="pic_type" id="pic_type">
                <option value="0">请选择图片类型</option>
                <?php if(!empty($list)){?>
                    <?php foreach($list as $val){?>
                        <option value="<?=$val['id']?>"><?=$val['type_title']?></option>
                    <?php } ?>
                <?php } ?>
            </select>
            <input type="button" id="J_selectImage" class="btn" value="批量上传">
            <div id="J_imageView">
            </div>
        </div>
        <hr>
        <div id="icon_squire">
            <?php require_once 'image.php';?>
        </div>
        <div id="list" style="display: none">
            <div class="data-table table-striped">
                <table>
                    <thead>
                    <tr>
                        <th class="row-selected">
                            <input class="checkbox check-all" type="checkbox">
                        </th>
                        <th>ID</th>
                        <th>路径</th>
                        <th>MD5</th>
                        <th>sha1</th>
                        <th>title</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($piclist['list'])){?>
                        <?php foreach($piclist['list'] as $vo){ ?>
                            <tr>
                                <td><input class="ids row-selected" type="checkbox" name="id[]" value="<?=$vo['id']?>"></td>
                                <td><?=$vo['id']?></td>
                                <td><?=$vo['path']?></td>
                                <td><?=$vo['md5']?></td>
                                <td><?=$vo['sha1']?></td>
                                <td><?=$vo['title']?></td>
                                <td>
                                    <a title="编辑" href="<?=U('picture/picedit?id='.$vo['id'])?>">编辑</a>
                                    <a class="confirm ajax-get" title="删除" href="<?=U('picture/picdel?id='.$vo['id'])?>">删除</a>
                                </td>
                            </tr>
                        <?php }?>
                    <?php }else{?>
                        <td colspan="6" class="text-center"> aOh! 暂时还没有内容! </td>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="page">
                    <!--分页-->
                    <?= \yii\widgets\LinkPager::widget(['pagination' =>$piclist['pagination']]); ?>
                    <!--/分页-->
                </div>
            </div>
        </div>
    </div>
    <div id="tab2" class="tab-pane tab2">
        <div class="cf">
            <a class="btn" href="<?=U('picture/add')?>">新 增</a>
            <a class="btn" href="<?=U('picture/sort')?>">排序</a>
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
                        <th>最后更新</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($list)){?>
                        <?php foreach($list as $vo){ ?>
                            <tr>
                                <td><input class="ids row-selected" type="checkbox" name="id[]" value="<?=$vo['id']?>"></td>
                                <td><?=$vo['id']?></td>
                                <td><?=$vo['type_name']?></td>
                                <td><?=$vo['type_title']?></td>
                                <td><?=$vo['update_time']?></td>
                                <td>
                                    <a title="编辑" href="<?=U('picture/edit?id='.$vo['id'])?>">编辑</a>
                                    <a class="confirm ajax-get" title="删除" href="<?=U('picture/del?id='.$vo['id'])?>">删除</a>
                                </td>
                            </tr>
                        <?php }?>
                    <?php }else{?>
                        <td colspan="6" class="text-center"> aOh! 暂时还没有内容! </td>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('script'); ?>
<link rel="stylesheet" href="/public/kindeditor/themes/default/default.css" />
<script src="/public/kindeditor/kindeditor.js"></script>
<script src="/public/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    $(function(){
        var method=<?=isset($_GET['method'])?$_GET['method']:0?>;
        var type=<?=isset($_GET['type'])?$_GET['type']:0?>;
        setValue("#pic_method",method);
        setValue('#pic_type',type);
        is_hide(method);
        ///////选择浏览方式//////////////
        $("#pic_method").change(function(){
            var method=$(this).val();
            var type=$("#pic_type").val();
            location.href="<?=U('picture/index?method=')?>"+method+"&type="+type;
           is_hide(method);
        });
        $("#pic_type").change(function(){
            var type=$(this).val();
            var method=$("#pic_method").val();
            location.href="<?=U('picture/index?method=')?>"+method+"&type="+type;
        })
        KindEditor.ready(function(K) {
            K('#J_selectImage').click(function() {
                var type=$("#pic_type").val();
                var editor = K.editor({
                    allowFileManager : true,
                    uploadJson: '<?=U('file/mutilupload?type=')?>'+type
                });
                editor.loadPlugin('multiimage', function() {
                    editor.plugin.multiImageDialog({
                        clickFn : function(urlList) {
                            var div = K('#J_imageView');
                            div.html('');
                            K.each(urlList, function(i, data) {
                                div.append('<img src="' + data.url + '">');
                            });
                            editor.hideDialog();
                        }
                    });
                });
            });

        });
        function is_hide(method)
        {
            if(method==1){
                $("#icon_squire").css('display','block');
                $("#list").css('display','none');
            }
            else if(method==2){
                $("#icon_squire").css('display','none');
                $("#list").css('display','block');
            }
        }
        highlight_subnav('<?=U('config/group')?>');
        showTab();
    })

</script>
<?php $this->endBlock();?>
