<?php

use backend\assets\AppAsset;
use common\help\HTMLHelper;

/**先获取导航菜单**/


/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= HTMLHelper::csrfMetaTags() ?>
    <title><?= HTMLHelper::encode($this->title) ?>|YiiCommon通用管理平台</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- 头部 -->
<div class="header">
    <!-- Logo -->
    <span class="logo"></span>
    <!-- /Logo -->
    <!-- 主导航 -->
    <ul class="main-nav">
        <?php foreach(HTMLHelper::getMenus()['main'] as $val){ ?>
            <li class="<?php if(!empty($val['class'])) $val['class'] ?>"><a href="<?=Yii::$app->homeUrl.strtolower($val['url'])?>"><?=$val['title']?></a></li>
        <?php } ?>
    </ul>
    <!-- /主导航 -->

    <!-- 用户栏 -->
    <div class="user-bar">
        <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
        <ul class="nav-list user-menu hidden">
            <li class="manager">你好<?=username()?></li>
            <li><a href="{:U('User/updatePassword')}">修改密码</a></li>
            <li><a href="{:U('User/updateNickname')}">修改昵称</a></li>
            <li><a href="<?= U('public/logout') ?>">退出</a></li>
        </ul>
    </div>
</div>
<!-- /头部 -->
<!-- 边栏 -->
<div class="sidebar">
    <!-- 子导航 -->

    <div id="subnav" class="subnav">
        <?php
        if(count(HTMLHelper::getMenus()['child'])>1)
        {
            foreach(HTMLHelper::getMenus()['child'] as $key=>$Pval){
                if(!empty($Pval))
                {
                    ?>
                    <!-- 子导航 -->
                    <h3><i class="icon icon-unfold"></i><?= $key?></h3>
                    <ul class="side-sub-menu">
                        <?php foreach($Pval as $Cval){ ?>
                            <li>
                                <a class="item" href="<?=U(strtolower($Cval['url']))?>"><?=$Cval['title']?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <!-- /子导航 -->
                <?php }}}elseif(HTMLHelper::getController()==='article'){ ?>
            <?php if (isset($this->blocks['leftNav'])): ?>
                <?=$this->blocks['leftNav']?>
            <?php  endif; ?>
        <?php }?>
    </div>

</div>

<!-- /子导航 -->
</div>
<!-- /边栏 -->

<!-- 内容区 -->
<div id="main-content">
    <div id="top-alert" class="fixed alert alert-error" style="display: none;">
        <button class="close fixed" style="margin-top: 4px;">&times;</button>
        <div class="alert-content">这是内容</div>
    </div>
    <div id="main" class="main">
        <?php if (isset($this->blocks['content'])): ?>
            <?=$this->blocks['content']?>
        <?php  endif; ?>
    </div>
    <div class="cont-ft">
        <div class="copyright">
            <div class="fl">感谢使用 Yii2.0通用  管理平台</div>
        </div>
    </div>
</div>
<!-- /内容区 -->

<?php $this->endBody() ?>
<script type="text/javascript">
    +function(){
        var $window = $(window), $subnav = $("#subnav"), url;
        $window.resize(function(){
            $("#main").css("min-height", $window.height() - 130);
        }).resize();
        /* 左边菜单高亮 */
        url = window.location.pathname + window.location.search;
        url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
        $subnav.find("a[href='" + url + "']").parent().addClass("current");

        /* 左边菜单显示收起 */
        $("#subnav").on("click", "h3", function(){
            var $this = $(this);
            $this.find(".icon").toggleClass("icon-fold");
            $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                prev("h3").find("i").addClass("icon-fold").end().end().hide();
        });

        $("#subnav h3 a").click(function(e){e.stopPropagation()});

        /* 头部管理员菜单 */
        $(".user-bar").mouseenter(function(){
            var userMenu = $(this).children(".user-menu ");
            userMenu.removeClass("hidden");
            clearTimeout(userMenu.data("timeout"));
        }).mouseleave(function(){
            var userMenu = $(this).children(".user-menu");
            userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
            userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
        });

        /* 表单获取焦点变色 */
        $("form").on("focus", "input", function(){
            $(this).addClass('focus');
        }).on("blur","input",function(){
            $(this).removeClass('focus');
        });
        $("form").on("focus", "textarea", function(){
            $(this).closest('label').addClass('focus');
        }).on("blur","textarea",function(){
            $(this).closest('label').removeClass('focus');
        });

        // 导航栏超出窗口高度后的模拟滚动条
        var sHeight = $(".sidebar").height();
        var subHeight  = $(".subnav").height();
        var diff = subHeight - sHeight; //250
        var sub = $(".subnav");
        if(diff > 0){
            $(window).mousewheel(function(event, delta){
                if(delta>0){
                    if(parseInt(sub.css('marginTop'))>-10){
                        sub.css('marginTop','0px');
                    }else{
                        sub.css('marginTop','+='+10);
                    }
                }else{
                    if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                        sub.css('marginTop','-'+(diff-10));
                    }else{
                        sub.css('marginTop','-='+10);
                    }
                }
            });
        }
    }();
</script>
<?php if (isset($this->blocks['script'])): ?>
    <?=$this->blocks['script']?>
<?php  endif; ?>
</body>
</html>
<?php $this->endPage() ?>
