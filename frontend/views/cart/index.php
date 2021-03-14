<?php
/**
 * @var $cartItems array
 */

use yii\helpers\Html;

?>
<div class="card">
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
                <tr>
                    <td><?= $cartItem->product_id; ?></td>
                    <td><?= $cartItem->product->name; ?></td>
                    <td><?= $cartItem->product->getImage(['height' => 100, 'weight' => 100]); ?></td>
                    <td><?= $cartItem->product->priceLabel; ?></td>
                    <td><?= $cartItem->quantity; ?></td>
                    <td><?= $cartItem->sum; ?></td>
                    <td><?= Html::a('Delete',
                            ['cart/delete', 'id' => $cartItem->id],
                            [
                                'class' => 'btn btn-outline-danger btn-sm',
                                'data-method' => 'post',
                                'data-confirm' => 'Do you really want to delete this item?'
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

    </div>
</div>
