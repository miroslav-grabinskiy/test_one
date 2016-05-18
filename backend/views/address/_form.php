<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Address */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('/backend/web/js/main.js');
?>

<div class="address-form col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($address, 'name')->textInput([
        'maxlength' => true,
        'onBlur' => "setGoogleGeocode($(this), '#address-location')"
    ]) ?>

    <?= $form->beginField($rgb,'group') ?>

        <?= $form->field($rgb, 'red')->textInput(['type' => 'number']) ?>

        <?= $form->field($rgb, 'green')->textInput(['type' => 'number']) ?>

        <?= $form->field($rgb, 'blue')->textInput(['type' => 'number']) ?>

    <?= $form->endField() ?>

    <div class="form-group">
        <?= Html::submitButton($address->isNewRecord ? 'Create' : 'Update', ['class' => $address->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= HTML::activeHiddenInput($address,'location') ?>

    <?php ActiveForm::end(); ?>

</div>