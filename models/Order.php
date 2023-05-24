<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_user".
 *
 * @property int $id
 * @property string $date
 * @property string|null $rejection_reason
 * @property int $user_id
 * @property int $order_status_id
 *
 * @property OrderList[] $orderLists
 * @property OrderStatus $orderStatus
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['user_id'], 'required'],
            [['user_id', 'order_status_id'], 'integer'],
            [['rejection_reason'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['order_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::class, 'targetAttribute' => ['order_status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'rejection_reason' => 'Rejection Reason',
            'user_id' => 'User ID',
            'order_status_id' => 'Order Status ID',
        ];
    }

    /**
     * Gets query for [[OrderLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderLists()
    {
        return $this->hasMany(OrderList::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[OrderStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::class, ['id' => 'order_status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
