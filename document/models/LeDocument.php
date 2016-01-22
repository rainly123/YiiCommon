<?php

namespace document\models;

use Yii;

/**
 * This is the model class for table "{{%document}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $name
 * @property string $title
 * @property string $category_id
 * @property string $description
 * @property string $root
 * @property string $pid
 * @property integer $model_id
 * @property integer $type
 * @property integer $position
 * @property string $link_id
 * @property string $cover_id
 * @property integer $display
 * @property string $deadline
 * @property integer $attach
 * @property string $view
 * @property string $comment
 * @property string $extend
 * @property integer $level
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property integer $mark
 */
class LeDocument extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%document}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'category_id', 'pid', 'type', 'display','model_id', 'view', 'comment', 'level', 'status','cover_id','create_time','update_time'], 'integer','message'=>'{attribute}必须为数字'],
            [['category_id','title'], 'required','message'=>'{attribute}不能为空'],
            [['name'], 'string', 'max' => 40,'tooLong'=>'{attribute}最大长度为40个字符'],
            [['title'], 'string', 'max' => 80,'tooLong'=>'{attribute}最大长度为80个字符'],
            [['description'], 'string', 'max' => 200,'tooLong'=>'{attribute}最大长度为200个字符']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '文档ID',
            'uid' => '用户ID',
            'name' => '标识',
            'title' => '标题',
            'category_id' => '所属分类',
            'description' => '描述',
            'root' => '根节点',
            'pid' => '所属ID',
            'model_id' => '内容模型ID',
            'type' => '内容类型2文学，0技术',
            'position' => '推荐位',
            'link_id' => '外链',
            'cover_id' => '封面',
            'display' => '可见性',
            'deadline' => '截至时间',
            'attach' => '附件数量',
            'view' => '浏览量',
            'comment' => '评论数',
            'extend' => '扩展统计字段',
            'level' => '优先级',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'status' => '数据状态（-1-删除，0-禁用，1-正常，2-待审核）',
            'mark' => '删除标识0未删除，1已删除',
        ];
    }
}
