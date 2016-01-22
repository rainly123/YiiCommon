<?php
namespace document\models;
use common\help\CommonHelper;
use common\help\DBHelper;
use document\logic\LgLeDocument;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/23
 * Time: 17:20
 */
class LeDocumentDB extends DBHelper
{
    /**
     * @param null $map
     * @return object
     * 我的文档
     */
    function  MyDocument($map=null)
    {
        $Document   =   new LeDocument();
        $map['uid'] = UID;
        $where="mark=0 AND pid=0 ";
        if(!empty($map['cate_id']))
        {
            $where.=" AND category_id=".$map['cate_id']." ";
        }
        if(!empty($map['title'])){
            $where.=" AND title like '%".$map['title']."%' ";
        }
        if(!empty($map['status'])){
            $where.=" AND status=".$map['status']." ";
        }else{
            $where.=" AND status in (0,1,2)";
        }
        if ( !empty($map['time-start']) ) {
            $where.=" AND update_time>=".strtotime($map['time-start'])." ";
        }
        if ( !empty($map['time-end']) ) {
            $where.=" AND update_time<=".(24*60*60+strtotime($map['time-end']))." ";
        }
        if(!empty($map['ids'])){
            $where.=" AND id in (".$map['ids'].") ";
        }
        if(!empty($map['uid'])) {
            $where.=" AND uid=".$map['uid']." ";
        }
        $list = $this->_list($Document,$where,'level');
        $this->int_to_string($list['list']);
        return $list;
    }

    //回收站中的数据
    function getRecycle()
    {
        $Model=new LeDocument();
        $list=$this->_list($Model,array('status'=>-1));
        return $list;
    }

    //清空回收站
    function Clear()
    {
        $map=array('status'=>-1);
        $Model=new LeDocument();
        $this->RelDelete($Model,$map);
        $this->ClearArticle();
    }

    //删除废弃的文章内容
    function ClearArticle()
    {
        $sqlstr="SELECT id FROM ".TABLEPREFIX."document_article WHERE id NOT IN (SELECT id FROM ".TABLEPREFIX."document)";
        $result=$this->sqlSelect($sqlstr);
        $len=count($result);
        $ids="";
        $i=0;
        if($len>0)
        {
            foreach($result as $val)
            {
                $i++;
                if($i!=$len)
                {
                    $ids.=$val['id'].',';
                }
                else
                {
                    $ids.=$val['id'];
                }
            }
            $map="id in (".$ids.")";
            $Model=new LeDocumentArticle();
            $result=$this->RelDelete($Model,$map);
            if($result)
            {
                $this->success('清空成功');
            }
        }
        else
        {
            $this->success('清空成功');
        }
    }
    //还原文档
    function Permit($ids)
    {
        $model=new LeDocument();
        $update=array('status'=>1);
        $this->ChangeById($ids,$update,$model,'',array('文档还原成功！','文档还原失败！'));
    }
    /**
     * @param int $id
     * @return 获取所有邮件信息
     */
    function getEmail($id)
    {
        if(is_numeric($id)){ //通过ID查询
            $map['id'] = $id;
        } else { //通过标识查询
            $map['name'] = $id;
        }
        $Category=LeCategory::find()->where($map)->asArray()->one();

        if($Category['name']=='email')
        {
            return LeDocument::find()->where(array('category_id'=>$Category['id'],'status'=>1))->asArray()->all();
        }
        return null;
    }

    /**
     * @param string $ids
     * 排序
     */
    function Sort($ids='')
    {
        $ids=explode(',',$ids);
        $res=false;
        foreach ($ids as $key=>$value){
            $Document=LeDocument::findOne($value);
            $Document->level=$key+1;
            $res=$Document->save();
        }
        if($res !== false){
            $this->success('排序成功！','index');
        }else{
            $this->error('排序失败！','index');
        }
    }
    /**
     * 获取子文档数
     */
    function get_subdocument_count($id=0)
    {
        $count=LeDocument::find()->where(array('pid'=>$id))->count();
        return $count;
    }
    /**
     * 获取当前文档的分类
     * @param int $id
     * @return array 文档类型数组
     */
    function GetCate($cate_id = null){
        if(empty($cate_id)){
            return false;
        }
        $cate   = LeCategory::find()->where(array('id'=>$cate_id))->asArray()->one();  //  M('Category')->where('id='.$cate_id)->getField('title');
        if(!empty($cate))
        {
            return $cate['title'];
        }
    }

