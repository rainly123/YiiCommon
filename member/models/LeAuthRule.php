<?php

namespace member\models;

use Yii;

/**
 * This is the model class for table "{{%auth_rule}}".
 *
 * @property string $id
 * @property string $module
 * @property integer $type
 * @property string $name
 * @property string $title
 * @property integer $status
 * @property string $condition
 */
class LeAuthRule extends \yii\db\ActiveRecord
{
    const RULE_URL = 1;
    const RULE_MAIN = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module'], 'required'],
            [['type', 'status'], 'integer'],
            [['module', 'title'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 80],
            [['condition'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '规则id,自增主键',
            'module' => '规则所属module',
            'type' => '1-url;2-主菜单',
            'name' => '规则唯一英文标识',
            'title' => '规则中文描述',
            'status' => '是否有效(0:无效,1:有效)',
            'condition' => '规则附加条件',
        ];
    }
}
