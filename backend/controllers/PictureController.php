<?php
namespace backend\controllers;
use system\logic\LgLePicture;
use system\logic\LgLePictureType;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/11
 * Time: 14:23
 */
class PictureController extends AdminController
{
    function actionIndex()
    {
        $id=$this->getValue('type');
        $Type=new LgLePictureType();
        $Picture=new LgLePicture();
        $list=$Type->getList();
        $PicList=$Picture->getList($id);
        return $this->render('index',['list'=>$list,'piclist'=>$PicList]);
    }
    //添加
    function actionAdd()
    {
        $post=\Yii::$app->request->post();
        if(!empty($post))
        {
            $Type=new LgLePictureType();
            $Type->Write($post);
        }
        else
        {
            return $this->render('edit');
        }
    }
    //编辑
    function actionEdit()
    {
        $post=\Yii::$app->request->post();
        $Type=new LgLePictureType();
        if(!empty($post))
        {
            $Type->Write($post);
        }
        else
        {
            $id=$this->getValue('id');
            $info=$Type->getInfo($id);
            return $this->render('edit',['info'=>$info]);
        }
    }
    //删除
    function actionDel()
    {
        $id=$this->getValue('id');
        $Type=new LgLePictureType();
        $Type->Del($id);
    }
    //图片分类排序
    function actionSort()
    {
        $Type=new LgLePictureType();
        $ids=$this->getValue('ids');
        if(!empty($ids))
        {
            $Type->Sort($ids);
        }
        else
        {
            $list=$Type->getList();
            return $this->render('sort',['list'=>$list]);
        }
    }
    //图片信息编辑
    function actionPicedit()
    {
        $pic=new LgLePicture();
        $post=\Yii::$app->request->post();
        if(!empty($post))
        {
            $pic->Write($post);
        }
        else
        {
            $id=$this->getValue('id');
            $info=$pic->PicInfo($id);
            return $this->render('picedit',['info'=>$info]);
        }


    }
}