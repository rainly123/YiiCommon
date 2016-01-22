<?php
namespace common\models;

use common\help\CommonHelper;
use common\help\MemCacheHelper;
use member\models\LeMember;
use Yii;
use yii\base\Model;
use yii\caching\MemCache;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;
    private $_user = false;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password','verifyCode'], 'required','message'=>'{attribute}不能为空'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['verifyCode', 'captcha','captchaAction'=>'public/captcha','message'=>'{attribute}有误'],  //验证验证码是否正确
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.（此方法不能删除）
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        //（此方法不能删除）
    }

    /**
     * @param $param
     * @param bool $mem 为true表示用户信息面向memcache，为false表示面向本地web服务器
     * @return bool|void
     */
    public function login($param,$mem=false)
    {
        if(isset($param['LoginForm'] ))
        {
            foreach($param['LoginForm'] as $key=>$val)//验证参数是否为空
            {
                if(empty($val))
                {
                    $this->addError($key, $key.'不能为空');
                    return;
                }
            }
            $this->attributes=$param['LoginForm'];
            if($this->validate())
            {
                $user_info=User::find()->where(array('username'=>$param['LoginForm']['username'],
                    'password'=>md5($param['LoginForm']['password'])))->asArray()->one();
                if(!empty($user_info))
                {
                    if($user_info['status']!=1)
                    {
                        $this->addError('username','用户已禁用或不存在');
                        return ;
                    }
                    //用户信息写入登录表
                    $this->reglogin($user_info['id']);
                    //将用户信息写入session
                    CommonHelper::setSession('user_auth',$user_info);
                    //将用户写入memcached
                    if($mem)
                    {
                        //将用户名+uid作为key存储
                        $Mkey=$user_info['id'].$user_info['username'];
                        if(!MemCacheHelper::exists($Mkey))
                        {
                            Yii::$app->MemCache->set($Mkey,$user_info,0);
                        }
                    }
                    return true;
                }
                else
                {
                    $this->addError('password', '用户名或密码错误');
                }
            }

        }
    }


    /**
     * @param $userinfo
     * 用户写入当前应用
     */
    public function reglogin($uid)
    {
        //检测用户是否在当前应用登录
        $userinfo=User::find()->where('id='.$uid)->asArray()->one();
        $member=LeMember::findOne($userinfo['id']);
        if(!empty($member))
        {
            $login_time=$member->login;
            $member->last_login_ip=CommonHelper::get_client_ip(1);
            $member->last_login_time=CommonHelper::CurrentTime();
            $member->login=$login_time+1;
            if(!$member->save())
            {
                $this->addError('username','前台用户信息注册失败，请重试！');
            }
        }
        else
        {
            $Model=new LeMember();
            $Model->uid=$userinfo['id'];
            $Model->nickname=$userinfo['username'];
            $Model->email=$userinfo['email'];
            $Model->reg_ip=$userinfo['reg_ip'];
            $Model->login=1;
            $Model->reg_time=$userinfo['reg_time'];
            $Model->last_login_time=$userinfo['last_login_time'];
            $Model->last_login_ip=$userinfo['last_login_ip'];
            if(!$Model->save())
            {
                $this->addError('username','前台用户信息注册失败，请重试！');
            }
        }
        action_log('user_login','loginForm',$uid,$uid);
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}
