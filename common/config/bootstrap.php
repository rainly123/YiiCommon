<?php
/***********************注册模块*********************************/
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
             /**菜单管理模块**/
Yii::setAlias('menu', dirname(dirname(__DIR__)) . '/menu');
             /**公共资源文件**/
Yii::setAlias('public', dirname(dirname(__DIR__)) . '/public');
            /**用户管理模块**/
Yii::setAlias('member', dirname(dirname(__DIR__)) . '/member');
             /**系统管理模块**/
Yii::setAlias('system', dirname(dirname(__DIR__)) . '/system');
             /**文章管理模块**/
Yii::setAlias('document', dirname(dirname(__DIR__)) . '/document');
             /**文件上传模块**/
Yii::setAlias('upload', dirname(dirname(__DIR__)) . '/upload');
            /********引入上传文件资源******/
Yii::setAlias('uploads', dirname(dirname(__DIR__)) . '/uploads');

/***********************公共文件管理对象*********************************/
require(__DIR__.'/../help/function.php');
/***********************依赖注入管理对象*********************************/
require(__DIR__.'/../../menu/di.php');
require(__DIR__.'/../../member/di.php');
require(__DIR__.'/../../system/di.php');
require(__DIR__.'/../../document/di.php');