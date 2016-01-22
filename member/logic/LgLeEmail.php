<?php
namespace member\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/4
 * Time: 17:10
 */
class LgLeEmail
{
    /**
     * @return 获取邮件列表
     * @throws \yii\base\InvalidConfigException
     */
    function getList(){
        $LeEmail=\Yii::$container->get('M_LeEmail');
        $result=$LeEmail->getList();
        return $result;
    }

    /**
     * @return 获取邮件数量
     * @throws \yii\base\InvalidConfigException
     */
    function getCount()
    {
        $LeEmail=\Yii::$container->get('M_LeEmail');
        $result=$LeEmail->getCount();
        return $result;
    }

    /**
     * @param $param
     * @return 发送邮件
     * @throws \yii\base\InvalidConfigException
     */
    function doSend($param)
    {
        $LeEmail=\Yii::$container->get('M_LeEmail');
        $result=$LeEmail->doSend($param);
        return $result;
    }

    /**
     * @param $param
     * @return 邮件信息写入
     * @throws \yii\base\InvalidConfigException
     */
    function Write($param)
    {
        $LeEmail=\Yii::$container->get('M_LeEmail');
        $result=$LeEmail->Write($param);
        return $result;
    }

    /**
     * @param int $id
     * @return 获取邮件详情
     * @throws \yii\base\InvalidConfigException
     */
    function getInfo($id=0)
    {
        $LeEmail=\Yii::$container->get('M_LeEmail');
        $result=$LeEmail->getInfo($id);
        return $result;
    }

    function DelEmail($ids)
    {
        $LeEmail=\Yii::$container->get('M_LeEmail');
        $result=$LeEmail-> DelEmail($ids);
        return $result;
    }
}