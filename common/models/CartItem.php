<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%cart_item}}".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int $quantity
 * @property int|null $created_by
 *
 * @property User $createdBy
 * @property Product $product
 */
class CartItem extends \yii\db\ActiveRecord
{
    private $_sum;
    private $_quantitySum;
    const SESSION_KEY = 'CART_ITEMS';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cart_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity', 'created_by'], 'integer'],
            [['quantity'], 'required'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CartItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CartItemQuery(get_called_class());
    }

    public function setSum($sum)
    {
        $this->_sum = (int)$sum;
    }

    public function getSum(): string
    {
        return Yii::$app->formatter->asCurrencyWithDivision($this->_sum);
    }
    public function setQuantitySum($quantitySum)
    {
        $this->_quantitySum = (int)$quantitySum;
    }
    public function getQuantitySum(): int
    {
        return $this->_quantitySum;
    }

    /**
     * Returns sum of quantity of all items in cart.
     * main layout navbar:
     * `Cart [[cartItemsQuantitySum]]`
     * @return mixed
     */
    public static function getCartItemsQuantitySum()
    {
        if(!Yii::$app->user->isGuest){
            return self::find()->quantitySum()->userId(Yii::$app->user->id)->scalar();
        }

        $cartItems = Yii::$app->session->get(self::SESSION_KEY, []);
        if(!$cartItems){
            return '';
        }

        $quantity = 0;
        foreach ($cartItems as $item){
            $quantity += $item['quantity'];
        }
        return $quantity;
    }
}
