<?php
namespace backend\controllers;
use document\logic\LgLeDocument;
use member\logic\LgLeEmail;
use member\logic\LgLeMember;
use system\logic\LgLeAction;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/18
 * Time: 15:53
 */
class UsersController extends AdminController
{
    /**
     * @return string
     * 渲染用户管理首页
     */
    function actionIndex()
    {
        $member=new LgLeMember();
        $_members=$member->getMember($this->getValue('nickname'));
        $ModelEmail=new LgLeEmail();
        $email=$ModelEmail->getList();
        return $this->render('index',['_Member'=>$_members,'email'=>$email]);
    }
    //用户行为
    function actionAction()
    {
        //获取列表数据
        // 记录当前列表页的cookie
        $Action=new LgLeAction();
        $list=$Action->ActionList();
        return $this->render('action',['list'=>$list]);
    }

    function actionAddaction()
    {
        return $this->render('editaction');
    }

    //编辑行为  视图
    function actionEditaction()
    {
        $id=$this->getValue('id');
        $type=$this->getValue('type');
        $Action=new LgLeAction();
        $data=$Action->ActionInfo($id);
        return $this->render('editaction',['data'=>$data,'type'=>$type]);
    }
    /**
     * @return string
     * 渲染添加界面
     */
    function actionAdd()
    {
        $model=new LgLeMember();
        $model->register(\Yii::$app->request->post());
        return $this->render('add',['modele'=>$model]);
    }
    //保存用户行为
    function actionSaveaction()
    {
        $post=\Yii::$app->request->post();
        $Action=new LgLeAction();
        $Action->Write($post);
    }

    //设置用户行为状态
    function actionSetstatus()
    {
        $ids=$this->getValue('ids');
        $status=$this->getValue('status');
        $Action=new LgLeAction();
        $Action->SetStatus($ids,$status);
    }
    /**
     * 禁用用户
     */
    function actionChangestatu()
    {
        $member=new LgLeMember();
        $method=$this->getValue('method');
        $id=$this->getValue('id');
        $member->ChangeStatus($id,$method);
    }

    //即使通讯首页
    function actionChat()
    {
        return $this->renderPartial('chat');
    }

    //邮件管理
    function actionMail()
    {
        $Email=new LgLeEmail();
        $list=$Email->getList();
        return $this->render('mail',['list'=>$list]);
    }
    //发送邮件添加界面
    function actionSendemail()
    {
        $post=\Yii::$app->request->post();
        if(!empty($post))
        {
            $Email=new LgLeEmail();
            $Email->Write($post);
        }
        else
        {
            return $this->render('sendemail');
        }
    }

    //邮件发送
    function actionDosend()
    {
        $param['str_email']=$this->getValue('str_email');
        $param['email_id']=$this->getValue('email_id');
        $param['subject']=$this->getValue('subject');
        $Email=new LgLeEmail();
        $Email->doSend($param);
    }

    //编辑邮件信息
    function actionEmailedit()
    {
        $Email=new LgLeEmail();
        $id=$this->getValue('id');
        $data=$Email->getInfo($id);
        return $this->render('sendemail',['data'=>$data]);
    }
    //删除已发送邮件
    function actionDelemail()
    {
      $id=$this->getValue('ids');
      $Email=new LgLeEmail();
      $Email->DelEmail($id);
    }

}