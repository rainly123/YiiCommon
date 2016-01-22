<?php
namespace member\models;
use common\help\CommonHelper;
use common\help\DBHelper;
use common\models\LoginForm;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/23
 * Time: 10:32
 */
class LeUcenterMemberDB extends DBHelper
{

    protected $_config = array(
        'AUTH_ON'           => true,                      // 认证开关
        'AUTH_TYPE'         => 1,                         // 认证方式，1为实时认证；2为登录认证。
        'AUTH_GROUP'        => 'auth_group',        // 用户组数据表名
        'AUTH_GROUP_ACCESS' => 'auth_group_access', // 用户-用户组关系表
        'AUTH_RULE'         => 'auth_rule',         // 权限规则表
        'AUTH_USER'         => 'member'             // 用户信息表
    );

    protected $ucentermeber;
    protected $member;
    function __construct()
    {
        $this->ucentermeber=C('TABLEPREFIX').'ucenter_member';
        $this->member=C('TABLEPREFIX').'member';
    }
    /**
     * @param string $search
     * @return object
     * 获取用户列表
     */
    function getMember($search='')
    {
        $model=new LeMember();
        $map='status>-1';
        if($search!='')
        {
            $map.=" and nickname like '%".$search."%'";
        }
        $result=$this->_list($model,$map);
        return $result;
    }


    /**
     * @param $uid
     * @return null
     * 获取当前用户所在组
     */
    function checkRule($rule,$uid,$type='in (1,2)')
    {
        $query=new Query();
        $table=C('TABLEPREFIX').'auth_group_access';
        $result=$query->select('group_id')->where('uid='.$uid.'')->from($table)->createCommand()->queryAll();//获取用户所属权限组
        if(!empty($result))
        {
            return $this->getRule($result[0]['group_id'],$rule,$type);
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $groupid
     * @param $rule
     * @param $type
     * @return bool
     * 获取用户权限
     */
    function getRule($groupid,$rule,$type)
    {
        $AuthGroup=LeAuthGroup::findOne($groupid);
        $rules=$AuthGroup->rules;
        $AuthRule=LeAuthRule::find()->where("id in (".$rules.") and  type ".$type." and status=1")->asArray()->all();
        if(!empty($AuthRule))
        {
            foreach($AuthRule as $val)
            {
                $result[$val['id']]=strtolower($val['name']);
            }
            return in_array_case(strtolower($rule),$result);
        }
        else
        {
            return false;
        }

    }

    /**
     * @param $param
     * 用户注册
     */
    function register($param='')
    {
        if(isset($param['LeUcenterMemberDB']))
        {
            $modele=new LeUcenterMember();
            if($param['LeUcenterMemberDB']['password']!=$param['LeUcenterMemberDB']['repassword'])
            {
                $this->error('两次密码不一致');
            }
            $modele->username=$param['LeUcenterMemberDB']['username'];
            $modele->password=md5($param['LeUcenterMemberDB']['password']);
            $modele->email=$param['LeUcenterMemberDB']['email'];
            $modele->reg_ip=CommonHelper::get_client_ip(1);
            $modele->reg_time=CommonHelper::CurrentTime();
            $modele->update_time=CommonHelper::CurrentTime();
            $modele->status=1;
            if($modele->validate())
            {
                if($modele->save())
                {
                    $logonform=new LoginForm();
                    $logonform->reglogin(CommonHelper::CurrentId($modele));
                    $this->success("保存成功",'index');
                }
            }
            else
            {
                $this->error($modele->errors);
            }
        }

    }

    /**
     * @param $method
     * @param $uid
     * 用户状态改变
     */
    function ChangeStatus($uid,$method)
    {
        $id=is_array($uid)?implode(',',$uid):$uid;
        if(empty($uid))
        {
            $this->error("请选择要操作的数据！");
        }
        if(empty($method))
        {
            $this->error("系统异常，请联系管理员！");
        }
        switch($method)
        {
            case 'forbidUser':
                return $this->ForbidUser($method,$id);
                break;
            case 'resumeUser':
                return $this->ResumeUser($method,$id);
                break;
            case 'deleteUser':
                return $this->DeleteUser($method,$id);
                break;
        }

    }

    /**
     * @param $method
     * @param $id
     * 用户禁用
     */
    function ForbidUser($method,$id,$status=0)
    {
        if(empty($id)||empty($method))
        {
            $this->error("系统异常，请联系管理员！");
        }
        $sqlstr="UPDATE ".$this->member." SET status=$status WHERE uid IN ($id) ";
        if($this->sqlUpdate($sqlstr))
        {
            $sqlstr="UPDATE ".$this->ucentermeber." SET status=$status where id IN ($id)";
            $this->sqlUpdate($sqlstr);
            $this->success("用户禁用成功",'index');//禁用成功并刷新
        }

    }

    /**
     * @param $method
     * @param $id
     * 用户启用
     */
    function ResumeUser($method,$id,$status=1)
    {
        if(empty($id)||empty($method))
        {
            $this->error("系统异常，请联系管理员！");
        }
        $sqlstr="UPDATE ".$this->member." SET status=$status WHERE uid IN ($id)";
        if($this->sqlUpdate($sqlstr))
        {
            $sqlstr="UPDATE ".$this->ucentermeber." SET status=$status where id IN ($id)";
            $this->sqlUpdate($sqlstr);
            $this->success("用户启用成功",'index');//启用成功并刷新
        }
    }


    /**
     * @param $method
     * @param $id
     * 用户假删除
     */
    function  DeleteUser($method,$id,$status=-1)
    {
        if(empty($id)||empty($method))
        {
            $this->error("系统异常，请联系管理员！");
        }
        $sqlstr="UPDATE ".$this->member." SET status=$status WHERE uid IN ($id) ";
        if($this->sqlUpdate($sqlstr))
        {
            $sqlstr="UPDATE ".$this->ucentermeber." SET status=$status where id IN ($id)";
            $this->sqlUpdate($sqlstr);
            $this->success("用户删除成功",'index');//删除成功并刷新
        }
    }



}