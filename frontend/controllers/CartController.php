<?php


namespace frontend\controllers;


use common\models\CartItem;
use common\models\Product;
use Yii;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends \yii\web\Controller
{
    public function behaviors(): array
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
                'only' => ['add', 'delete', 'change-quantity'],
            ]
        ];
    }

    public function actionIndex(): string
    {
        if (Yii::$app->user->isGuest) {
            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);
        } else {
            $cartItems = CartItem::find()
                ->alias('c')
                ->select(
                    'c.product_id,
                    p.name,
                    p.image,
                    p.price,
                    c.quantity,
                    c.`quantity`*p.`price` as `sum`'
                )
                ->joinWith('product p')
                ->userId(Yii::$app->user->id, 'c')
                ->asArray()
                ->all();
        }
        return $this->render('index', compact('cartItems'));
    }

    public function actionAdd(): array
    {
        $id = Yii::$app->request->post('id');

        $product = Product::find()->id($id)->published()->one();
        if (!$product) {
            throw new NotFoundHttpException('There is no product with such id');
        }

        if (Yii::$app->user->isGuest) {
            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);
            $existingProduct = array_filter($cartItems, function ($val) use ($id) {
                return $val['product_id'] === (int)$id;
            });
            if (!$cartItems || !$existingProduct) {
                $cartItems[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'price' => $product->price,
                    'quantity' => 1,
                    'sum' => $product->price
                ];
            } else {
                $existingProductArr = $cartItems[array_key_first($existingProduct)];

                $existingProductArr['quantity'] = $existingProductArr['quantity'] + 1;
                $existingProductArr['sum'] += $existingProductArr['price'];
            }
            Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
            return Yii::$app->session->get(CartItem::SESSION_KEY, []);
        } else {
            $cartItem = CartItem::find()->productId($id)->one();
            if ($cartItem) {
                $cartItem->quantity += 1;
            } else {
                $cartItem = new CartItem();
                $cartItem->quantity = 1;
                $cartItem->product_id = $product->id;
                $cartItem->created_by = Yii::$app->user->id;
            }
            if ($cartItem->save()) {
                return ['success' => 1];
            } else {
                return ['success' => 0, 'errors' => $cartItem->errors];
            }
        }
    }

    public function actionDelete(): Response
    {
        $id = Yii::$app->request->post('id');
        if (!Yii::$app->user->isGuest) {
            $cartItem = CartItem::find()->productId($id)->one();
            $cartItem->delete();
        } else {
            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);
            $cartItems = array_filter($cartItems, function ($item, $prod_id) use ($id) {
                return $prod_id !== (int)$id;
            }, ARRAY_FILTER_USE_BOTH);

            Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
        }
        return $this->redirect(['cart/index']);
    }

    public function actionChangeQuantity()
    {
        $id = Yii::$app->request->post('id');
        $quantity = Yii::$app->request->post('quantity');

        if (!Yii::$app->user->isGuest) {
            $cartItem = CartItem::find()->productId($id)->one();
            $cartItem->quantity = $quantity;
            $sum = Yii::$app->formatter->asCurrency(
                $cartItem->quantity
                * Yii::$app->formatter->asPriceWithDivision($cartItem->product->price)
            );
            if ($cartItem->save()) {
                return ['totalPrice' => $sum, 'cartQuantity' => \common\models\CartItem::getCartItemsQuantitySum()];
            }
        } else {
            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);
            $existingItem = array_filter($cartItems, function ($item) use ($id) {
                return $item['product_id'] === (int)$id;
            });
            $keyOfExistingItem = array_key_first($existingItem);

            if (isset($existingItem[$keyOfExistingItem])) {
                $item = $existingItem[$keyOfExistingItem];
                $item['quantity'] = $quantity;

                $sum = Yii::$app->formatter->asCurrency(
                    $item['quantity']
                    * Yii::$app->formatter->asPriceWithDivision($item['price'])
                );
                $cartItems[$keyOfExistingItem] = $item;
                Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
                
                return [
                    'totalPrice' => $sum,
                    'cartQuantity' => \common\models\CartItem::getCartItemsQuantitySum()
                ];
            }

        }
    }
}