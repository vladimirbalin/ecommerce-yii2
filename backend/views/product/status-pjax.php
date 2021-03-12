<?php

use common\widgets\Alert;
use yii\bootstrap4\ActiveForm;

/** @var $model \common\models\Product */

$form = ActiveForm::begin([
    'action' => ['/product/pjax-view', 'id' => $model->id],
    'options' => ['data-pjax' => 1],
]);
echo $form->field($model, 'status')
    ->dropdownList($model->statusList, ['prompt' => 'All', 'class' => 'form-control'])
    ->label(false);
echo '<button class="btn btn-primary">Save</button>';
echo Alert::widget();
ActiveForm::end();