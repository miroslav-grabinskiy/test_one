<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property string $location
 * @property integer $rgb_id
 * @property string $created_at
 *
 * @property Rgb $rgb
 */
class Address extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'location', 'rgb_id'], 'required'],
            [['rgb_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'location'], 'string', 'max' => 255],
            [['rgb_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rgb::className(), 'targetAttribute' => ['rgb_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Address',
            'location' => 'Location',
            'rgb_id' => 'Rgb ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRgb()
    {
        return $this->hasOne(Rgb::className(), ['id' => 'rgb_id']);
    }

    static public function createCSV()
    {
        $addresses = Address::find()->all();
        $output = '';
        foreach ($addresses as $address) {
            $output .= $address->name.';'.$address->location.';'.$address->rgb->red.','.$address->rgb->green.','.$address->rgb->blue.';'.$address->created_at."\n";
        }
        return $output;
    }

}
