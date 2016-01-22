<?php
namespace backend\controllers;
use document\logic\LgLeDocument;
use document\models\LeDocument;
use menu\logic\LgLeMenu;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/18
 * Time: 15:33
 */
class ArticleController extends AdminController
{
    /**
     * @return mixed
     * 获取左侧菜单栏
     */
    function getMenu()
    {
        $Menu=new LgLeMenu();
        $cate_id=$this->getValue('cate_id');
        return $Menu->getMenu($cate_id);
    }

    /**
     * @return string
     * 渲染文章视图首页
     */
    function actionMydocument()
    {
        /**
         * 用户点击类容时获取
         */
        /* 查询条件初始化 */
        $title=$this->getValue('title');
        $status=$this->getValue('status');
        $time_start=$this->getValue('time-start');
        $time_end=$this->getValue('time-end');
        $param=array('title'=>$title,'status'=>$status,'time-start'=>$time_start,'time-end'=>$time_end);
        $Document=new LgLeDocument();
        $list=$Document->MyDocument($param);
        return $this->render('mydocument',['MENU'=>$this->getMenu(),'list'=>$list,'status'=>$status]);
    }

    /**
     * 文档首页
     */
    function actionIndex()
    {
        /**
         * 用户点击类容时获取
         */
        /* 查询条件初始化 */
        $category_id=$this->getValue('cate_id');
        $title=$this->getValue('title');
        $status=$this->getValue('status');
        $time_start=$this->getValue('time-start');
        $time_end=$this->getValue('time-end');
        $param=array('title'=>$title,'cate_id'=>$category_id,'status'=>$status,'time-start'=>$time_start,'time-end'=>$time_end);
        $Document=new LgLeDocument();
        $list=$Document->MyDocument($param);
        return $this->render('index',['MENU'=>$this->getMenu(),'list'=>$list,'status'=>$status,'cate_id'=>$category_id]);
    }

    //渲染审核界面视图
    function actionExamine()
    {
        $map=array('status'=>2);
        $Document=new LgLeDocument();
        $list=$Document->MyDocument($map);
        return $this->render('examine',['MENU'=>$this->getMenu(),'list'=>$list]);
    }
    //草稿箱视图
    function actionDraftbox()
    {
        $map        =   array('status'=>3,'uid'=>UID);
        $Document=new LgLeDocument();
        $list=$Document->MyDocument($map);
        return $this->render('draftbox',['MENU'=>$this->getMenu(),'list'=>$list]);
    }
    //审核
    function actionDoexamine()
    {
        $ids=$this->getValue('ids');
        $status=$this->getValue('status');
        $Document=new LgLeDocument();
        $Document->setStatus($ids,$status);
    }
    /**
     * @return string
     * 排序
     */
    function actionSort()
    {
        $post=\Yii::$app->request->post();
        $Document=new LgLeDocument();
        if(!empty($post))
        {
            $Document->Sort($post['ids']);
        }
        else
        {
            $cate_id    = $this->getValue('cate_id');
            $ids        =  $this->getValue('ids');
            $param=array('cate_id'=>$cate_id,'ids'=>$ids);
            $list=$Document->MyDocument($param);
            return $this->render('sort',['MENU'=>$this->getMenu(),'list'=>$list['list']]);
        }
    }
    /**
     * 设置文档状态
     */
    function actionSetstatus()
    {
        $ids=$this->getValue('ids');
        $status=$this->getValue('status');
        $Document=new LgLeDocument();
        $Document->setStatus($ids,$status);
    }

    /**
     * 更新一条数据
     * @author huajie <banhuajie@163.com>
     */
    function actionUpdate()
    {
        $post=\Yii::$app->request->post();
        $Document=new LgLeDocument();
        $Document->Write($post);
    }
    /**
     * 文档编辑页面初始化
     * @author huajie <banhuajie@163.com>
     */
    function actionEdit(){
        //获取左边菜单
        $id     = $this->getValue('id');
        if(empty($id))
        {
            $id='';
        }
        /*获取一条记录的详细数据*/
        $Document = new LgLeDocument();
        $data = $Document->Detial($id);
        /* 获取要编辑的扩展模型模板 */
        $model      =   get_document_model($data['model_id']);
        //获取表单字段排序
        $fields = get_model_attribute($model['id']);
        //获取当前分类的文档类型
        return $this->render('edit',['MENU'=> $this->getMenu(),'data'=>$data,'id'=>$id,'model'=>$model,'fields'=>$fields,'type_list'=> get_type_bycate($data['category_id'])]);
    }

    //渲染添加页面
    function actionAdd()
    {
        $model_id=$this->getValue('model_id');
        $pid=$_GET['pid']?$_GET['pid']:0;
        $cate_id=$this->getValue('cate_id');
        $cate_name=get_cate($cate_id);
        $model =   get_document_model($model_id);
        //获取表单字段排序
        $fields = get_model_attribute($model['id']);
        $data=array('pid'=>$pid,'model_id'=>$model_id,'category_id'=>$cate_id);
        return $this->render('edit',['MENU'=>$this->getMenu(),'dataAdd'=>$data,'model'=>$model,'fields'=>$fields,'cate_id'=>$cate_id,'cate_name'=>$cate_name]);
    }

    //回收站
    function actionRecycle()
    {
       $document=new LgLeDocument();
        $list=$document->getRecycle();
       return $this->render('recycle',['MENU'=>$this->getMenu(),'list'=>$list]);
    }

    //清空回收站
    function actionClear()
    {
        $document=new LgLeDocument();
        $document->Clear();
    }

    //文档还原
    function actionPermit()
    {
        $ids=$this->getValue('ids');
        $Document=new LgLeDocument();
        $Document->Permit($ids);
    }
}