<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\CartItem]].
 *
 * @see \common\models\CartItem
 */
class CartItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\CartItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\CartItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Get all cart items with the corresponding id
     * @param $id
     * @param string $alias column alias if needed $alias.created_by for example
     * @return CartItemQuery
     */
    public function userId($id, $alias = ''): CartItemQuery
    {
        return $alias
            ? $this->andWhere(["$alias.created_by" => $id])
            : $this->andWhere(["created_by" => $id]);
    }

    public function productId($id): CartItemQuery
    {
        return $this->andWhere(['product_id' => $id]);
    }

    public function quantitySum(): CartItemQuery
    {
        return $this->select('SUM(`quantity`) as `quantitySum`');
    }
}
