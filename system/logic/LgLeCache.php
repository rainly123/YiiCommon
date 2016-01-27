<?php
namespace system\logic;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/26
 * Time: 10:52
 */
 class LgLeCache
 {
     /**
      * @return  获取缓存列表
      * @throws \yii\base\InvalidConfigException
      */
     function getKeyList()
     {
         $Cache=\Yii::$container->get('M_LeCache');
         $result=$Cache->getKeyList();
         return $result;
     }

     /**
      * @param $key
      * @param $type |缓存类型
      * @return 清除缓存
      * @throws \yii\base\InvalidConfigException
      */
     function removeCacheKey($key,$type)
     {
         $Cache=\Yii::$container->get('M_LeCache');
         $result=$Cache->removeCacheKey($key,$type);
         return $result;
     }

     /**
      * @param $key
      * @param $type
      * @return 缓存信息写入数据库
      * @throws \yii\base\InvalidConfigException
      */
     function addDataKey($key,$type)
     {
         $Cache=\Yii::$container->get('M_LeCache');
         $result=$Cache->addDataKey($key,$type);
         return $result;
     }
 }