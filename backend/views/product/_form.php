<?php

use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\bootstrap4\ActiveForm */
?>
<?php $registerJs = <<<JS
$("button[type='submit']").on( "click", function() {
       setTimeout(function (){
            if($('#product-image').hasClass('is-invalid')){
            $('input:hidden[name="Product[image]"]').addClass('is-invalid');
        }
       }, 1000)
});
JS;
$this->registerJs($registerJs);
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
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'price')->textInput() ?>
            <?= $form->field($model, 'image')->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false,
                ],
                'pluginOptions' => [
                    'showCaption' => false,
                    'showRemove' => true,
                    'showUpload' => false,
                    'showClose' => false,
                    'browseClass' => 'btn btn-primary',
                    'browseLabel' => 'Select Photo',
                    'initialPreview' => $model->image ? $model->imageUrl : false,
                    'initialPreviewAsData' => true,
                    'initialPreviewConfig' => $model->image ? [['caption' => $model->image]] : [],
                    'layoutTemplates' => ['actionDelete' => '', 'actionDrag' => ''],
                    'theme' => 'fa',
                ],
            ]) ?>
        </div>
    </div>
    <?= $form->field($model, 'status')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
