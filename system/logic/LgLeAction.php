<?php
namespace system\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/23
 * Time: 13:58
 */
class LgLeAction
{
    /**
     * @param null $action
     * @param null $model
     * @param null $record_id
     * @param null $user_id
     * @return 记录行为日志
     * @throws \yii\base\InvalidConfigException
     */
    function action_log($action = null, $model = null, $record_id = null, $user_id = null)
    {
        $LeAction=\Yii::$container->get('M_LeAction');
        $result=$LeAction->action_log($action, $model, $record_id, $user_id );
        return $result;
    }

    /**
     * @param $ids
     * @param $status
     * @return 设置用户行为状态
     * @throws \yii\base\InvalidConfigException
     */
    function SetStatus($ids,$status)
    {
        $LeAction=\Yii::$container->get('M_LeAction');
        $result=$LeAction->SetStatus($ids,$status);
        return $result;
    }
    /**
     * @param $param
     * @return 数据写入
     * @throws \yii\base\InvalidConfigException
     */
    function Write($param)
    {
        $LeAction=\Yii::$container->get('M_LeAction');
        $result=$LeAction->Write($param);
        return $result;
    }
    /**
     * @return 获取用户行为列表
     * @throws \yii\base\InvalidConfigException
     */
    function ActionList()
    {
        $LeAction=\Yii::$container->get('M_LeAction');
        $result=$LeAction->ActionList();
        return $result;
    }

    /**
     * @param $id
     * @return 获取行为详情
     * @throws \yii\base\InvalidConfigException
     */
    function ActionInfo($id)
    {
        $LeAction=\Yii::$container->get('M_LeAction');
        $result=$LeAction->ActionInfo($id);
        return $result;
    }
}