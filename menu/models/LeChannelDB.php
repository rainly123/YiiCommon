<?php
namespace menu\models;
use common\help\CommonHelper;
use common\help\DBHelper;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/15
 * Time: 9:32
 */
class LeChannelDB extends DBHelper
{
    /**
     * @param int $pid
     * @return 获取导航菜单列表
     */
    function getList($pid=0)
    {
        $where=array('pid'=>$pid,'marks'=>0);
        $list=LeChannel::find()->where($where)->asArray()->all();
        return $list;
    }

    //获取父导航信息
    function getParent($pid)
    {
        $where=array('id'=>$pid,'marks'=>0);
        $list=LeChannel::find()->where($where)->asArray()->one();
        return $list;
    }

    /**
     * @param $param
     * 导航信息写入
     */
    function write($param)
    {
        if(!empty($param['id']))
        {
            $Channel=LeChannel::findOne($param['id']);
        }
        else
        {
            $Channel=new LeChannel();
            $Channel->create_time=CommonHelper::CurrentTime(1);
        }
        $Channel->pid=$param['pid'];
        $Channel->title=$param['title'];
        $Channel->url=$param['url'];
        $Channel->sort=$param['sort'];
        $Channel->target=$param['target'];
        $Channel->status=1;
        $Channel->update_time=CommonHelper::CurrentTime(1);
        if($Channel->validate()&& $Channel->save())
        {
            $this->success('保存成功','index');
        }
        else
        {
            $this->error($Channel->errors);
        }
    }
    //删除导航菜单信息
    function Del($id)
    {
        $model=new LeChannel();
        $update=array(
            'marks'=>1,
        );
        $this->DelById($id,$update,$model);
    }

    /**
     * @param $id
     * 修改状态
     */
    function editRow($id,$update)
    {
        $Model=new LeChannel();
        $this->ChangeById($id,$update,$Model);
    }
}