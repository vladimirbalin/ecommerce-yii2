<?php
/**
 * @var $cartItems array
 */

use yii\helpers\Html;

?>
<div class="card">
    <?php if ($cartItems): ?>
    <div class="card-header text-center">
        <h3>Your cart items</h3>
    </div>

    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Product name</th>
                <th>Product Image</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cartItems as $cartItem): ?>
                <?php $unitPrice = Yii::$app->formatter->asPriceWithDivision($cartItem['price']) ?>
                <?php $unitPriceLabel = Yii::$app->formatter->asCurrencyWithDivision($cartItem['price']) ?>
                <?php $totalPrice = Yii::$app->formatter->asCurrencyWithDivision($cartItem['sum']) ?>
            
                <?php $img = $cartItem['image']
                    ? Html::img('@frontendUrl/upload/product/' . $cartItem['product_id'] . "/" . $cartItem['image'], ['height' => 100, 'weight' => 100])
                    : Html::img('@frontendUrl/img/no-image.png', ['height' => 100, 'weight' => 100]);
                ?>
                <tr data-key="<?= $cartItem['product_id'] ?>" data-unit-price="<?= $unitPrice ?>">
                    <td><?= $cartItem['product_id']; ?></td>
                    <td><?= $cartItem['name']; ?></td>
                    <td><?= $img ?></td>
                    <td><?= $unitPriceLabel; ?></td>
                    <td><?= Html::button('-', ['class' => 'decrease-btn']) ?>

                        <?= Html::input('number', 'quantity', $cartItem['quantity'], [
                            'style' => 'width:40px', 'min' => 1,'max' => 1000, 'class' => 'input-prod-quantity']) ?>

                        <?= Html::button('+', ['class' => 'increase-btn']) ?></td>
                    <td><?= $totalPrice; ?></td>
                    <td><?= Html::a('Delete',
                            ['cart/delete'],
                            [
                                'class' => 'btn btn-outline-danger btn-sm delete-from-cart-btn',
                                'data-key' => $cartItem['product_id'],
                            ]
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="card-body float-right">
            <?= Html::a('Checkout', ['cart/checkout'], ['class' => 'btn btn-primary']) ?>
        </div>
        <?php else: ?>
            <div class="card-header">
                <div>
                    <h3>В вашей корзине пока ничего нет</h3>
                    <div>Корзина ждет, что ее наполнят. Желаем приятных покупок!</div>
                </div>
            </div>
        <?php endif; ?>
    </div>


</div>
