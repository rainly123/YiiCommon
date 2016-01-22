<?php

namespace system\models;

use Yii;

/**
 * This is the model class for table "{{%picture}}".
 *
 * @property string $id
 * @property string $path
 * @property string $url
 * @property string $md5
 * @property string $sha1
 * @property string $type
 * @property string $title
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $marks
 */
class LePicture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%picture}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'create_time', 'update_time', 'marks'], 'integer'],
            [['path', 'url'], 'string', 'max' => 255],
            [['md5'], 'string', 'max' => 32],
            [['sha1'], 'string', 'max' => 40],
            [['title'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键id自增',
            'path' => '路径',
            'url' => '图片链接',
            'md5' => '文件md5',
            'sha1' => '文件 sha1编码',
            'type' => '图片类型',
            'title' => '图片标题',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '最后更新时间',
            'marks' => '是否删除',
        ];
    }
}
