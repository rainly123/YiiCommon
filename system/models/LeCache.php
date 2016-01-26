<?php

namespace system\models;

use Yii;

/**
 * This is the model class for table "{{%cache}}".
 *
 * @property string $id
 * @property string $key
 * @property string $type
 * @property integer $marks
 * @property string $create_time
 * @property string $update_time
 */
class LeCache extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cache}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'type', 'marks', 'create_time', 'update_time'], 'required'],
            [['marks', 'create_time', 'update_time'], 'integer'],
            [['key', 'type'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => '缓存的key',
            'type' => '缓存类型：file，memcache',
            'marks' => '删除标识',
            'create_time' => '创建时间',
            'update_time' => '最后更新时间',
        ];
    }
}
