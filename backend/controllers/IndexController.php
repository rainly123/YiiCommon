<?php
namespace backend\controllers;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/17
 * Time: 18:03
 */
class IndexController extends AdminController
{
    function actionIndex()
    {
        return $this->renderPartial('index');
    }
}