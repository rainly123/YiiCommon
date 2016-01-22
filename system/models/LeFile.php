<?php

namespace system\models;

use Yii;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property string $id
 * @property string $name
 * @property string $savename
 * @property string $savepath
 * @property string $ext
 * @property string $mime
 * @property string $size
 * @property string $md5
 * @property string $sha1
 * @property integer $location
 * @property string $create_time
 */
class LeFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size', 'location', 'create_time'], 'integer'],
            [['create_time'], 'required'],
            [['name', 'savepath'], 'string', 'max' => 30],
            [['savename'], 'string', 'max' => 20],
            [['ext'], 'string', 'max' => 5],
            [['mime', 'sha1'], 'string', 'max' => 40],
            [['md5'], 'string', 'max' => 32],
            [['md5'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '文件ID',
            'name' => '原始文件名',
            'savename' => '保存名称',
            'savepath' => '文件保存路径',
            'ext' => '文件后缀',
            'mime' => '文件mime类型',
            'size' => '文件大小',
            'md5' => '文件md5',
            'sha1' => '文件 sha1编码',
            'location' => '文件保存位置',
            'create_time' => '上传时间',
        ];
    }
}
