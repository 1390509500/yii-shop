<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property string $id
 * @property string $sex
 * @property string $year
 * @property string $nickname
 * @property string $city
 * @property string $province
 * @property string $userId
 * @property integer $createtime
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'createtime'], 'integer'],
            [['sex'], 'string', 'max' => 3],
            [['year', 'city', 'province'], 'string', 'max' => 10],
            [['nickname'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sex' => 'Sex',
            'year' => 'Year',
            'nickname' => 'Nickname',
            'city' => 'City',
            'province' => 'Province',
            'userId' => 'User ID',
            'createtime' => 'Createtime',
        ];
    }
}