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
                'only' => ['add'],
            ]
        ];
    }

    public function actionIndex(): string
    {
        if (Yii::$app->user->isGuest) {
            //TODO: get cart items from session
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
            //TODO: work with session
            return ['success' => 0, 'msg' => 'user is guest'];
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
}