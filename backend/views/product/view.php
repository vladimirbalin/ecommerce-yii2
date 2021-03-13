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
<?php \yii\widgets\Pjax::begin([
    'enablePushState' => false
]) ?>
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
                ],
                'price:currency',
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $this->render('status-pjax', ['model' => $model]);
                    }],
                'created_at:datetime',
                'updated_at:datetime',
                'createdBy.username',
                'updatedBy.username',
            ],
        ]) ?>

    </div>
<?php \yii\widgets\Pjax::end() ?>