<?php
use common\help\HTMLHelper;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/24
 * Time: 13:11
 */
$this->title = '编辑文档';
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
    <div class="main-title cf">
        <h2>
            <?php if(!empty($data)){?>
                编辑[
                <a href="<?=U('article/index?cate_id='.$data['parent_category_id'])?>"><?=$data['parent_category_text']?></a>>
                <a href="<?=U('article/index?cate_id='.$data['category_id'])?>"><?=$data['category_text']?></a>
                ]
            <?php }else{?>
                <a href="<?=U('article/index?cate_id='.$cate_id)?>"><?=$cate_name?></a>
            <?php }?>
        </h2>
    </div>
    <!-- 标签页导航 -->
    <div class="tab-wrap">
        <ul class="tab-nav nav">
            <?php foreach(parse_config_attr($model['field_group']) as $key=>$group){?>
                <li data-tab="tab<?=$key?>" <?php if($key==1){?>class="current"<?php }?>><a href="javascript:void(0);"><?=$group?></a></li>
            <?php }?>
        </ul>
        <div class="tab-content">
            <!-- 表单 -->
            <form id="form" action="<?=U('article/update')?>" method="post" class="form-horizontal">
                <!-- 基础文档模型 -->
                <?php foreach(parse_config_attr($model['field_group']) as $key=>$group){?>
                    <div id="tab<?=$key?>" class="tab-pane <?=$key==1?'in':''?> tab<?=$key?>">
                        <?php foreach($fields[$key] as $field){?>
                            <?php if($field['is_show']==1||$field['is_show']==3){?>
                                <div class="form-item cf">
                                    <label class="item-label"><?=$field['title']?><span class="check-tips"><?=isset($field['remark'])?$field['remark']:''?></span></label>
                                    <div class="controls">
                                        <?php switch ($field['type']):case 'num' :?>
                                        <input type="text" class="text input-medium" name="<?=$field['name']?>" value="<?=isset($data[$field['name']])?$data[$field['name']]:0?>">
                                        <?php break;?>
                                        <case value="string">
                                            <?php case 'string':?>
                                                <input type="text" class="text input-large" name="<?=$field['name']?>" value="<?=isset($data[$field['name']])?$data[$field['name']]:''?>">
                                                <?php break;?>
                                            <?php case 'textarea':?>
                                                <label class="textarea input-large">
                                                    <textarea name="<?=$field['name']?>"><?=isset($data[$field['name']])?$data[$field['name']]:''?></textarea>
                                                </label>
                                                <?php break;?>
                                            <?php case 'datetime':?>
                                                <input type="text" name="<?=$field['name']?>" class="text input-large time" value="<?=time_format(isset($data[$field['name']])?$data[$field['name']]:'')?>" placeholder="请选择时间" />
                                                <?php break; ?>
                                            <?php case 'bool':?>
                                                <select name="<?=$field['name']?>">
                                                    <?php foreach(parse_field_attr($field) as $key=>$vo){?>
                                                        <option value="<?=$key?>" <?=$data[$field['name']]==$key?'selected':''?>><?=$vo?></option>
                                                    <?php }?>
                                                </select>
                                                <?php break;?>
                                            <?php case 'select':?>
                                                <select name="<?=$field['name']?>">
                                                    <?php foreach(parse_field_attr($field['extra']) as $key=>$vo){?>
                                                        <option value="<?=$key?>" <?=isset($data[$field['name']])?$data[$field['name']]:''==$key?'selected':''?>><?=$vo?></option>
                                                    <?php }?>
                                                </select>
                                                <?php break;?>
                                            <?php case 'radio':?>
                                                <?php foreach(parse_field_attr($field['extra']) as $key=>$vo){?>
                                                    <label class="radio">
                                                        <input type="radio" value="<?=$key?>" name="<?=$field['name']?>" <?=isset($data[$field['name']])?$data[$field['name']]:''==$key?'selected':''?>><?=$vo?>
                                                    </label>
                                                <?php }?>
                                                <?php break;?>
                                            <?php case 'checkbox' :?>
                                                <?php foreach(parse_field_attr($field['extra']) as $key=>$vo){?>
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="<?=$key?>" name="<?$field['name']?>[]" <?php if(check_document_position(isset($data[$field['name']])?$data[$field['name']]:'',$key)){?>checked="checked"<?php }?>><?=$vo?>
                                                    </label>
                                                <?php }?>
                                                <?php break;?>
                                            <?php case 'editor':?>
                                                <label class="textarea">
                                                    <textarea name="<?=$field['name']?>"><?=isset($data[$field['name']])?$data[$field['name']]:''?></textarea>
                                                </label>
                                                <link rel="stylesheet" href="/public/kindeditor/themes/default/default.css" />
                                                <link rel="stylesheet" href="/public/kindeditor/plugins/code/prettify.css" />
                                                <script charset="utf-8" src="/public/kindeditor/kindeditor.js"></script>
                                                <script charset="utf-8" src="/public/kindeditor/lang/zh_CN.js"></script>
                                                <!--                                                <script charset="utf-8" src="/public/kindeditor/plugins/code/prettify.js"></script>-->
                                                <script>
                                                    KindEditor.ready(function(K) {
                                                        var editor1 = K.create('textarea[name="<?=$field['name']?>"]', {
                                                            width: '100%',
                                                            height: '500px',
                                                            resizeType: 1,
                                                            pasteType : 2,
                                                            urlType : 'absolute',
                                                            cssPath : '/public/kindeditor/plugins/code/prettify.css',
                                                            uploadJson : '/public/kindeditor/php/upload_json.php',
                                                            fileManagerJson : '/public/kindeditor/php/file_manager_json.php',
                                                            allowFileManager : true
                                                    });
                                                </script>
                                                <?php break;?>
                                            <?php case 'picture':?>
                                                <div class="controls">
                                                    <input type="file" id="upload_picture_<?=$field['name']?>">
                                                    <input type="hidden" name="<?=$field['name']?>" id="cover_id_<?=$field['name']?>" value="<?=isset($data[$field['name']])?$data[$field['name']]:''?>"/>
                                                    <div class="upload-img-box">
                                                        <?php if(!empty($data[$field['name']])):?>
                                                            <div class="upload-pre-item"><img src="<?=get_cover($data[$field['name']],'path')?>"/></div>
                                                        <?php endif ;?>
                                                    </div>
                                                </div>
                                                <script type="text/javascript" src="<?=Yii::$app->homeUrl.'js/jquery-2.0.3.min.js'?>"></script>
                                                <script type="text/javascript" src="<?=Yii::$app->homeUrl?>js/uploadify/jquery.uploadify.min.js"></script>
                                                <script type="text/javascript">
                                                    //上传图片
                                                    /* 初始化上传插件 */
                                                    $("#upload_picture_<?=$field['name']?>").uploadify({
                                                        "height"          : 30,
                                                        "swf"             : "<?=Yii::$app->homeUrl?>js/uploadify/uploadify.swf",
                                                        "fileObjName"     : "download",
                                                        "buttonText"      : "上传图片",
                                                        "uploader"        : "<?=U('file/uploadpicture?session_id='.session_id())?>",
                                                        "width"           : 120,
                                                        'removeTimeout'	  : 1,
                                                        'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
                                                        "onUploadSuccess" : uploadPicture<?=$field['name']?>,
                                                        'onFallback' : function() {
                                                            alert('未检测到兼容版本的Flash.');
                                                        }
                                                    });
                                                    function uploadPicture<?=$field['name']?>(file, data){
                                                        var data = $.parseJSON(data);
                                                        var src = '';
                                                        if(data.status){
                                                            $("#cover_id_<?=$field['name']?>").val(data.id);
                                                            src = data.url || '' + data.path
                                                            $("#cover_id_<?=$field['name']?>").parent().find('.upload-img-box').html(
                                                                '<div class="upload-pre-item"><img src="' + src + '"/></div>'
                                                            );
                                                        } else {
                                                            updateAlert(data.info);
                                                            setTimeout(function(){
                                                                $('#top-alert').find('button').click();
                                                                $(that).removeClass('disabled').prop('disabled',false);
                                                            },1500);
                                                        }
                                                    }
                                                </script>
                                                <?php break;?>
                                            <?php case 'file':?>
                                                <div class="controls">
                                                    <input type="file" id="upload_file_<?=$field['name']?>">
                                                    <input type="hidden" name="<?=$field['name']?>" value="<?=yii_encrypt(json_encode(get_table_field($data[$field['name']],'id','','File')))?>"/>
                                                    <div class="upload-img-box">
                                                        <?php if (!empty($data[$field['name']])){?>
                                                            <div class="upload-pre-file"><span class="upload_icon_all"></span><?=get_table_field($data[$field['name']],'id','name','File')?></div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <script type="text/javascript">
                                                    //上传图片
                                                    /* 初始化上传插件 */
                                                    $("#upload_file_<?=$field['name']?>").uploadify({
                                                        "height"          : 30,
                                                        "swf"             : "<?=Yii::$app->homeUrl?>/uploadify/uploadify.swf",
                                                        "fileObjName"     : "download",
                                                        "buttonText"      : "上传附件",
                                                        "uploader"        : "<?=U('file/uploadpicture?session_id='.session_id())?>",
                                                        "width"           : 120,
                                                        'removeTimeout'	  : 1,
                                                        "onUploadSuccess" : uploadFile<?=$field['name']?>,
                                                        'onFallback' : function() {
                                                            alert('未检测到兼容版本的Flash.');
                                                        }
                                                    });
                                                    function uploadFile<?=$field['name']?>(file, data){
                                                        var data = $.parseJSON(data);
                                                        if(data.status){
                                                            var name = "<?=$field['name']?>";
                                                            $("input[name="+name+"]").val(data.data);
                                                            $("input[name="+name+"]").parent().find('.upload-img-box').html(
                                                                "<div class=\"upload-pre-file\"><span class=\"upload_icon_all\"></span>" + data.info + "</div>"
                                                            );
                                                        } else {
                                                            updateAlert(data.info);
                                                            setTimeout(function(){
                                                                $('#top-alert').find('button').click();
                                                                $(that).removeClass('disabled').prop('disabled',false);
                                                            },1500);
                                                        }
                                                    }
                                                </script>
                                                <?php break;?>
                                            <?php default :?>
                                                <input type="text" class="text input-large" name="<?=$field['name']?>" value="<?=$data[$field['name']]?>">
                                                <?php break; ?>
                                            <?php endswitch ;?>
                                    </div>
                                </div>
                            <?php }?>
                        <?php }?>
                    </div>
                <?php }?>

                <div class="form-item cf">
                    <button class="btn submit-btn ajax-post hidden" id="submit" type="submit" target-form="form-horizontal">确 定</button>
                    <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
                    <?php if(\common\help\CommonHelper::C('OPEN_DRAFTBOX') &&HTMLHelper::getAction()||isset($data['status'])?$data['status']:0==3){?>
                        <button class="btn save-btn" url="<?=U('article/autosave')?>" target-form="form-horizontal" id="autoSave">
                            存草稿
                        </button>
                    <?php }?>
                    <input type="hidden" name="id" value="<?=isset($data['id'])?$data['id']:0?>"/>
                    <input type="hidden" name="pid" value="<?=isset($data['pid'])?$data['pid']:0?>"/>
                    <input type="hidden" name="model_id" value="<?=isset($data['model_id'])?$data['model_id']:0?>"/>
                    <input type="hidden" name="category_id" value="<?=isset($data['category_id'])?$data['category_id']:0?>">
                </div>
            </form>
        </div>
    </div>
<?php $this->endBlock();?>

<?php $this->beginBlock('script'); ?>
    <link href="/public/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<?php if(C('COLOR_STYLE')=='blue_color'){ ?> <link href="/public/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">';<?php }?>
    <link href="/public/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/public/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/public/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script type="text/javascript">
        setValue("type",<?=isset($data['type'])?$data['type']:''?>);
        setValue("display",<?=isset($data['display'])?$data['display']:0?>);

        $('#submit').click(function(){
            var html= $(".ke-edit-iframe").contents().find("body").html();
            $("textarea[name='content']").val(html);
            $('#form').submit();
        });
        $(function(){
            $('.time').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language:"zh-CN",
                minView:2,
                autoclose:true
            });
            showTab();

            //            <if condition="C('OPEN_DRAFTBOX') and (ACTION_NAME eq 'add' or $data['status'] eq 3)">
            <?php if(\common\help\CommonHelper::C('OPEN_DRAFTBOX')&&HTMLHelper::getAction()=='add'||isset($data['status'])?$data['status']:0==3){?>
            //保存草稿
            var interval;
            $('#autoSave').click(function(){
                var target_form = $(this).attr('target-form');
                var target = $(this).attr('url')
                var form = $('.'+target_form);
                var query = form.serialize();
                var that = this;

                $(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
                $.post(target,query).success(function(data){
                    if (data.status==1) {
                        updateAlert(data.info ,'alert-success');
                        $('input[name=id]').val(data.data.id);
                    }else{
                        updateAlert(data.info);
                    }
                    setTimeout(function(){
                        $('#top-alert').find('button').click();
                        $(that).removeClass('disabled').prop('disabled',false);
                    },1500);
                })

                //重新开始定时器
                clearInterval(interval);
                autoSaveDraft();
                return false;
            });

            //Ctrl+S保存草稿
            $('body').keydown(function(e){
                if(e.ctrlKey && e.which == 83){
                    $('#autoSave').click();
                    return false;
                }
            });

            //每隔一段时间保存草稿
            function autoSaveDraft(){
                interval = setInterval(function(){
                    //只有基础信息填写了，才会触发
                    var title = $('input[name=title]').val();
                    var name = $('input[name=name]').val();
                    var des = $('textarea[name=description]').val();
                    if(title != '' || name != '' || des != ''){
                        $('#autoSave').click();
                    }
                }, 1000*parseInt(<?=\common\help\CommonHelper::C('DRAFT_AOTOSAVE_INTERVAL')?>);
            }
            autoSaveDraft();

            <?php }?>
            //导航高亮
            highlight_subnav('<?=U('article/mydocument')?>');
        });
    </script>
<?php $this->endBlock();?>