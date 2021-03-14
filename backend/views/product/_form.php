<?php

use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\bootstrap4\ActiveForm */
?>
<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
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
            <?= $form->field($model, 'price')->textInput()->label('Price: as integer') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'image',
                ['errorOptions' => ['style' => 'display:block;']])
                ->widget(FileInput::class, [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'showClose' => false,
                        'showCancel' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseLabel' => 'Select Photo',
                        'initialPreview' => $model->image ? $model->imageUrl : false,
                        'initialPreviewAsData' => true,
                        'initialPreviewConfig' => $model->image ? [['caption' => $model->image]] : [],
                        'layoutTemplates' => ['actionDelete' => '', 'actionDrag' => '']
                    ]
                ]) ?>
        </div>
    </div>
    <?= $form->field($model, 'status')->radioList(['Not Published', 'Published']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