    /**
     * @param $ids
     * @param $status
     * 设置文档状态
     */
    function setStatus($ids,$status,$url='mydocument'){
        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }
        $Model=new LeDocument();
        $update=array('status'=>$status);
        switch ($status){
            case -1 :
                $this->ChangeById($ids,$update,$Model,'',array('删除成功','删除失败'));
                break;
            case 0  :
                $this->ChangeById($ids,$update,$Model,'',array('禁用成功','禁用失败'));
                break;
            case 1  :
                $this->ChangeById($ids,$update,$Model,'',array('启用成功','启用失败'));
                break;
            default :
                $this->error('参数错误');
                break;
        }

    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * 获取文档详情
     */
    function Detial($id)
    {
        if(empty($id))
        {
            $this->error('参数不能为空');
        }
        $data=LeDocument::find()->where(array('id'=>$id))->asArray()->one();
        if(!(is_array($data) || 1 !== $data['status']))
        {
            $this->error ('文档被禁用或已删除！');
        }
        $Article=LeDocumentArticle::find()->where(array('id'=>$data['id']))->asArray()->one();
        $Category=$this->parentDocument($data['category_id']);
        $data['content']=$Article['content'];
        $data['category_text']=$Category['title'];
        $data['parent_category_id']=$Category['pid'];
        $data['parent_category_text']=$Category['parent_title'];
        return $data;
    }
    //获取当前类别名和父类别名
    function parentDocument($cate_id)
    {
        $current=LeCategory::find()->where(array('id'=>$cate_id))->asArray()->one();
        $parent=LeCategory::find()->where(array('id'=>$current['pid']))->asArray()->one();
        $current['parent_title']=$parent['title'];
        return $current;
    }

    /**
     * @param $param
     * 文档编辑
     */
    function Write($param)
    {
        $param['deadline']=!empty($param['create_time'])?strtotime($param['create_time']):0;
        //文章基本内容添加或修改
        if($param['id']==0||empty($param['id'])||!isset($param['id']))
        {
            $Model=new LeDocument();
            $param['create_time']=CommonHelper::CurrentTime();
            $param['update_time']=CommonHelper::CurrentTime();
            $param['uid']=UID;
            $param['status']=1;
        }
        else
        {
            $Model=LeDocument::findOne($param['id']);
            $param['create_time']=CommonHelper::CurrentTime();
            $param['update_time']=CommonHelper::CurrentTime();
            $param['mark']=0;
            $param['uid']=isLogin();
        }
        $Model->attributes=$param;
        if($Model->validate()&&$Model->save())
        {
            //文章内容添加或修改
            $count=LeDocumentArticle::find()->where(array('id'=>$param['id']))->count();
            if($count>0)
            {
                $ModelDocument=LeDocumentArticle::findOne($param['id']);
                $ModelDocument->content=$param['content'];
                if(!$ModelDocument->validate()||!$ModelDocument->save())
                {
                    $this->error($ModelDocument->errors);
                }
            }
            else
            {
                $ModelDocument=new LeDocumentArticle();
                if($param['id']!=0)
                {
                    $ModelDocument->id=$param['id'];
                }
                $ModelDocument->id=$Model->id;
                $ModelDocument->content=$param['content'];
                if(!$ModelDocument->validate()||!$ModelDocument->save())
                {
                    $this->error($ModelDocument->errors);
                }
            }
            $this->success('保存成功','index?cate_id='.$param['category_id']);
        }
        else
        {
            $this->error($Model->errors);
        }
    }
}