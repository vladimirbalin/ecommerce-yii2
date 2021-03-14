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
                    <div class="card" style="height:500px">
                        <a href="#" style="display:contents">
                            <?= Html::img($product->imageUrl, [
                                'class' => 'card-img-top',
                                'alt' => $product->name,
                                'style' => 'object-fit:contain;max-height:50%'
                            ]) ?>
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
                                <?= Html::a(
                                    'Add to cart',
                                    ['cart/add'],
                                    ['class' => 'btn btn-danger float-right add-to-cart-btn',
                                        'data-key' => $product->id]
                                ) ?>
                            </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </div>
</div>
