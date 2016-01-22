<?php
namespace system\models;
use common\help\CommonHelper;
use common\help\DBHelper;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/11
 * Time: 15:02
 */
class  LePictureTypeDB extends  DBHelper
{
    /**
     * @return 获取类型列表
     */
    function getList()
    {
        return LePictureType::find()->where(array('marks'=>0))->orderBy('sort')->asArray()->all();
    }

    //分类信息写入
    function Write($param)
    {
        if(!empty($param['id']))
        {
            $Model=LePictureType::findOne($param['id']);
            $param['update_time']=CommonHelper::CurrentTime();
        }
        else
        {
            $Model=new LePictureType();
            $param['create_time']=CommonHelper::CurrentTime();
            $param['update_time']=CommonHelper::CurrentTime();
        }
        $Model->attributes=$param;
        if($Model->validate()&&$Model->save())
        {
            $this->success('保存成功','index');
        }
        else
        {
            $this->error($Model->errors);
        }
    }
    //排序
    function Sort($ids)
    {
        $Model=new LePictureType();
        $this->Sorts($ids,$Model);
    }

    //获取详细信息
    function getInfo($id)
    {
        if(empty($id))
        {
            $this->error('参数错误');
        }
        return LePictureType::find()->where(array('id'=>$id))->asArray()->one();
    }

    function Del($ids)
    {
        $Model=new LePictureType();
        $update=array('marks'=>1);
        $this->ChangeById($ids,$update,$Model,'index',array('删除成功！','删除失败！'));
    }
}