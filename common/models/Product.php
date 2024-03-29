<?php

namespace common\models;


use mohorev\file\UploadBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image
 * @property int $price
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property CartItem[] $cartItems
 * @property OrderItem[] $orderItems
 * @property User $createdBy
 * @property User $updatedBy
 *
 * @method getUploadUrl($attribute) - Returns file url for the attribute. @see mohorev\file\UploadBehavior
 */
class Product extends \yii\db\ActiveRecord
{
    const SCENARIO_IMG_UPDATE = 'scenario-update';
    const SCENARIO_IMG_INSERT = 'scenario-insert';

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'scenarios' => [self::SCENARIO_IMG_INSERT, self::SCENARIO_IMG_UPDATE],
                'path' => '@frontend/web/upload/product/{id}',
                'url' => '@frontendUrl/upload/product/{id}',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'price', 'status'], 'required'],
            [['description'], 'string'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'price'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [
                'image', 'image', 'extensions' => 'jpg, jpeg, png, webp',
                'maxSize' => 5 * 1024 * 1024,
                'on' => [self::SCENARIO_IMG_INSERT, self::SCENARIO_IMG_UPDATE],
            ],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Product Image',
            'price' => 'Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CartItemQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\OrderItemQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find(): query\ProductQuery
    {
        return new \common\models\query\ProductQuery(get_called_class());
    }

    public function getImageUrl(): string
    {
        return $this->getUploadUrl('image') ?? '@frontendUrl/img/no-image.png';
    }

    /**
     * Get product image as [[Formatter::asImage($params)]]
     * @param array $params
     * @return string
     */
    public function getImage(array $params): string
    {
        return \Yii::$app->formatter->asImage($this->getImageUrl(), $params);
    }
    /**
     * Get array of statuses of the 'product' table
     * @return string[]
     */
    public function getStatusList(): array
    {
        return ['Not Published', 'Published'];
    }

    /**
     * Get short description of the product
     * @return string
     */
    public function getTruncatedDescription(): string
    {
        return StringHelper::truncateWords(strip_tags($this->description), 20);
    }

    /**
     * Get price as currency
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getPriceLabel(): string
    {
        return \Yii::$app->formatter->asCurrencyWithDivision($this->price);
    }
}
