<?php
namespace system\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/21
 * Time: 9:43
 */
class LgLePicture
{
    function  upload($files, $setting, $driver = 'Local', $config = null)
    {
        $picture=\Yii::$container->get('M_LePicture');
        $result=$picture-> upload($files, $setting, $driver, $config);
        return $result;
    }

    /**
     * @return 多文件上传
     * @throws \yii\base\InvalidConfigException
     */
    function mutilUpload($type)
    {
        $picture=\Yii::$container->get('M_LePicture');
        $result=$picture->mutilUpload($type);
        return $result;
    }

    /**
     * @param int $type
     * @return 获取图片列表
     * @throws \yii\base\InvalidConfigException
     */
    function getList($type=0)
    {
        $picture=\Yii::$container->get('M_LePicture');
        $result=$picture->getList($type);
        return $result;
    }

    /**
     * @param int $id
     * @return 根据id获取图片信息
     * @throws \yii\base\InvalidConfigException
     */
    function PicInfo($id=0)
    {
        $picture=\Yii::$container->get('M_LePicture');
        $result=$picture->PicInfo($id);
        return $result;
    }

    /**
     * @param $param
     * @return 图片信息写入
     * @throws \yii\base\InvalidConfigException
     */
    function Write($param)
    {
        $picture=\Yii::$container->get('M_LePicture');
        $result=$picture->Write($param);
        return $result;
    }
}