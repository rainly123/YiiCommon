<?php
namespace member\models;
use common\help\DBHelper;

/**
 * Created by PhpStorm.
 * User: congsheng
 * for:权限组管理
 * Date: 2015/11/25
 * Time: 18:03
 */
class LeAuthGroupDB extends DBHelper
{
    /**
     * @return object
     * 获取用户组列表
     */
    function getAuthGroup()
    {
        $model=new LeAuthGroup();
        $map="status>=0";
        $result=$this->_list($model,$map);
        return $result;
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * 根据id获取详情
     */
    function getAuthGroup_info($id)
    {
        $map="status>=0 ";
        if(empty($id))
        {
            $this->error("id不能为空!");
        }
        $map.=" and id=$id";
        $result=LeAuthGroup::find()->where($map)->asArray()->one();
        return $result;
    }


    /**
     * @param $method
     * @param $id
     * 改变用户组状态
     */
    function ChangeStatus($method,$id)
    {
        $id=is_array($id)?implode(',',$id):$id;
        if(empty($id))
        {
            $this->error("请选择要操作的数据！");
        }
        if(empty($method))
        {
            $this->error("系统异常，请联系管理员！");
        }
        switch($method)
        {
            case 'forbidGroup':
                return $this->ForbidGroup($method,$id);
                break;
            case 'resumeGroup':
                return $this->ResumeGroup($method,$id);
                break;
            case 'deleteGroup':
                return $this->DeleteGroup($method,$id);
                break;
        }
    }

    /**
     * @param $method
     * @param $id
     * @param int $status
     * 禁用用户组
     */
    function ForbidGroup($method,$id,$status=0)
    {
        if(empty($id)||empty($method))
        {
            $this->error("系统异常，请联系管理员！");
        }
        $sqlstr="UPDATE le_auth_group SET status=$status WHERE id IN ($id) ";
        if($this->sqlUpdate($sqlstr))
        {
            $this->sqlUpdate($sqlstr);
            $this->success("权限组禁用成功",'index');//禁用成功并刷新
        }
    }

    /**
     * @param $method
     * @param $id
     * @param int $status
     * 启用用户组
     */
    function ResumeGroup($method,$id,$status=1)
    {
        if(empty($id)||empty($method))
        {
            $this->error("系统异常，请联系管理员！");
        }
        $sqlstr="UPDATE le_auth_group SET status=$status WHERE id IN ($id) ";
        if($this->sqlUpdate($sqlstr))
        {
            $this->sqlUpdate($sqlstr);
            $this->success("权限组启用成功",'index');//启用成功并刷新
        }
    }

    /**
     * @param $method
     * @param $id
     * @param int $status
     * 删除用户组
     */
    function DeleteGroup($method,$id,$status=-1)
    {
        if(empty($id)||empty($method))
        {
            $this->error("系统异常，请联系管理员！");
        }
        $sqlstr="UPDATE le_auth_group SET status=$status WHERE id IN ($id) ";
        if($this->sqlUpdate($sqlstr))
        {
            $this->sqlUpdate($sqlstr);
            $this->success("权限组删除成功",'index');//删除成功并刷新
        }
    }
}