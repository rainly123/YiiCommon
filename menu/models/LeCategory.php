<?php

namespace menu\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $id
 * @property string $name
 * @property string $title
 * @property string $pid
 * @property string $sort
 * @property integer $list_row
 * @property string $meta_title
 * @property string $keywords
 * @property string $description
 * @property string $template_index
 * @property string $template_lists
 * @property string $template_detail
 * @property string $template_edit
 * @property string $model
 * @property string $type
 * @property string $link_id
 * @property integer $allow_publish
 * @property integer $display
 * @property integer $reply
 * @property integer $check
 * @property string $reply_model
 * @property string $extend
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property string $icon
 * @property integer $is_admin
 */
class LeCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'required','message'=>'{attribute}不能为空'],
            [['pid', 'sort', 'list_row', 'link_id', 'allow_publish', 'display', 'reply', 'check', 'create_time', 'update_time', 'status', 'icon'], 'integer'],
            [['extend'], 'string'],
            [['name'], 'string', 'max' => 30,'tooLong'=>'{attribute}最大长度为30个字符'],
            [['title', 'meta_title'], 'string', 'max' => 50,'tooLong'=>'{attribute}最大长度为50个字符'],
            [['keywords', 'description'], 'string', 'max' => 255,'tooLong'=>'{attribute}最大长度为255个字符'],
            [['template_index', 'template_lists', 'template_detail', 'template_edit', 'model', 'type', 'reply_model'], 'string', 'max' => 100],
            [['name'], 'unique','message'=>'{attribute}名称被占用']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '分类ID',
            'name' => '标志',
            'title' => '标题',
            'pid' => '上级分类ID',
            'sort' => '排序（同级有效）',
            'list_row' => '列表每页行数',
            'meta_title' => 'SEO的网页标题',
            'keywords' => '关键字',
            'description' => '描述',
            'template_index' => '频道页模板',
            'template_lists' => '列表页模板',
            'template_detail' => '详情页模板',
            'template_edit' => '编辑页模板',
            'model' => '关联模型',
            'type' => '允许发布的内容类型',
            'link_id' => '外链',
            'allow_publish' => '是否允许发布内容',
            'display' => '可见性',
            'reply' => '是否允许回复',
            'check' => '发布的文章是否需要审核',
            'reply_model' => 'Reply Model',
            'extend' => '扩展设置',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'status' => '数据状态',
            'icon' => '分类图标',
        ];
    }
}
