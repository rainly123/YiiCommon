<?php
namespace menu\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/18
 * Time: 11:03
 */

class LgLeMenu
{
    /**
     * @param $param
     * @return 菜单写入
     * @throws \yii\base\InvalidConfigException
     */
    function write($param)
    {
        $Menu=\Yii::$container->get('M_LeMenu');
        $result= $Menu-> write($param);
        return $result;
    }

    /**
     * @param $id
     * @return 删除菜单信息
     * @throws \yii\base\InvalidConfigException
     */
    function Del($id)
    {
        $Menu=\Yii::$container->get('M_LeMenu');
        $result= $Menu-> Del($id);
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
        $Menu=\Yii::$container->get('M_LeMenu');
        $result= $Menu-> editRow($id,$update);
        return $result;
    }

    /**
     * @param string $ids
     * @param string $pid
     * @return 获取排序数据
     * @throws \yii\base\InvalidConfigException
     */
    function getSortList($ids='',$pid='')
    {
        $Menu=\Yii::$container->get('M_LeMenu');
        $result= $Menu-> getSortList($ids,$pid);
        return $result;
    }

    /**
     * @param string $ids
     * @return 排序
     * @throws \yii\base\InvalidConfigException
     */
    function Sort($ids='')
    {
        $Menu=\Yii::$container->get('M_LeMenu');
        $result= $Menu-> Sort($ids);
        return $result;
    }
    /**
     * @return 获取属性菜单
     * @throws \yii\base\InvalidConfigException
     */
    function getTreeMenu()
    {
        $Menu=\Yii::$container->get('M_LeMenu');
        $result= $Menu-> getTreeMenu();
        return $result;
    }
    /**
     * @param string $CurrentPath
     * @return 获取菜单
     * @throws \yii\base\InvalidConfigException
     *
     */
    function getMenus($CurrentPath='')
    {
        $Menu=\Yii::$container->get('M_LeMenu');
        $result= $Menu->getMenus($CurrentPath);
        return $result;
    }

    /**
     * @param int $pid
     * @return  根据pid获取菜单列表
     * @throws \yii\base\InvalidConfigException
     */
    function getListByPid($pid=0,$title='')
    {
        $Menu=\Yii::$container->get('M_LeMenu');
        $result= $Menu->getListByPid($pid,$title);
        return $result;
    }

    /**
     * @param $id
     * @return 根据id获取菜单信息
     * @throws \yii\base\InvalidConfigException
     */
    function getInfoById($id)
    {
        $Menu=\Yii::$container->get('M_LeMenu');
        $result= $Menu-> getInfoById($id);
        return $result;
    }
    /**
     * @param int $getcate_id
     * @return 当用户点击类容时获取菜单
     * @throws \yii\base\InvalidConfigException
     *
     */
    function getMenu($getcate_id=0)
    {
        $Menu=\Yii::$container->get('M_LeMenu');
        $result= $Menu->getMenu($getcate_id);
        return $result;
    }
}
