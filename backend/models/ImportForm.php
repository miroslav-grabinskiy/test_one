<?php
/**
 * Created by PhpStorm.
 * User: m0sviatoslav
 * Date: 17.05.16
 * Time: 20:33
 */

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Address;



class ImportForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'],'required'],
            [['file'],'file','checkExtensionByMimeType' => false, 'extensions' => 'csv',]
        ];
    }

    public function attributeLabels()
    {
        return [
            'file'  => 'Import CSV File',
        ];
    }

    /**
     * Exploding a string row from csv file
     *
     * @param $data string
     *
     * @return array
     */
    public function explodeCSV($data)
    {
        $rgb_keys = ['red','green','blue'];

        $partial = explode(";", $data, 2);

        $address_data = $partial[0];

        $rgb_data = $partial[1];

        $rgb_value = explode(",", $rgb_data, 3);

        $rgbCodes = array_combine($rgb_keys,$rgb_value);

        return [
            'address' => $address_data,
            'rgb' => $rgbCodes
        ];
    }
}