<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Address */

$this->title = 'Create Address';
$this->params['breadcrumbs'][] = ['label' => 'Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'address' => $address,
        'rgb' => $rgb
    ]) ?>

</div>
