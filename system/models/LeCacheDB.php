<?php
namespace system\models;
use common\help\CommonHelper;
use common\help\DBHelper;
use common\help\FileCacheHelper;
use common\help\MemCacheHelper;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/26
 * Time: 9:24
 */
class LeCacheDB extends DBHelper
{
    //获取所有缓存键名
    function getKeyList()
    {
        $map=array('marks'=>0);
        $model=new LeCache();
        $list=$this->_list($model,$map,'create_time');
        return $list;
    }
    //按key清除该缓存
    function removeCacheKey($key,$type)
    {
        if(empty($key)||empty($type))
        {
            $this->error('参数错误！');
        }
        if($type=='memcache')
        {
            $result=MemCacheHelper::delete($key);
            $this->deleteDataKey($key);
        }
        elseif($type=='file')
        {
            $result=FileCacheHelper::delete($key);
            $this->deleteDataKey($key);
        }
        return $result;
    }

    function deleteDataKey($key)
    {
        $key=is_array($key)?implode(',',$key):$key;
        $update=array('marks'=>1);
        $model=new LeCache();
        $model::updateAll($update,"key in ('".$key."')");
    }

    function addDataKey($key,$type)
    {
        $model=new LeCache();
        $model->key=$key;
        $model->$type=$type;
        $model->marks=0;
        $model->create_time=CommonHelper::CurrentTime();
        $model->update_time=CommonHelper::CurrentTime();
        if($model->validate())
        {
            return $model->save();
        }
        else
        {
            $this->error($model->errors);
        }
    }

}