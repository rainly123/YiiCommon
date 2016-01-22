<?php
namespace system\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/30
 * Time: 11:24
 */
class LgLeActionLog
{
    /**
     * @return 获取用户日志列表
     * @throws \yii\base\InvalidConfigException
     */
    function getList()
    {
        $ActionLog=\Yii::$container->get('M_LeActionLog');
        $result=$ActionLog->getList();
        return $result;
    }

    /**
     * @param int $id
     * @return 获取日志细腻
     * @throws \yii\base\InvalidConfigException
     */
    function GetInfo($id=0)
    {
        $ActionLog=\Yii::$container->get('M_LeActionLog');
        $result=$ActionLog->GetInfo($id);
        return $result;
    }

    /**
     * @param int $id
     * @return 删除日志
     * @throws \yii\base\InvalidConfigException
     */
    function Remove($id=0)
    {
        $ActionLog=\Yii::$container->get('M_LeActionLog');
        $result=$ActionLog->Remove($id);
        return $result;
    }

    /**
     * @return 清空日志
     * @throws \yii\base\InvalidConfigException
     */
    function Clear()
    {
        $ActionLog=\Yii::$container->get('M_LeActionLog');
        $result=$ActionLog->Clear();
        return $result;
    }
}