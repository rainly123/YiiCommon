<?php

namespace member\models;

use Yii;

/**
 * This is the model class for table "{{%ucenter_member}}".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $mobile
 * @property string $reg_time
 * @property string $reg_ip
 * @property string $last_login_time
 * @property string $last_login_ip
 * @property string $update_time
 * @property integer $is_check
 * @property integer $status
 */
class LeUcenterMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ucenter_member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required','message'=>'{attribute}不能为空'],
            [['reg_time', 'reg_ip', 'last_login_time', 'last_login_ip', 'update_time', 'is_check', 'status'], 'integer'],
            [['username'], 'string', 'max' => 16,'tooLong'=>'用户名最大长度为16个字符'],
            [['password', 'email'], 'string','tooLong'=>'您设置的密码过长', 'max' => 32],
            [['mobile'], 'string', 'max' => 15],
            [['username'], 'unique','message'=>'用户名已存在'],
            [['email'], 'unique','message'=>'邮箱已被注册']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户ID',
            'username' => '用户名',
            'password' => '密码',
            'email' => '用户邮箱',
            'mobile' => '用户手机',
            'reg_time' => '注册时间',
            'reg_ip' => '注册IP',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
            'update_time' => '更新时间',
            'is_check' => '是否邮箱验证',
            'status' => '用户状态',
        ];
    }
}
