<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int $count
 * @property string $photo
 * @property string $model
 * @property string $country
 * @property string $year
 * @property int $category_id
 *
 * @property Cart[] $carts
 * @property Category $category
 * @property OrderList[] $orderLists
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'count', 'photo', 'model', 'country', 'year', 'category_id'], 'required'],
            [['price'], 'number'],
            [['count', 'category_id'], 'integer'],
            [['year'], 'safe'],
            [['name', 'photo', 'model', 'country'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'count' => 'Count',
            'photo' => 'Photo',
            'model' => 'Model',
            'country' => 'Country',
            'year' => 'Year',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[OrderLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderLists()
    {
        return $this->hasMany(OrderList::class, ['product_id' => 'id']);
    }
}
