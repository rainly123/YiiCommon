<?php
namespace backend\controllers;
use common\help\CommonHelper;
use member\logic\LgLeMember;
use Yii;
use yii\base\Controller;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/17
 * Time: 16:20
 */
class AdminController extends Controller
{
    protected $CurrentPath;  //当前路径（控制器+action）
    function beforeAction($action)//用户权限检测（控制器入口）
    {
        ////////start判断请求方式//////////////
        define('IS_GET',       Yii::$app->request->isGet ? true : false);
        define('IS_POST',      Yii::$app->request->isPost ? true : false);
        define('IS_AJAX',      Yii::$app->request->isAjax ? true : false);
        ////////end判断请求方式//////////////

        define('UID',isLogin());
        define('MODULE_NAME',C('MODULE_NAME'));
        define('TABLEPREFIX',C('TABLEPREFIX'));//数据库表前缀
        define('CURRENT_PATH',$this->CurrentPath);
        define('CONTROLLER_NAME',Yii::$app->controller->id);
        define('ACTION_PATH',Yii::$app->controller->action->id.'?'.$this->CurrentActionPath());
        define('ACTION_NAME',Yii::$app->controller->action->id);
        $controllerID = \Yii::$app->controller->id;
        $actionID = \Yii::$app->controller->action->id;
        $this->CurrentPath=$controllerID.'/'.$actionID; //获取当前路径并赋值
        // 检测访问权限
        define('IS_ROOT',is_administrator());
        $access =   $this->accessControl();
        if ( $access === false ) {
            die('403:禁止访问');
        }elseif( $access === null ){
            $dynamic        =   $this->checkDynamic();//检测分类栏目有关的各项动态权限
            if( $dynamic === null ){
                //检测非动态权限
                $rule  = strtolower(MODULE_NAME.'/'.$this->CurrentPath);
                $Auth=new LgLeMember();
                if ( !$Auth->checkRule($rule,UID) ){
                    die('a未授权访问!');
                }
            }elseif( $dynamic === false ){
                die('b未授权访问!');
            }
        }
        return true;
    }

    /**
     * @return 当前action的名称及参数
     */
    function CurrentActionPath()
    {
        $get=Yii::$app->request->get();
        $len=count($get);
        $i=0;
        $param='';
        foreach($get as $key=>$val)
        {
            $i++;
            if($i==$len)
            {
                $param.=$key.'='.$val;
            }
            else
            {
                $param.=$key.'='.$val.'&';
            }
        }
        return $param;
    }
    /**
     * 检测是否是需要动态判断的权限
     * @return boolean|null
     *      返回true则表示当前访问有权限
     *      返回false则表示当前访问无权限
     *      返回null，则会进入checkRule根据节点授权判断权限
     *
     * @author 朱亚杰  <xcoolcc@gmail.com>
     */
    protected function checkDynamic(){
        if(IS_ROOT){
            return true;//管理员允许访问任何页面
        }
        return null;//不明,需checkRule
    }
    /**
     * action访问控制,在 **登陆成功** 后执行的第一项权限检测任务
     *
     * @return boolean|null  返回值必须使用 `===` 进行判断
     *
     *   返回 **false**, 不允许任何人访问(超管除外)
     *   返回 **true**, 允许任何管理员访问,无需执行节点权限检测
     *   返回 **null**, 需要继续执行节点权限检测决定是否允许访问
     * @author 朱亚杰  <xcoolcc@gmail.com>
     */
    final protected function accessControl(){
        if(IS_ROOT){
            return true;//管理员允许访问任何页面
        }
        $allow = CommonHelper::C('ALLOW_VISIT');
        $deny  = CommonHelper::C('DENY_VISIT');
        $check = strtolower($this->CurrentPath);
        if ( !empty($deny)  && in_array_case($check,$deny) ) {
            return false;//非超管禁止访问deny中的方法
        }
        if ( !empty($allow) && in_array_case($check,$allow) ) {
            return true;
        }
        return null;//需要检测节点权限
    }

    /**
     * @param $name
     * @return array|mixed
     * 获取Post或Get请求中的参数
     */
    function getValue($name){
        $request = \Yii::$app -> request;
        $value = $request -> post($name);
        return empty($value) ? $request -> get($name) : $value;
    }

    /**
     * @return array|mixed
     * 获取Post或Get请求中的参数
     */
    function getParam()
    {
        $request = \Yii::$app -> request;
        $value = $request -> post();
        return empty($value) ? $request -> get() : $value;
    }

    /**
     * @return string
     * 获取当前控制器
     */
    function getController()
    {
        return  strtolower(\Yii::$app->controller->id);
    }

    /**
     * @return string
     * 获取当前用户请求action
     */
    function getAction()
    {
        return strtolower(\Yii::$app->controller->action->id);
    }


    /**
     * @return array|string
     * @param string $msg 返回信息
     * @param bool $json 是否json数据
     * 成功返回方法
     */
    function success($msg='',$url='',$data='',$json=true)
    {
        $message=array(
            'status'=>1,
            'data'=>$data,
            'url'=>$url,
            'info'=>$msg,
        );
        if($json)
        {
            echo json_encode($message);
            die();
        }
        else
        {
            return $message;
        }
    }


    /**
     * @return array|string
     * @param string $msg 返回信息
     * @param bool $json 是否json数据
     * 失败返回方法
     */
    function error($msg='',$url='',$json=true)
    {
        if(is_array($msg))
        {
            foreach($msg as $val)
            {
                $msg=$val[0];
                break;
            }
        }
        $message=array(
            'status'=>0,
            'info'=>$msg,
            'url'=>$url,
        );
        if($json)
        {
            echo json_encode($message);
            exit;
        }
        else
        {
            return $message;
        }
    }
}