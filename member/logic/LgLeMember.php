<?php
namespace member\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/23
 * Time: 11:14
 */
class LgLeMember
{
    /**
     * @param string $search
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 获取用户列表
     */
    function getMember($search='')
    {
        $Menu=\Yii::$container->get('M_LeUcenterMember');
        $result=$Menu->getMember($search);
        return $result;
    }

    /**
     * @param string $param
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 用户注册
     */
    function register($param='')
    {
        $Menu=\Yii::$container->get('M_LeUcenterMember');
        $result=$Menu->register($param);
        return $result;
    }

    /**
     * @param $uid
     * @param $method
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 修改用户状态
     */
    function ChangeStatus($uid,$method)
    {
        $Menu=\Yii::$container->get('M_LeUcenterMember');
        $result=$Menu->ChangeStatus($uid,$method);
        return $result;
    }

    /**
     * @param $groupid
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 判断用户是否有权访问
     */
    function checkRule($rule,$uid,$type='in (1,2)')
    {
        $Member=\Yii::$container->get('M_LeUcenterMember');
        $result=$Member->checkRule($rule,$uid,$type);
        return $result;
    }
    //检查访问权限
    function check($name, $uid, $type=1, $mode='url', $relation='or')
    {
        $Member=\Yii::$container->get('M_LeUcenterMember');
        $result=$Member->check($name, $uid, $type, $mode, $relation);
        return $result;
    }
}