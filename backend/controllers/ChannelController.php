<?php
namespace backend\controllers;
use menu\logic\LgLeChannel;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/15
 * Time: 9:18
 */
class ChannelController extends AdminController
{
    //导航管理首页
    function actionIndex()
    {
        $pid=\Yii::$app->request->get('pid')?\Yii::$app->request->get('pid'):0;
        $channel=new LgLeChannel();
        $list=$channel->getList($pid);
        return $this->render('index',['list'=>$list,'pid'=>$pid]);
    }
//天假导航菜单
    function actionAdd()
    {
        $Channel=new LgLeChannel();
        $post=\Yii::$app->request->post();
        $pid=$this->getValue('pid')?$this->getValue('pid'):0;
        if(!empty($post))
        {
            $Channel->write($post);
        }
        else
        {
            $parent=$Channel->getParent($pid);
            return $this->render('add',['parent'=>$parent,'pid'=>$pid]);
        }
    }
//编辑导航菜单
    function actionEdit()
    {
        $Channel=new LgLeChannel();
        $post=\Yii::$app->request->post();
        $pid=$this->getValue('pid');
        $id=$this->getValue('id');
        if(!empty($post))
        {
            $Channel->write($post);
        }
        else
        {
            $parent=$Channel->getParent($pid);
            $info=$Channel->getParent($id);
            return $this->render('add',['parent'=>$parent,'info'=>$info,'pid'=>$pid]);
        }
    }

    /**
     * 删除导航菜单
     */
    function actionDel()
    {
        $id=$this->getValue('id');
//        print_r($id);
//        die();
        $Channel=new LgLeChannel();
        $Channel->Del($id);
    }

    /**
     * 更改状态
     */
    function actionSetstatus()
    {
        $id=$this->getValue('id');
        $update=array(
            'status'=>$this->getValue('status')
        );
        $Channel=new LgLeChannel();
        $Channel->editRow($id,$update);
    }
}