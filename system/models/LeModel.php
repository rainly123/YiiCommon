<?php

namespace system\models;

use Yii;

/**
 * This is the model class for table "{{%model}}".
 *
 * @property string $id
 * @property string $name
 * @property string $title
 * @property string $extend
 * @property string $relation
 * @property integer $need_pk
 * @property string $field_sort
 * @property string $field_group
 * @property string $attribute_list
 * @property string $template_list
 * @property string $template_add
 * @property string $template_edit
 * @property string $list_grid
 * @property integer $list_row
 * @property string $search_key
 * @property string $search_list
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 * @property string $engine_type
 */
class LeModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%model}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extend', 'need_pk', 'list_row', 'create_time', 'update_time', 'status'], 'integer'],
            [['field_sort', 'attribute_list', 'list_grid'], 'required'],
            [['field_sort', 'attribute_list', 'list_grid'], 'string'],
            [['name', 'title', 'relation'], 'string', 'max' => 30],
            [['field_group', 'search_list'], 'string', 'max' => 255],
            [['template_list', 'template_add', 'template_edit'], 'string', 'max' => 100],
            [['search_key'], 'string', 'max' => 50],
            [['engine_type'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '模型ID',
            'name' => '模型标识',
            'title' => '模型名称',
            'extend' => '继承的模型',
            'relation' => '继承与被继承模型的关联字段',
            'need_pk' => '新建表时是否需要主键字段',
            'field_sort' => '表单字段排序',
            'field_group' => '字段分组',
            'attribute_list' => '属性列表（表的字段）',
            'template_list' => '列表模板',
            'template_add' => '新增模板',
            'template_edit' => '编辑模板',
            'list_grid' => '列表定义',
            'list_row' => '列表数据长度',
            'search_key' => '默认搜索字段',
            'search_list' => '高级搜索的字段',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'status' => '状态',
            'engine_type' => '数据库引擎',
        ];
    }
}
