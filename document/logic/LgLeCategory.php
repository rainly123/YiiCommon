<?php
namespace document\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/15
 * Time: 14:10
 */
class LgLeCategory
{
    /**
     * @param int $id
     * @return 获取类别列表
     * @throws \yii\base\InvalidConfigException
     */
    function getTree($id = 0)
    {
        $Category=\Yii::$container->get('M_LeCategory');
        $result=$Category->getTree($id);
        return $result;
    }

    /**
     * @param $from
     * @param $to
     * @return 移动
     * @throws \yii\base\InvalidConfigException
     */
    function move($from,$to)
    {
        $Category=\Yii::$container->get('M_LeCategory');
        $result=$Category->move($from,$to);
        return $result;
    }
    /**
     * @param $from
     * @return 获取操作列表
     * @throws \yii\base\InvalidConfigException
     */
    function getList($from)
    {
        $Category=\Yii::$container->get('M_LeCategory');
        $result=$Category->getList($from);
        return $result;
    }
    /**
     * @param $id
     * @return 获取分类信息
     * @throws \yii\base\InvalidConfigException
     */
    function info($id){
        $Category=\Yii::$container->get('M_LeCategory');
        $result=$Category->info($id);
        return $result;
    }

    /**
     * @param $param
     * @return 数据写入
     * @throws \yii\base\InvalidConfigException
     */
    function write($param)
    {
        $Category=\Yii::$container->get('M_LeCategory');
        $result=$Category-> write($param);
        return $result;
    }

    /**
     * @param $ids
     * @return 禁用类别
     * @throws \yii\base\InvalidConfigException
     */
    function changeStatus($ids,$status)
    {
        $Category=\Yii::$container->get('M_LeCategory');
        $result=$Category-> changeStatus($ids,$status);
        return $result;
    }

    /**
     * @param $id
     * @return 删除分类
     * @throws \yii\base\InvalidConfigException
     */
    function Remove($id)
    {
        $Category=\Yii::$container->get('M_LeCategory');
        $result=$Category-> Remove($id);
        return $result;
    }
}