<?php

namespace system\models;

use Yii;

/**
 * This is the model class for table "{{%action_log}}".
 *
 * @property string $id
 * @property string $action_id
 * @property string $user_id
 * @property string $action_ip
 * @property string $model
 * @property string $record_id
 * @property string $remark
 * @property integer $status
 * @property string $create_time
 */
class LeActionLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%action_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_id', 'user_id', 'action_ip', 'record_id', 'status', 'create_time'], 'integer'],
            [['action_ip'], 'required'],
            [['model'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'action_id' => '行为id',
            'user_id' => '执行用户id',
            'action_ip' => '执行行为者ip',
            'model' => '触发行为的表',
            'record_id' => '触发行为的数据id',
            'remark' => '日志备注',
            'status' => '状态',
            'create_time' => '执行行为的时间',
        ];
    }
}
