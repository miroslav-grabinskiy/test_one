<?php
/**
 * Created by PhpStorm.
 * User: m0sviatoslav
 * Date: 17.05.16
 * Time: 23:06
 */

namespace common\models;


class GoogleAPI
{
    private $apiURL = 'https://maps.googleapis.com/maps/api/geocode/json';

    public $apiKey ='AIzaSyB7eA3yECkEYy5CsHazzQQJEsApE67DQDE'; //sajlkjdsadj213mk


    private $getByAddress = '?address=';

    public function getGeoCodes($address)
    {
        $addressURLed = urlencode($address);

        $requestURL = $this->apiURL . $this->getByAddress . $addressURLed;

        $resp_json = file_get_contents($requestURL);

        $resp = json_decode($resp_json, true);

        if($resp['status']=='OK'){
            $location = $resp['results'][0]['geometry']['location'];
            return json_encode($location);
        } else {
            return false;
        }
    }
}