<?php
namespace backend\controllers;
use document\logic\LgLeCategory;
//use upload\Driver\Local\Local;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/15
 * Time: 13:20
 */
class CategoryController extends AdminController
{
    function actionIndex()
    {
        $Category=new LgLeCategory();
        $tree=$Category->getTree();
        return $this->render('index',['tree'=>$tree]);
    }

    //编辑分类
    function actionEdit()
    {
        $post=\Yii::$app->request->post();
        $id=$this->getValue('id');
        $pid=$this->getValue('pid');
        $Category=new LgLeCategory();
        if(!empty($post))
        {
           $Category->write($post);
        }
        else
        {
            $info=$Category->info($id);
            $cate=$Category->info($pid);
            return $this->render('edit',['info'=>$info,'category'=>$cate]);
        }
    }

    //添加分类
    function actionAdd()
    {
        $post=\Yii::$app->request->post();
        $pid=$this->getValue('pid');
        $Category=new LgLeCategory();
        if(!empty($post))
        {
            $Category->write($post);
        }
        else
        {
            $cate=$Category->info($pid);
            return $this->render('edit',['category'=>$cate,'category'=>$cate]);
        }
    }

    /**
     * @param string $type
     * 操作分类初始化
     */
    public function actionOperate(){
        $type=$this->getValue('type');
        //检查操作参数
        if(strcmp($type, 'move') == 0){
            $operate = '移动';
        }elseif(strcmp($type, 'merge') == 0){
            $operate = '合并';
        }
        $from = intval($this->getValue('from'));
        //获取分类
        $Category=new LgLeCategory();
        $list =$Category->getList($from);
        return $this->render('operate',['operate'=>$operate,'type'=>$type,'from'=>$from,'list'=>$list]);
    }
    /**
     * 修改状态
     */
    function actionSetstatus()
    {
        $Category=new LgLeCategory();
        $id=$this->getValue('ids');
        $status=$this->getValue('status');
        $Category->changeStatus($id,$status);
    }
    /**
     * 移动分类
     * @author huajie <banhuajie@163.com>
     */
    function actionMove(){
        $to =$this->getValue('to');
        $from =$this->getValue('from');
        $Category=new LgLeCategory();
        $Category->move($from,$to);
    }

    /**
     * 删除分类
     */
    function actionRemove()
    {
        $Category=new LgLeCategory();
        $cate_id = $this->getValue('id');
        //判断该分类下有没有子分类，有则不允许删除
        $Category->Remove($cate_id);
    }


}