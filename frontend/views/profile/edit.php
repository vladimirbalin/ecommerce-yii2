<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model common\models\User */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Edit Profile';
?>
<div class="site-signup mt-3">
    <div class="row">
        <div class="col-lg-6 col-sm-12 mx-auto">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Please fill out the following fields to sign up:</p>
            <?php $form = ActiveForm::begin([
                'class' => 'mx-auto',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{error}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-lg-3 col-sm-12',
                        'wrapper' => 'col-lg-9 col-sm-12'
                    ],
                ],
            ]); ?>

            <?= $form->field($model, 'login')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'firstname')->textInput() ?>
            <?= $form->field($model, 'lastname')->textInput() ?>
            <?= $form->field($model, 'address')->textInput() ?>
            <?= $form->field($model, 'city')->textInput() ?>
            <?= $form->field($model, 'state')->textInput() ?>
            <?= $form->field($model, 'country')->textInput() ?>
            <?= $form->field($model, 'zipcode')->textInput() ?>

            <div class="form-group">
                <div class="col p-0">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary w-100 m-0']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>