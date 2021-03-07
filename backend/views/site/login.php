<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
?>
<div class="row justify-content-center">

    <div class="col-lg-6 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <?php $form = ActiveForm::begin(['options' => ['class' => 'user']]) ?>
                            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Enter username...', 'class' => 'form-control form-control-user'])->label(false) ?>
                            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'class' => 'form-control form-control-user'])->label(false) ?>
                            <?= $form->field($model, 'rememberMe', [
                                'labelOptions' => ['class' => 'custom-control-label control-label'],
                                'template' => "<div class='custom-control custom-checkbox small'>{input}\n{label}\n{hint}\n{error}</div>"
                            ])->checkbox(['class' => 'custom-control-input'], false) ?>
                            <div class="form-group">
                                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-user btn-block', 'name' => 'login-button']) ?>
                            </div>
                            <?php ActiveForm::end() ?>
                            <hr>


                            <div class="text-center">
                                <?= Html::a('Forgot Password?', 'forgot-password.html', ['class' => 'small']) ?>
                            </div>
                            <div class="text-center">
                                <?= Html::a('Create an Account!', 'register.html', ['class' => 'small']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
