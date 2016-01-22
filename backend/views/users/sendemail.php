<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/23
 * Time: 16:38
 */
?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2>添加邮件内容</h2>
    </div>
    <form action="<?=U('users/sendemail')?>" method="post" class="form-horizontal">
        <input type="hidden" name="_csrf" value="<?php echo Yii::$app->getRequest()->getCsrfToken(); ?>" />
        <div class="form-item">
            <label class="item-label">主题<span class="check-tips"></span></label>
            <div class="controls">
                <input type="text" class="text input-large" name="subject" value="<?=isset($data['subject'])?$data['subject']:''?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">内容<span class="check-tips"></span></label>
            <div class="controls">
                <textarea name="email"><?=isset($data['body'])?$data['body']:''?></textarea>
            </div>
            <link rel="stylesheet" href="/public/kindeditor/themes/default/default.css" />
            <link rel="stylesheet" href="/public/kindeditor/plugins/code/prettify.css" />
            <script charset="utf-8" src="/public/kindeditor/kindeditor.js"></script>
            <script charset="utf-8" src="/public/kindeditor/lang/zh_CN.js"></script>
            <script>
                KindEditor.ready(function(K) {
                    var editor1 = K.create('textarea[name="email"]', {
                        width: '100%',
                        height: '500px',
                        resizeType: 1,
                        pasteType: 2,
                        urlType: 'absolute',
                        cssPath: '/public/kindeditor/plugins/code/prettify.css',
                        uploadJson: '/public/kindeditor/php/upload_json.php',
                        fileManagerJson: '/public/kindeditor/php/file_manager_json.php',
                        allowFileManager: true
                    });
                });
            </script>
        </div>
        <div class="form-item">
            <textarea hidden="hidden" name="body"></textarea>
            <input type="hidden" name="id" value="<?=isset($data['id'])?$data['id']:0?>">
            <button class="btn submit-btn ajax-post" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
        </div>
    </form>
<?php $this->endBlock();?>
<?php $this->beginBlock('script'); ?>
    <script src="<?=Yii::$app->homeUrl?>js/thinkbox/jquery.thinkbox.js"></script>
    <script type="text/javascript">

            $('#submit').click(function(){
                var html= $(".ke-edit-iframe").contents().find("body").html();
                $("textarea[name='body']").val(html);
                $('#form').submit();
            });

    </script>
<?php $this->endBlock();?>