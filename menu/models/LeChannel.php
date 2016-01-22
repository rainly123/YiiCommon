<?php

namespace menu\models;

use Yii;

/**
 * This is the model class for table "{{%channel}}".
 *
 * @property string $id
 * @property string $pid
 * @property string $title
 * @property string $url
 * @property string $sort
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property integer $marks
 * @property integer $target
 */
class LeChannel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%channel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'sort', 'create_time', 'update_time', 'status', 'marks', 'target'], 'integer'],
            [['title', 'url'], 'required','message'=>'{attribute}不能为空'],
            [['title'], 'string', 'max' => 30,'tooLong'=>'{attribute}最大长度为30个字符'],
            [['url'], 'string', 'max' => 100,'tooLong'=>'{attribute}最大长度为100个字符']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '频道ID',
            'pid' => '上级频道ID',
            'title' => '频道标题',
            'url' => '频道连接',
            'sort' => '导航排序',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'status' => '状态',
            'marks' => '删除标志',
            'target' => '新窗口打开',
        ];
    }
}
