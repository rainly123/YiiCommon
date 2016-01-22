<?php
namespace member\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * for:用户权限
 * Date: 2015/11/26
 * Time: 13:26
 */
class LgLeAuthRule
{
    /**
     * @param $group_id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 获取权限列表
     */
    function getRules($group_id)
    {
        $LeAuth=\Yii::$container->get('M_LeAuthRule');
        return $LeAuth->getRules($group_id);
    }

    /**
     * @param $data
     * 权限信息写入
     */
    function WriteGroup($data)
    {
        $LeAuth=\Yii::$container->get('M_LeAuthRule');
        return $LeAuth->WriteGroup($data);
    }

    /**
     * @param $group_id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 获取权限组用户
     */
    function getUserGroup($group_id)
    {
        $LeAuth=\Yii::$container->get('M_LeAuthRule');
        return $LeAuth->getUserGroup($group_id);
    }

    /**
     * @return array
     * 获取权限组列表
     */
    function getGroupList()
    {
        $LeAuth=\Yii::$container->get('M_LeAuthRule');
        return $LeAuth->getGroupList();
    }


}