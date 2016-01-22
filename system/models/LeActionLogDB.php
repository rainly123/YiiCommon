<?php
namespace system\models;
use common\help\DBHelper;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/30
 * Time: 11:19
 */
class LeActionLogDB extends DBHelper
{
    //获取日志列表
     function getList()
     {
         $map=array('status'=>1);
         $model=new LeActionLog();
         $list=$this->_list($model,$map,'create_time desc');
         $this->int_to_string($list['list']);
         return $list;
     }

    /**
     * @param int $id
     * @return 获取日志信息
     */
    function GetInfo($id=0)
    {
        if($id==0)
        {
            $this->error("参数错误");
        }
        $map=array('id'=>$id);
        $info=LeActionLog::find()->where($map)->asArray()->one();
        return $info;
    }
    //删除
    function Remove($id=0)
    {
        if($id==0)
        {
            $this->error("参数错误");
        }
        $model=new LeActionLog();
        if(is_array($id))
        {
            $id=array_unique($id);
            $id=is_array($id)?implode(',',$id):$id;
        }
        $result= $model->deleteAll('id in ('.$id.')');
        if($result)
        {
            $this->success("日志删除成功");
        }
        else
        {
            $this->error("日志删除失败");
        }
    }
    //清空
    function Clear()
    {
        $result=LeActionLog::deleteAll();
        if($result)
        {
            $this->success("日志清空成功");
        }
        else
        {
            $this->error("日志清理失败");
        }
    }
}
