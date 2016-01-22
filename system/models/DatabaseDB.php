<?php
namespace system\models;
use common\help\DBHelper;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/18
 * Time: 18:02
 */
class DatabaseDB extends DBHelper
{
    /**
     * @param $tables
     * 数据库表优化
     */
    function optimize($tables=null)
    {
        if($tables) {
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list = $this->sqlSelect("OPTIMIZE TABLE `{$tables}`");
                if($list){
                    $this->success("数据表优化完成！");
                } else {
                    $this->error("数据表优化出错请重试！");
                }
            } else {
                $list = $this->sqlSelect("OPTIMIZE TABLE `{$tables}`");
                if($list){
                    $this->success("数据表'{$tables}'优化完成！");
                } else {
                    $this->error("数据表'{$tables}'优化出错请重试！");
                }
            }
        } else {
            $this->error("请指定要优化的表！");
        }
    }

    /**
     * @param null $tables
     * 修复表
     */
    function repair($tables=null)
    {
        if($tables) {
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list=$this->sqlSelect("REPAIR TABLE `{$tables}`");
                if($list){
                    $this->success("数据表修复完成！");
                } else {
                    $this->error("数据表修复出错请重试！");
                }
            } else {
                $list=$this->sqlSelect("REPAIR TABLE `{$tables}`");
                if($list){
                    $this->success("数据表'{$tables}'修复完成！");
                } else {
                    $this->error("数据表'{$tables}'修复出错请重试！");
                }
            }
        } else {
            $this->error("请指定要修复的表！");
        }
    }
}