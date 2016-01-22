<?php
use backend\assets\AppAsset;
use common\help\HTMLHelper;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/17
 * Time: 18:05
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>管理首页|YiiCommon管理平台</title>
    <link rel="stylesheet" type="text/css" href="<?=Yii::$app->homeUrl.'css/base.css'?>" media="all">
    <link rel="stylesheet" type="text/css" href="<?=Yii::$app->homeUrl.'css/common.css'?>" media="all">
    <link rel="stylesheet" type="text/css" href="<?=Yii::$app->homeUrl.'css/module.css'?>">
    <link rel="stylesheet" type="text/css" href="<?=Yii::$app->homeUrl.'css/style.css'?>" media="all">
    <link rel="stylesheet" type="text/css" href="<?=Yii::$app->homeUrl.'css/default_color.css'?>" media="all">
    <script type="text/javascript" src="<?=Yii::$app->homeUrl.'js/jquery-2.0.3.min.js' ?>"></script>
    <script type="text/javascript" src="<?=Yii::$app->homeUrl.'js/jquery.mousewheel.js'?>"></script>
    <!--<![endif]-->
    <style>
        body{padding: 0}
    </style>
</head>
<body>
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
<!-- 内容区 -->
<div id="main-content">
    <div id="top-alert" class="fixed alert alert-error" style="display: none;">
        <button class="close fixed" style="margin-top: 4px;">×</button>
        <div class="alert-content">这是内容</div>
    </div>
    <div style="min-height: 263px;" id="main" class="main">
        <!-- nav -->
        <!-- nav -->
        <!-- 主体 -->
        <div id="indexMain" class="index-main">
            <!-- 插件块 -->
            <div class="container-span"> <div class="container-span top-columns cf">
                    <dl class="show-num-mod">
                        <dt><i class="count-icon user-count-icon"></i></dt>
                        <dd>
                            <strong>4</strong>
                            <span>用户数</span>
                        </dd>
                    </dl>
                    <dl class="show-num-mod">
                        <dt><i class="count-icon user-action-icon"></i></dt>
                        <dd>
                            <strong>5</strong>
                            <span>用户行为</span>
                        </dd>
                    </dl>
                    <dl class="show-num-mod">
                        <dt><i class="count-icon doc-count-icon"></i></dt>
                        <dd>
                            <strong>41</strong>
                            <span>文档数</span>
                        </dd>
                    </dl>
                    <dl class="show-num-mod">
                        <dt><i class="count-icon doc-modal-icon"></i></dt>
                        <dd>
                            <strong>3</strong>
                            <span>文档模型</span>
                        </dd>
                    </dl>
                    <dl class="show-num-mod">
                        <dt><i class="count-icon category-count-icon"></i></dt>
                        <dd>
                            <strong>5</strong>
                            <span>分类数</span>
                        </dd>
                    </dl>
                </div><div class="span2">
                    <div class="columns-mod">
                        <div class="hd cf">
                            <h5>系统信息</h5>
                            <div class="title-opt">
                            </div>
                        </div>
                        <div class="bd">
                            <div class="sys-info">
                                <table>
                                    <tbody><tr>
                                        <th>YiiCommon版本</th>
                                        <td>1.0 &nbsp;&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>服务器操作系统</th>
                                        <td>WINNT</td>
                                    </tr>
                                    <tr>
                                        <th>Yii版本</th>
                                        <td>2.0</td>
                                    </tr>
                                    <tr>
                                        <th>运行环境</th>
                                        <td><?=apache_get_version()?></td>
                                    </tr>
                                    <tr>
                                        <th>MYSQL版本</th>
                                        <td><?=getMysqlVersion()?></td>
                                    </tr>
                                    <tr>
                                        <th>上传限制</th>
                                        <td> </td>
                                    </tr>
                                    </tbody></table>
                            </div>
                        </div>
                    </div>
                </div><div class="span2">
                    <div class="columns-mod">
                        <div class="hd cf">
                            <h5>产品团队</h5>
                            <div class="title-opt">
                            </div>
                        </div>
                        <div class="bd">
                            <div class="sys-info">
                                <table>
                                    <tbody><tr>
                                        <th>总策划</th>
                                        <td>juzi</td>
                                    </tr>
                                    <tr>
                                        <th>产品设计及研发团队</th>
                                        <td>juzi</td>
                                    </tr>
                                    <tr>
                                        <th>界面及用户体验团队</th>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <th>官方网址</th>
                                        <td><a href="http://www.5151jh.com" target="_blank">www.5151jh.com</a></td>
                                    </tr>
                                    <tr>
                                        <th>官方QQ群</th>
                                        <td>
<!--                                            <a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=14ba57a5273cc820d298cc394227276b22177217e413dfe658aa3d3b34c119e0"><img src="http://pub.idqqimg.com/wpa/images/group.png" alt="OneThink技术交流" title="OneThink技术交流" border="0">-->
<!--                                            </a>-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>BUG反馈</th>
                                        <td>
<!--                                            <a href="http://www.5151jh.com" target="_blank">YiiCommon讨论区</a>-->
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div></div>
        </div>

    </div>
    <div class="cont-ft">
        <div class="copyright">
            <div class="copyright">
                ©2016
                <a href="http://www.5151jh.com" target="_blank">5151jh.com</a>
                juzi所有
            </div>
        </div>
    </div>
</div>
<!-- /内容区 -->
<script type="text/javascript" src="<?=Yii::$app->homeUrl.'js/yii.js'?>"></script>
<script type="text/javascript" src="<?=Yii::$app->homeUrl.'js/common.js'?>"></script>
<script type="text/javascript">
    +function(){
        highlight_subnav('<?=U('index/index')?>');
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


</body>
</html>
