<?php
namespace backend\controllers;
use member\logic\LgLeAuthGroup;
use member\logic\LgLeAuthRule;

/**
 * Created by PhpStorm.
 * User: congsheng
 * for :权限管理控制器
 * Date: 2015/11/25
 * Time: 17:22
 */
class AuthmanagerController extends AdminController
{
    /**
     * 渲染权限管理首页
     */
    function actionIndex()
    {
        $AuthGroup=new LgLeAuthGroup();
        return $this->render('index',['AuthGroup'=>$AuthGroup->getAuthGroup()]);
    }


    function actionChangestatus()
    {
        $AuthGroup=new LgLeAuthGroup();
        $id=$this->getValue('id');
        $method=$this->getValue('method');
        $AuthGroup->ChangeStatus($method,$id);
    }

    /**
     * @return string
     * 渲染新增页面
     */
    function actionCreategroup()
    {
        return $this->render('add');
    }

    /**
     * @return string
     * 渲染编辑界面
     */
    function actionEditgroup()
    {
        $AuthGroup=new LgLeAuthGroup();
        $id=$this->getValue('id');
        $auth_group=$AuthGroup->getAuthGroup_info($id);
        return $this->render('add',['auth_group'=>$auth_group]);
    }

    /**
     * @return string
     * 成员授权页面
     */
    function actionUser()
    {
        $group_id=$this->getValue('group_id');
        $AuthRule=new LgLeAuthRule();
        $data=array('auth_group'=>$AuthRule->getGroupList(),
            'this_group'=>$AuthRule->getGroupList()[(int)$group_id],
            '_list'=>$AuthRule->getUserGroup($group_id));
        return $this->render('user',['data'=>$data]);
    }


    /**
     * 管理员用户组写入/更新
     */
    function actionWritegroup()
    {
        $AuthGroup=new LgLeAuthRule();
        $data=$this->getParam();
        $AuthGroup->WriteGroup($data);
    }

    /**
     * 用户授权页面
     */
    function actionAccess()
    {
        $group_id=$this->getValue('group_id');
        $AuthRules=new LgLeAuthRule();
        $result= $AuthRules->getRules($group_id);
        return $this->render('access',['data'=>$result]);
    }
}