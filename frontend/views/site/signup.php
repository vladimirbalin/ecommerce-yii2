<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

    <div class="row">
        <div class="col-lg-5 col-sm-12 mx-auto">
            <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'firstname')->textInput(['autofocus' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'lastname')->textInput(['autofocus' => true]) ?>
                </div>
            </div>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
