<?php
namespace document\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/23
 * Time: 18:02
 */
class LgLeDocument
{
    /**
     * @param null $map
     * @return 我的文档
     * @throws \yii\base\InvalidConfigException
     */
    function  MyDocument($map=null)
    {
        $Document=\Yii::$container->get('M_LeDocument');
        $result=$Document->MyDocument($map);
        return $result;
    }

    /**
     * @return 回收站中的数据
     * @throws \yii\base\InvalidConfigException
     */
    function getRecycle()
    {
        $Document=\Yii::$container->get('M_LeDocument');
        $result=$Document->getRecycle();
        return $result;
    }

    /**
     * @return 清空回收站的内容
     * @throws \yii\base\InvalidConfigException
     */
    function Clear()
    {
        $Document=\Yii::$container->get('M_LeDocument');
        $result=$Document->Clear();
        return $result;
    }

    function Permit($ids)
    {
        $Document=\Yii::$container->get('M_LeDocument');
        $result=$Document->Permit($ids);
        return $result;
    }
    /**
     * @param int $id
     * @return 获取所有邮件信息
     * @throws \yii\base\InvalidConfigException
     */
    function getEmail($id)
    {
        $Document=\Yii::$container->get('M_LeDocument');
        $result=$Document->getEmail($id);
        return $result;
    }
    /**
     * @param string $ids
     * @return 排序
     * @throws \yii\base\InvalidConfigException
     */
    function Sort($ids='')
    {
        $Document=\Yii::$container->get('M_LeDocument');
        $result=$Document->Sort($ids);
        return $result;
    }

    /**
     * @param int $id
     * @return 获取子文档数
     * @throws \yii\base\InvalidConfigException
     */
    function get_subdocument_count($id=0)
    {
        $Document=\Yii::$container->get('M_LeDocument');
        $result=$Document->get_subdocument_count($id);
        return $result;
    }

    /**
     * @param null $cate_id
     * @return 获取文档类型
     * @throws \yii\base\InvalidConfigException
     */
    function GetCate($cate_id = null)
    {
        $Document=\Yii::$container->get('M_LeDocument');
        $result=$Document->GetCate($cate_id);
        return $result;
    }

    /**
     * @param $ids
     * @param $status
     * @return 设置文档状态
     * @throws \yii\base\InvalidConfigException
     */
    function setStatus($ids,$status,$url='mydocument'){
        $Document=\Yii::$container->get('M_LeDocument');
        $result=$Document->setStatus($ids,$status,$url);
        return $result;
    }

    /**
     * @param $id
     * @return 获取文档详情
     * @throws \yii\base\InvalidConfigException
     */
    function Detial($id)
    {
        $Document=\Yii::$container->get('M_LeDocument');
        $result=$Document->Detial($id);
        return $result;
    }

    /**
     * @param $param
     * @return 文档更新
     * @throws \yii\base\InvalidConfigException
     */
    function  Write($param)
    {
        $Document=\Yii::$container->get('M_LeDocument');
        $result=$Document->Write($param);
        return $result;
    }
}