<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Cart extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%cart}}";
    }

    public function rules()
    {
        return [
            [['productId','productnum','userId','price'], 'required'],
            ['createtime', 'safe']
        ];
    }


}
