<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rgb".
 *
 * @property integer $id
 * @property integer $red
 * @property integer $green
 * @property integer $blue
 *
 * @property Address[] $addresses
 */
class Rgb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rgb';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['red', 'green', 'blue'], 'required'],
            [['red', 'green', 'blue'], 'integer', 'min' => 0, 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'red' => 'Red',
            'green' => 'Green',
            'blue' => 'Blue',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['rgb_id' => 'id']);
    }
}
