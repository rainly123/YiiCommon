<?php
namespace member\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/25
 * Time: 21:14
 */
class LgLeAuthGroup
{

    /**
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 获取用户组（权限组）
     */
    function getAuthGroup()
    {
        $AuthGroup=\Yii::$container->get('M_LeAuthGroup');
        return $AuthGroup->getAuthGroup();
    }

    /**
     * @param $data
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 权限信息写入
     */
    function WriteGroup($data)
    {
        $AuthGroup=\Yii::$container->get('M_LeAuthGroup');
        return $AuthGroup->WriteGroup($data);
    }
    /**
     * @param $method
     * @param $id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 改变用户状态
     */
    function  ChangeStatus($method,$id)
    {
        $AuthGroup=\Yii::$container->get('M_LeAuthGroup');
        return $AuthGroup->ChangeStatus($method,$id);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 根据id获取权限组信息
     */
    function  getAuthGroup_info($id)
    {
        $AuthGroup=\Yii::$container->get('M_LeAuthGroup');
        return $AuthGroup->getAuthGroup_info($id);
    }

}