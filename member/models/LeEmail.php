<?php

namespace member\models;

use Yii;

/**
 * This is the model class for table "{{%email}}".
 *
 * @property string $id
 * @property string $subject
 * @property string $body
 * @property integer $marks
 * @property string $create_time
 * @property string $update_time
 */
class LeEmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'body', 'create_time', 'update_time'], 'required'],
            [['marks', 'create_time', 'update_time'], 'integer'],
            [['subject'], 'string', 'max' => 50],
            [['body'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => '主题',
            'body' => '类容',
            'marks' => '删除标识0未删除，1已删除',
            'create_time' => '创建时间',
            'update_time' => '最后更新时间',
        ];
    }
}
