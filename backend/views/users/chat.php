<?php
use common\help\HTMLHelper;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/2
 * Time: 12:07
 */
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= HTMLHelper::csrfMetaTags() ?>
    <title><?= HTMLHelper::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<div id="contain">
    <div id="content">
        <div id="chatbox" style="display: block;">
            <div style="background:#3d3d3d;height: 28px; width: 100%;font-size:12px;">
                <div style="line-height: 28px;color:#fff;">
                    <span style="text-align:left;margin-left:10px;">Websocket多人聊天室</span>
                    <span style="float:right; margin-right:10px;"><span id="showusername">xxx</span> |
          <a href="" id="logout" style="color:#fff;">退出</a></span>
                </div>
            </div>
            <div id="doc">
                <div id="chat">
                    <div id="message" class="message" style="min-height: 330px;max-height: 500px;overflow-y: scroll  ">
                        <div id="onlinecount" style="background:#EFEFF4; font-size:12px; margin-top:10px; margin-left:10px; color:#666;">当前共有 <span id="count"></span> 人在线，在线列表：</div>
                    </div>
                </div>
            </div>
        </div>
        <div id="content_saying">
            <div id="toolbar"></div>
            <div id="input_content" contenteditable="true"></div>
            <div id="sayingto">你好 <span id="from"></span> ，你正在对 <span id="to"></span> 说</div>
            <div id="say">发送</div>
        </div>
    </div>
    <div id="users_online">
        <div id="usersbar">
            <div id="user_label">在线用户</div>
            <div id="users_list">
                <ul id="list"></ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=Yii::$app->homeUrl.'js/jquery.min.js'?>"></script>
<script type="text/javascript" src="<?=Yii::$app->homeUrl.'js/jquery.cookie.js'?>"></script>
<link type="text/css" rel="stylesheet" href="<?=Yii::$app->homeUrl.'css/chat.css'?>">
<link type="text/css" rel="stylesheet" href="<?=Yii::$app->homeUrl.'css/style.css'?>">
<script type="text/javascript">
    $(function(){
        var nickname='<?=username();?>';
        $.ajax({
            Type:'post',
            url:"http://localhost:3000/signin?callback=?",
            error:function(){
                alert("服务器连接失败！");
                history.back()
            }
        });
        $.getJSON(
            "http://localhost:3000/signin?callback=?",  //跨域调用
            {name:nickname},
            function(data) {
                if(data.status!='success')
                {
                    alert("socket建立失败");
                    location.href='<?=U('users/index')?>';
                }
            });
    });
</script>
<script src="http://localhost:3000/socket.io/socket.io.js"></script>
<script type="text/javascript" src="<?=Yii::$app->homeUrl.'js'?>/chat.js"></script>
</body>
</html>