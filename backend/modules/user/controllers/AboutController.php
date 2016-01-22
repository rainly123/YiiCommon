<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/21
 * Time: 17:43
 */
namespace backend\modules\user\controllers;

use yii\base\Controller;

class AboutController extends Controller
{
    public function actionIndex()
    {
       // $this->render("index");
        $this->renderPartial('index');
    }
    public function actionReg()
    {
        $this->render("reg");
    }
}