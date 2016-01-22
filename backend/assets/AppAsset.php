<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use common\help\HTMLHelper;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/base.css',
        'css/common.css',
        'css/module.css',
        'css/style.css',
//        'css/bootstrap/bootstrap.min.css',
    ];
    public $js = [
          'js/jquery-2.0.3.min.js',
//          'js/yii.js',
          'js/common.js',
          'js/jquery.mousewheel.js'
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
