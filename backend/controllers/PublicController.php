<?php
namespace backend\controllers;

use common\help\CommonHelper;
use Yii;
use common\models\LoginForm;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/17
 * Time: 11:39
 */
class PublicController extends Controller
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * @inheritdoc
     */

    public function actionLogin()
    {
        $model = new LoginForm();
        if($model->login(Yii::$app->request->post()))
        {
           return Yii::$app->getResponse()->redirect(U('index/index'));
        }
        return $this->renderPartial('login', [
            'model' => $model
        ]);

    }

    public function actionLogout()
    {
        CommonHelper::rmSession('user_auth');
        return Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl().'public/login');
    }

    //渲染错误页面
    public function actionError()
    {

    }

}

