<?php

namespace system\models;

use Yii;

/**
 * This is the model class for table "{{%picture_type}}".
 *
 * @property string $id
 * @property string $type_name
 * @property string $type_title
 * @property string $sort
 * @property string $create_time
 * @property string $update_time
 * @property integer $marks
 */
class LePictureType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%picture_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'create_time', 'update_time', 'marks'], 'integer'],
            [['type_name', 'type_title',], 'required','message'=>'{attribute}不能为空'],
            [['type_name'], 'string', 'max' => 30],
            [['type_title'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '表主键',
            'type_name' => '类型名称',
            'type_title' => '标题',
            'sort' => '排序',
            'create_time' => '创建时间',
            'update_time' => '最后更新时间',
            'marks' => '删除标识',
        ];
    }
}
