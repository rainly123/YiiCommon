<?php

namespace member\models;

use Yii;

/**
 * This is the model class for table "{{%member}}".
 *
 * @property string $uid
 * @property string $nickname
 * @property string $email
 * @property integer $sex
 * @property string $birthday
 * @property string $qq
 * @property integer $score
 * @property string $login
 * @property string $reg_ip
 * @property string $reg_time
 * @property string $last_login_ip
 * @property string $last_login_time
 * @property integer $status
 * @property string $head_img
 */
class LeMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'score', 'login', 'reg_ip', 'reg_time', 'last_login_ip', 'last_login_time', 'status'], 'integer'],
            [['birthday'], 'safe'],
//            [['head_img'], 'required'],
            [['nickname'], 'string', 'max' => 16],
            [['email'], 'string', 'max' => 25],
            [['qq'], 'string', 'max' => 10],
            [['head_img'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户ID',
            'nickname' => '昵称',
            'email' => '邮箱',
            'sex' => '性别',
            'birthday' => '生日',
            'qq' => 'qq号',
            'score' => '用户积分',
            'login' => '登录次数',
            'reg_ip' => '注册IP',
            'reg_time' => '注册时间',
            'last_login_ip' => '最后登录IP',
            'last_login_time' => '最后登录时间',
            'status' => '会员状态',
            'head_img' => '会员头像',
        ];
    }
}
