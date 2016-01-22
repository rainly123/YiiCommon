<?php
namespace backend\controllers;
use common\help\CommonHelper;
use menu\logic\LgLeMenu;
use system\logic\LgLeConfig;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/18
 * Time: 16:05
 */
class ConfigController extends AdminController
{
    //配置管理
    function actionIndex()
    {
        $lgConfig=new LgLeConfig();
        $group=$this->getValue('group');
        $name=$this->getValue('name');
        $list=$lgConfig->getListPage($group,$name);
        return $this->render('index',['list'=>$list,'group'=>CommonHelper::C('CONFIG_GROUP_LIST'),'group_id'=>$group]);
    }
    // 获取某个标签的配置参数
    function actionGroup()
    {
        $id=$this->getValue('id');
        if(empty($id))
        {
            $id=1;
        }
        $config=new LgLeConfig();
        $list=$config->getList($id);
        $type=CommonHelper::C('CONFIG_GROUP_LIST');
        return $this->render('group',['type'=>$type,'id'=>$id,'list'=>$list]);
    }

    //配置信息排序
    function actionSort()
    {
        $post=\Yii::$app->request->post();
        $Config=new LgLeConfig();
        if(!empty($post))
        {
           $Config->Sort($post['ids']);
        }
        else
        {
            $ids=$this->getValue('ids');
            $group=$this->getValue('group');
            $list=$Config->getListPage($group,'',$ids);
            return $this->render('sort',['list'=>$list['list']]);
        }
    }

    /**
     * 编辑配置
     */
    function actionEdit()
    {
        $post=\Yii::$app->request->post();
        if(!empty($post))
        {
            $leconfig=new LgLeConfig();
            $leconfig->write($post);
        }
        else
        {
            $id=$this->getValue('id');
            $config=new LgLeConfig();
            $info=$config->getInfo($id);
            return $this->render('edit',['info'=>$info]);
        }

    }

    /**
     * 新增配置
     */
    function actionAdd()
    {
        $post=\Yii::$app->request->post();
        if(!empty($post))
        {
           $leconfig=new LgLeConfig();
           $leconfig->write($post);
        }
        else
        {
            return $this->render('edit');
        }

    }

    //删除配置信息
    function actionDel()
    {
        $id=$this->getValue('id');
        $config=new LgLeConfig();
        $config->Del($id);
    }

    //批量保存配置
    function actionSave()
    {
        $config=\Yii::$app->request->post();
        $lgconfig=new LgLeConfig();
        $lgconfig->Save($config);
    }



}