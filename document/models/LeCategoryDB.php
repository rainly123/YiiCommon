<?php
namespace document\models;
use common\help\CommonHelper;
use common\help\DBHelper;
use menu\models\LeCategory;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/15
 * Time: 13:45
 */
class LeCategoryDB extends DBHelper
{
    function getTree($id = 0)
    {
        /* 获取当前分类信息 */
        if($id){
            $info = $this->info($id);
            $id   = $info['id'];
        }

        /* 获取所有分类 */
        $map  = array('marks' =>0);
        $list = LeCategory::find()->where($map)->orderBy('sort')->asArray()->all();
        $list = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_', $root = $id);

        /* 获取返回数据 */
        if(isset($info)){ //指定分类则返回当前分类极其子分类
            $info['_'] = $list;
        } else { //否则返回所有分类
            $info = $list;
        }
        return $info;
    }

    /**
     * @param $from
     * @param $to
     * 类别移动
     */
    function move($from,$to)
    {
       $Model=new LeCategory();
       $update=array('pid'=>$to);
       $this->ChangeById($from,$update,$Model);
    }
    /**
     * @param $from
     * @return array|\yii\db\ActiveRecord[]
     * 获取操作列表
     */
    function getList($from)
    {
        $map='status=1 AND id<>'.$from;
        $list=LeCategory::find()->where($map)->asArray()->all();
        return $list;
    }

    //获取分类信息
    function info($id){
        /* 获取分类信息 */
        $map = array();
        if(is_numeric($id)){ //通过ID查询
            $map['id'] = $id;
        } else { //通过标识查询
            $map['name'] = $id;
        }
        return LeCategory::find()->where($map)->asArray()->one();
    }


    /**
     * @param $param
     * 数据写入
     */
    function write($param)
    {
        if(!empty($param['type']))
        {
            $type=implode(',',array_unique($param['type']));
            $param['type']=$type;
        }
        if(!empty($param['id']))
        {
            $Category=LeCategory::findOne($param['id']);
            $param['update_time']=CommonHelper::CurrentTime();
        }
        else
        {
            $Category=new LeCategory();
            $param['status']=1;
            $param['create_time']=CommonHelper::CurrentTime();
            $param['update_time']=CommonHelper::CurrentTime();
        }
        $Category->attributes=$param;
        if($Category->validate()&& $Category->save())
        {
            $this->success('保存成功！','index');
        }
        else
        {
            $this->error($Category->errors);
        }
    }

    /**
     * @param $ids
     * 禁用
     */
    function changeStatus($ids,$status)
    {
        if(empty($ids)||empty($status))
        {
            $this->error('参数错误');
        }
        $Model=new LeCategory();
        $update=array('status'=>$status);
        $this->ChangeById($ids,$update,$Model);
    }


    /**
     * @param $id
     * 删除分类
     */
    function Remove($id)
    {
       $Model=new LeCategory();
        if(empty($id)){
            $this->error('参数错误!');
        }
        //判断该分类下有没有子分类，有则不允许删除
        $child = LeCategory::find()->where(array('pid'=>$id))->count();   // M('Category')->where(array('pid'=>$cate_id))->field('id')->select();
        if($child>0){
            $this->error('请先删除该分类下的子分类');
        }

        //判断该分类下有没有内容
        $document_list = LeDocument::find()->where(array('category_id'=>$id))->count();      //M('Document')->where(array('category_id'=>$cate_id))->field('id')->select();
        if($document_list>0){
            $this->error('请先删除该分类下的文章（包含回收站）');
        }

        //删除该分类信息
        $delete=array('marks'=>1);
        $res = $Model::updateAll($delete,'id='.$id);  // M('Category')->delete($id);
        if($res !== false){
            //记录行为
        action_log('update_category', 'category', $id, UID);
            $this->success('删除分类成功！');
        }else{
            $this->error('删除分类失败！');
        }
    }

}