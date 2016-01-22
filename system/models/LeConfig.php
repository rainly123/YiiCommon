<?php

namespace system\models;

use Yii;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $type
 * @property string $title
 * @property integer $group
 * @property string $extra
 * @property string $remark
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property string $value
 * @property integer $sort
 */
class LeConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'group', 'create_time', 'update_time', 'status', 'sort'], 'integer'],
            [['value'], 'required','message'=>'{attribute}不能为空'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 30,'tooLong'=>'{attribute}最大长度为30个字符'],
            [['title'], 'string', 'max' => 50,'tooLong'=>'{attribute}最大长度为50个字符'],
            [['extra'], 'string', 'max' => 255,'tooLong'=>'{attribute}最大长度为255个字符'],
            [['remark'], 'string', 'max' => 100,'tooLong'=>'{attribute}最大长度为100个字符'],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '配置ID',
            'name' => '配置名称',
            'type' => '配置类型',
            'title' => '配置说明',
            'group' => '配置分组',
            'extra' => '配置值',
            'remark' => '配置说明',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'status' => '状态',
            'value' => '配置值',
            'sort' => '排序',
        ];
    }
}
