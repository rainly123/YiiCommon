<?php
namespace common\help;
use menu\logic\LgLeMenu;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: congsheng
 * for:视图扩展类/基础类
 * Date: 2015/11/18
 * Time: 9:27
 */
class HTMLHelper extends Html
{
    //获取Post或Get请求中的参数
    function getValue($name){
        $request = \Yii::$app -> request;
        $value = $request -> post($name);
        return empty($value) ? $request -> get($name) : $value;
    }

    /**
     * @return 获取顶级项目目录
     */
    static function getTopPath()
    {
        return  $_SERVER['DOCUMENT_ROOT'] ;
    }

    /**
     * @return string
     * 获取当前路径
     */
    static function getCurrentPath()
    {
        $controllerID = \Yii::$app->controller->id;
        $actionID = \Yii::$app->controller->action->id;
        return $controllerID.'/'.$actionID;
    }

    /**
     * @return string
     * 获取当前控制器
     */
    static function getController()
    {
        return  strtolower(\Yii::$app->controller->id);
    }

    /**
     * @return string
     * 获取当前用户请求action
     */
    static function getAction()
    {
        return strtolower(\Yii::$app->controller->action->id);
    }

    /**
     * @return mixed
     * 获取导航菜单
     */
    static function getMenus()
    {
        $Menu=new LgLeMenu();
        return $Menu->getMenus(self::getCurrentPath());
    }

    /**
     * @param $time
     * @return bool|string
     * 时间戳转日期格式
     */
    static function ToDate($time)
    {
        return date('Y-m-d H:i:s',$time);
    }

    /**
     * 获取get参数
     */
    static function _GET($name)
    {
        if($name=='id'||$name='pid')
        {
            return \Yii::$app->request->get($name)?\Yii::$app->request->get($name):0;
        }
        else
        {
            return \Yii::$app->request->get($name);
        }


    }



}
