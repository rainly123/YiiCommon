<?php
namespace common\help;
use member\logic\LgLeMember;
use system\logic\LgLeConfig;

/**
 * Created by PhpStorm.
 * User: congsheng
 * for：公共帮助类
 * Date: 2015/11/21
 * Time: 10:11
 */
class CommonHelper
{
    /**
     * @param $key 键
     * @param $val 值
     *写入session
     */
     static function setSession($key,$val,$time_out=3600)
     {
         $session=\Yii::$app->session;
         if(!$session->isActive)
         {
             $session->open();
         }
         $session->set($key,$val);
         $session->setTimeout($time_out);//设置过期时间
     }
    /**
     * @param $key
     * @return mixed
     * 获取session值
     */
    static function getSession($key)
    {
        $session=\Yii::$app->session;
        if(empty($key))
        {
            die("session 主键不能为空");
        }
        if(!$session->isActive)
        {
           $session->open();
        }
        return $session->get($key);
    }

    /**
     * @param $key
     * @return mixed
     * 移除session数据
     */
    static function rmSession($key)
    {
        $session=\Yii::$app->session;
        if(!$session->isActive)
        {
            $session->open();
        }
        return  $session->remove($key);
    }

    /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @return mixed
     */
    static function get_client_ip($type = 0) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }


    /**
     * @param int $type  1获取时间戳，0获取长时间格式
     * @return bool|string
     */
    static function CurrentTime($type=1)
    {
        if($type==1)
        {
            return $_SERVER['REQUEST_TIME'];
        }
        else
        {
            return date('y-m-d h:i:s',time());
        }
    }

    /**
     * @param $model
     * @return mixed
     * 获取当前插入id
     */
    static function CurrentId($model,$id='id')
    {
       return $model->attributes[$id];
    }


    /**
     * 把返回的数据集转换成Tree
     * @param array $list 要转换的数据集
     * @param string $pid parent标记字段
     * @param string $level level标记字段
     * @return array
     * @author congsheng <zuojiazi@vip.qq.com>
     */
    static function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * @param null $name
     * @return mixed
     * 从数据库中获取配置信息
     */
    static function C($name=null)
    {
        $config=new LgLeConfig();
        return $config->C($name);
    }
    /**
     * 获取配置的类型
     * @param string $type 配置类型
     * @return string
     */
    static function get_config_type($type=0){
        $list = self::C('CONFIG_TYPE_LIST');
        return $list[$type];
    }

    /**
     * 获取配置的分组
     * @param string $group 配置分组
     * @return string
     */
    static function get_config_group($group=0){
        $list = self::C('CONFIG_GROUP_LIST');
        return $group?$list[$group]:'';
    }

    /**
     * @param $value
     * @param $array
     * @return bool
     * 不区分大小写的inarray
     */
    static function in_array_case($value,$array){
        return in_array(strtolower($value),array_map('strtolower',$array));
    }

    /**
     * @param $rule
     * @param $uid
     * @return mixed
     * 权限检测
     */
    static function checkRule($rule,$uid,$type='in (1,2)')
    {
        $AuthRule=new LgLeMember();
        return $AuthRule->checkRule($rule,$uid,$type);
    }

    /**
     * @param $input
     * @return string
     * json_encode不转义中文
     */
    static function json_encode($input){
        // 从 PHP 5.4.0 起, 增加了这个选项.
        if(defined('JSON_UNESCAPED_UNICODE')){
            return json_encode($input, JSON_UNESCAPED_UNICODE);
        }
        if(is_string($input)){
            $text = $input;
            $text = str_replace('\\', '\\\\', $text);
            $text = str_replace(
                array("\r", "\n", "\t", "\""),
                array('\r', '\n', '\t', '\\"'),
                $text);
            return '"' . $text . '"';
        }else if(is_array($input) || is_object($input)){
            $arr = array();
            $is_obj = is_object($input) || (array_keys($input) !== range(0, count($input) - 1));
            foreach($input as $k=>$v){
                if($is_obj){
                    $arr[] = self::json_encode($k) . ':' . self::json_encode($v);
                }else{
                    $arr[] = self::json_encode($v);
                }
            }
            if($is_obj){
                return '{' . join(',', $arr) . '}';
            }else{
                return '[' . join(',', $arr) . ']';
            }
        }else{
            return $input . '';
        }
    }

}