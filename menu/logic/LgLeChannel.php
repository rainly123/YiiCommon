<?php
namespace menu\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/15
 * Time: 9:36
 */
class LgLeChannel
{
    /**
     * @param int $pid
     * @return 获取导航菜单列表
     * @throws \yii\base\InvalidConfigException
     */
    function getList($pid=0)
    {
        $M_LeChannel=\Yii::$container->get('M_LeChannel');
        $result= $M_LeChannel-> getList($pid);
        return $result;
    }

    /**
     * @param $pid
     * @return 获取父导航信息
     * @throws \yii\base\InvalidConfigException
     */
    function getParent($pid)
    {
        $M_LeChannel=\Yii::$container->get('M_LeChannel');
        $result= $M_LeChannel-> getParent($pid);
        return $result;
    }

    /**
     * @param $param
     * @return 导航菜单写入
     * @throws \yii\base\InvalidConfigException
     */
    function write($param)
    {
        $M_LeChannel=\Yii::$container->get('M_LeChannel');
        $result= $M_LeChannel->write($param);
        return $result;
    }

    /**
     * @param $id
     * @return 删除导航菜单
     * @throws \yii\base\InvalidConfigException
     */
    function Del($id)
    {
        $M_LeChannel=\Yii::$container->get('M_LeChannel');
        $result= $M_LeChannel->Del($id);
        return $result;
    }

    /**
     * @param $id
     * @param $update
     * @return 修改状态
     * @throws \yii\base\InvalidConfigException
     */
    function editRow($id,$update)
    {
        $M_LeChannel=\Yii::$container->get('M_LeChannel');
        $result= $M_LeChannel->editRow($id,$update);
        return $result;
    }
}