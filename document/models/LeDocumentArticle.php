<?php

namespace document\models;

use Yii;

/**
 * This is the model class for table "{{%document_article}}".
 *
 * @property string $id
 * @property integer $parse
 * @property string $content
 * @property string $template
 * @property string $bookmark
 */
class LeDocumentArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%document_article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'content'], 'required','message'=>'{attribute}不能为空'],
            [['id'], 'integer'],
            [['content'], 'string'],
            [['template'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '文档ID',
            'parse' => '内容解析类型',
            'content' => '文章内容',
            'template' => '详情页显示模板',
            'bookmark' => '收藏数',
        ];
    }
}
