<?php

namespace system\models;

use Yii;

/**
 * This is the model class for table "{{%action}}".
 *
 * @property string $id
 * @property string $name
 * @property string $title
 * @property string $remark
 * @property string $rule
 * @property string $log
 * @property integer $type
 * @property integer $status
 * @property string $update_time
 */
class LeAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%action}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rule', 'log'], 'required','message'=>'{attribute}不能为空'],
            [['rule', 'log'], 'string'],
            [['type', 'status', 'update_time'], 'integer'],
            [['name'], 'string', 'max' => 30,'tooLong'=>'{attribute}最大字符数为30'],
            [['title'], 'string', 'max' => 80,'tooLong'=>'{attribute}最大字符数为80'],
            [['remark'], 'string', 'max' => 140,'tooLong'=>'{attribute}最大字符数为140']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'name' => '行为唯一标识',
            'title' => '行为说明',
            'remark' => '行为描述',
            'rule' => '行为规则',
            'log' => '日志规则',
            'type' => '类型',
            'status' => '状态',
            'update_time' => '修改时间',
        ];
    }
}
