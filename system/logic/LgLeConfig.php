<?php
namespace system\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/2
 * Time: 11:52
 */
class LgLeConfig
{
    /**
     * @param null $name
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 获取系统配置
     */
    function C($name=null)
    {
        $LeConfig=\Yii::$container->get('M_LeConfig');
        return $LeConfig->C($name);
    }

    /**
     * @param string $ids
     * @return 排序
     * @throws \yii\base\InvalidConfigException
     */
    function Sort($ids='')
    {
        $LeConfig=\Yii::$container->get('M_LeConfig');
        return $LeConfig->Sort($ids);
    }
    /**
     * @param null $group
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 获取配置列表
     */
    function getList($group=null)
    {
        $LeConfig=\Yii::$container->get('M_LeConfig');
        return $LeConfig->getList($group);
    }

    /**
     * @param null $group
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 分页列表
     */
    function getListPage($group=null,$search='',$ids='')
    {
        $LeConfig=\Yii::$container->get('M_LeConfig');
        return $LeConfig->getListPage($group,$search,$ids);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 获取配置信息
     */
    function getInfo($id)
    {
        $LeConfig=\Yii::$container->get('M_LeConfig');
        return $LeConfig->getInfo($id);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 删除配置信息
     */
    function Del($id)
    {
        $LeConfig=\Yii::$container->get('M_LeConfig');
        return $LeConfig->Del($id);
    }
    /**
     * @param $param
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 配置添加更新操作
     */
    function write($param)
    {
        $LeConfig=\Yii::$container->get('M_LeConfig');
        return $LeConfig->write($param);
    }
    /**
     * @param $config
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * 保存用户数据
     */
    function Save($config)
    {
        $LeConfig=\Yii::$container->get('M_LeConfig');
        return $LeConfig-> Save($config);
    }
}