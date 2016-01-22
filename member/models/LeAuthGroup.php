<?php

namespace member\models;

use Yii;

/**
 * This is the model class for table "{{%auth_group}}".
 *
 * @property string $id
 * @property string $module
 * @property integer $type
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property string $rules
 */
class LeAuthGroup extends \yii\db\ActiveRecord
{
    const TYPE_ADMIN                = 1;                   // 管理员用户组类型标识
    const MEMBER                    = 'member';
    const UCENTER_MEMBER            = 'ucenter_member';
    const AUTH_GROUP_ACCESS         = 'auth_group_access'; // 关系表表名
    const AUTH_EXTEND               = 'auth_extend';       // 动态权限扩展信息表
    const AUTH_GROUP                = 'auth_group';        // 用户组表名
    const AUTH_EXTEND_CATEGORY_TYPE = 1;              // 分类权限标识
    const AUTH_EXTEND_MODEL_TYPE    = 2; //分类权限标识
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module', 'type'], 'required'],
            [['type', 'status'], 'integer'],
            [['module', 'title'], 'string', 'max' => 20,'tooLong'=>'组名最大长度为80个字符'],
            [['description'], 'string', 'max' => 80,'tooLong'=>'描述最大长度为80个字符'],
            [['rules'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户组id,自增主键',
            'module' => '用户组所属模块',
            'type' => '组类型',
            'title' => '用户组中文名称',
            'description' => '描述信息',
            'status' => '用户组状态：为1正常，为0禁用,-1为删除',
            'rules' => '用户组拥有的规则id，多个规则 , 隔开',
        ];
    }
}
