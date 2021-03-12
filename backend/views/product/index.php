<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin([]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'format' => 'html',
                'content' => function ($model) {
                    return Html::a($model->name, ['/product/view', 'id' => $model->id], ['data-pjax' => 0]);
                },
                'headerOptions' => ['style' => 'width:200px'],
            ],
            [
                'attribute' => 'imageUrl',
                'label' => 'Product Image',
                'format' => ['image', ['height' => 100, 'weight' => 100]],
            ],
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    $searchModel->statusList,
                    ['prompt' => 'All', 'class' => 'form-control']),
                'value' => function ($model) {
                    return Html::tag('span',
                        $model->status ? 'Published' : 'Not Published',
                        ['class' => $model->status ? "badge badge-success" : "badge badge-danger"]);
                },
                'format' => 'html',
                'headerOptions' => ['style' => 'width:50px'],
            ],
            ['attribute' => 'price',
                'format' => 'currency',
                'headerOptions' => ['style' => 'width:50px'],
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime'
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime'
            ],
            ['class' => 'backend\grid\ActionColumn',
                'template' => '{delete}'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
