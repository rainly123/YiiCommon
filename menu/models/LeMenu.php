<?php

namespace menu\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property string $id
 * @property string $title
 * @property string $pid
 * @property string $sort
 * @property string $url
 * @property integer $hide
 * @property string $tip
 * @property string $group
 * @property integer $is_dev
 */
class LeMenu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','url'], 'required','message'=>'{attribute}不能为空'],
            [['pid', 'sort', 'hide', 'is_dev'], 'integer'],
            [['title', 'group'], 'string', 'max' => 50,'tooLong'=>'{attribute}最大长度为50个字符'],
            [['url', 'tip'], 'string', 'max' => 255,'tooLong'=>'{attribute}最大长度为255个字符']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '文档ID',
            'title' => '标题',
            'pid' => '上级分类ID',
            'sort' => '排序（同级有效）',
            'url' => '链接地址',
            'hide' => '是否隐藏',
            'tip' => '提示',
            'group' => '分组',
            'is_dev' => '是否仅开发者模式可见',
        ];
    }
}
