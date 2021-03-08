<?php

use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->widget(CKEditor::class, [
        'options' => ['rows' => 6],
        'preset' => 'custom',
        'clientOptions' => ['toolbarGroups' => [
            ['name' => 'undo'],
            ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
            ['name' => 'colors'],
            ['name' => 'others', 'groups' => ['others', 'about']],
        ]]
    ]) ?>
    <div class="col-md-3">
        <?= $form->field($model, 'image')->widget(\kartik\file\FileInput::class, [
            'options' => [
                'accept' => 'image/*',
                'multiple' => false
            ],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => true,
                'showUpload' => false,
                'showClose' => false,
                'browseClass' => 'btn btn-primary',
                'browseLabel' =>  'Select Photo',
                'initialPreview' => $model->image ? $model->imageUrl : false,
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => $model->image ? [['caption' => $model->image]] : [],
                'layoutTemplates' => ['actionDelete' => '', 'actionDrag' => '']
            ]
        ]) ?>
    </div>


    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'status')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
