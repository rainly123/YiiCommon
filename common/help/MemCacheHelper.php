<?php
namespace common\help;
/**
 * FileCache帮助类
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/19
 * Time: 17:44
 */
class MemCacheHelper
{
    /**
     * @param $key
     * @return 判断是否存在
     */
    static function exists($key)
    {
        $val=\Yii::$app->FileCache->get($key);
        if(!empty($val))
        {
            return true;
        }
        return false;
    }

    /**
     * @param $key
     * @return 获取缓存信息
     */
    static function get($key)
    {
        return \Yii::$app->FileCache->get($key);
    }

    /**
     * @param $key 键
     * @param $val 值
     * @param int $duration |0表示永不过期 过期时间
     */
    static function set($key,$val,$duration=0)
    {
        \Yii::$app->FileCache->set($key,$val,$duration);
    }

    /**
     * @param $key
     * 删除缓存信息
     */
    static function Delete($key)
    {
       \Yii::$app->FileCache->deleteValue($key);
    }

}