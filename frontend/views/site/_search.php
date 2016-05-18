<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Rgb;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model frontend\models\SearchRgb */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rgb-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'id')->dropDownList(

            ArrayHelper::map(

                Rgb::find()->all(),
                'id',
                function($data) {
                    return '('.$data->red.', '.$data->green.', '.$data->blue.')';
                }),

            [
                'class'  => 'form-control',
                'prompt' => 'Select Category',
            ]

        ); ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
