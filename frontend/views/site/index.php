<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Rgb;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<?= $this->render('_search', ['model' => $searchModel]) ?>

<?php

foreach ($model as $address) {
    $location = $address->location;
    $name = $address->name;
    $rgbFill = 'rgb('.$address->rgb->red.','.$address->rgb->green.','.$address->rgb->blue.')';
    $id = $address->rgb->red.$address->rgb->green.$address->rgb->blue.'_'.$address->id;

    $script .= '
        var marker_'.$id.' = new google.maps.Marker({
            position: '.$location.',
            map: map,
            title: "'.$name.'",
            icon: {
                path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
                scale: 5,
                strokeColor: "rgb(0,0,0)",
                fillColor: "'.$rgbFill.'",
                fillOpacity: 1,
                strokeWeight: 2
            },
        });
    ';
}
?>
    <div class="site-index">

        <div id="map" style="height: 500px;"></div>

    </div>

<?php
$this->registerJs("
    var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 48.8712884, lng: 31.701808},
                zoom: 6
            });

            ".$script."
        }
",$this::POS_HEAD,'map_cosnfig');

$this->registerJsFile("https://maps.googleapis.com/maps/api/js?key=AIzaSyB7eA3yECkEYy5CsHazzQQJEsApE67DQDE&callback=initMap",[ 'position' => $this::POS_END],'mapsAPI');

?>