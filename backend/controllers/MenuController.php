<?php
namespace backend\controllers;
use menu\logic\LgLeMenu;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/11
 * Time: 16:49
 */
class MenuController extends AdminController
{
    //菜单管理首页
    function actionIndex()
    {
        $pid=$this->getValue('pid');
        if(empty($pid))
        {
            $pid=0;
        }
        $title =   trim($this->getValue('title'));
        $Menu=new LgLeMenu();
        $result=$Menu->getListByPid($pid,$title);
        return $this->render('index',['list'=>$result['list'],'data'=>$result['data']]);
    }


    //新增菜单
    function actionAdd()
    {
        $Menu=new LgLeMenu();
        $post=\Yii::$app->request->post();
        if(!empty($post))
        {
            $Menu->write($post);
        }
        else
        {
            $menus=$Menu->getTreeMenu();
            return $this->render('edit',['Menus'=>$menus]);
        }

    }
    //编辑菜单信息
    function actionEdit()
    {
        $Menu=new LgLeMenu();
        $post=\Yii::$app->request->post();
        if(!empty($post))
        {
            $Menu->write($post);
        }
        else
        {
            $id=$this->getValue('id');
            $info=$Menu->getInfoById($id);
            $menus=$Menu->getTreeMenu();
            return $this->render('edit',['Menus'=>$menus,'info'=>$info]);
        }
    }
    //删除菜单
    function actionDel()
    {
        $id=$this->getValue('id');
        $Menu=new LgLeMenu();
        $Menu->Del($id);
    }
    //隐藏
    function actionTooglehide(){
        $id=$this->getValue('id');
        $value=$this->getValue('value');
        $Menu=new LgLeMenu();
        $Menu->editRow( array('id'=>$id), array('hide'=>$value));
    }
    //仅仅开发模式可见
    function actionToogledev(){
        $id=$this->getValue('id');
        $value=$this->getValue('value');
        $Menu=new LgLeMenu();
        $Menu->editRow( array('id'=>$id),array('is_dev'=>$value));
    }
    //菜单排序
    function actionSort()
    {
        $post=\Yii::$app->request->post();
        $ids = $this->getValue('ids');
        $pid = $this->getValue('pid');
        if(!empty($post))
        {
            $Menu=new LgLeMenu();
            $Menu->Sort($ids);
        }
        else
        {
            $Menu=new LgLeMenu();
            $list=$Menu->getSortList($ids,$pid);
            return $this->render('sort',['list'=>$list]);
        }
    }


}