<?php
namespace system\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/11
 * Time: 15:29
 */
class LgLePictureType
{
    /**
     * @return 获取图片类型列表
     * @throws \yii\base\InvalidConfigException
     */
    function getList()
    {
        $PictureType=\Yii::$container->get('M_LePictureTypeDB');
        $result=$PictureType->getList();
        return $result;
    }

    /**
     * @param $param
     * @return 图片分类信息写入
     * @throws \yii\base\InvalidConfigException
     */
    function Write($param)
    {
        $PictureType=\Yii::$container->get('M_LePictureTypeDB');
        $result=$PictureType->Write($param);
        return $result;
    }

    /**
     * @param $ids
     * @return 排序
     * @throws \yii\base\InvalidConfigException
     */
    function Sort($ids)
    {
        $PictureType=\Yii::$container->get('M_LePictureTypeDB');
        $result=$PictureType->Sort($ids);
        return $result;
    }

    /**
     * @param $id
     * @return 获取图片类型信息
     * @throws \yii\base\InvalidConfigException
     */
    function getInfo($id)
    {
        $PictureType=\Yii::$container->get('M_LePictureTypeDB');
        $result=$PictureType->getInfo($id);
        return $result;
    }

    /**
     * @param $ids
     * @return 删除
     * @throws \yii\base\InvalidConfigException
     */
    function Del($ids)
    {
        $PictureType=\Yii::$container->get('M_LePictureTypeDB');
        $result=$PictureType->Del($ids);
        return $result;
    }
}