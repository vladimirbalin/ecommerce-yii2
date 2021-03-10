<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = "Product :: $model->name";
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($model->name) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php $form = \yii\bootstrap4\ActiveForm::begin(); ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:html',
            [
                'attribute' => 'imageUrl',
                'label' => 'Product Image',
                'format' => ['image', ['height' => 200]],
                'value' => function ($model) {
                    return $model->image ? $model->imageUrl : '@frontendUrl/upload/no-image-available.jpg';
                }
            ],
            'price',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) use ($form) {
                    return $form->field($model, 'status')
                            ->dropdownList($model->statusList, ['prompt' => 'All', 'class' => 'form-control'])
                            ->label(false) .
                        Html::submitButton('Save', ['class' => 'btn btn-success']);
                }],
            'created_at:datetime',
            'updated_at:datetime',
            'createdBy.username',
            'updatedBy.username',
        ],
    ]) ?>
    <?php \yii\bootstrap4\ActiveForm::end(); ?>

</div>
