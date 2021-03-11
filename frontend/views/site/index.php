<?php

/* @var $this yii\web\View
 * @var $model Product
 * @var $pages Pagination
 */

use common\models\Product;
use yii\bootstrap4\LinkPager;
use yii\data\Pagination;
use yii\helpers\Html;

$this->title = Yii::$app->name;
?>
<div class="site-index">
    <div class="body-content">
        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
        <div class="row">
            <?php foreach ($model as $product): ?>
                <?php /** @var Product $product */ ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="#">
                            <?= Html::img($product->imageUrl, ['class' => 'card-img-top', 'alt' => $product->name]) ?>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="#"><?= $product->name ?></a>
                                </h4>
                                <h5><?= $product->priceLabel ?></h5>
                                <div class="card-text">
                                    <?= $product->truncatedDescription ?>
                                </div>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                            </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </div>
</div>
