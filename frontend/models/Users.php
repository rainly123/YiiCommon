<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $ID
 * @property string $UserName
 * @property string $UserPass
 * @property integer $UserSex
 * @property integer $Marks
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['UserName', 'UserPass'], 'required'],
            [['UserSex', 'Marks'], 'integer'],
            [['UserName', 'UserPass'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'UserName' => Yii::t('app', 'User Name'),
            'UserPass' => Yii::t('app', 'User Pass'),
            'UserSex' => Yii::t('app', 'User Sex'),
            'Marks' => Yii::t('app', 'Marks'),
        ];
    }
}
