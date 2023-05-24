<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $surname
 * @property string $name
 * @property string|null $patronymic
 * @property string $login
 * @property string $password
 * @property string $email
 * @property int $user_role_id
 *
 * @property Cart[] $carts
 * @property OrderUser[] $orderUsers
 * @property UserRole $userRole
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['surname', 'name', 'login', 'password', 'email'], 'required'],
            [['user_role_id'], 'integer'],
            [['surname', 'name', 'patronymic', 'login', 'password', 'email'], 'string', 'max' => 255],
            [['login'], 'unique'],
            [['email'], 'unique'],
            [['user_role_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRole::class, 'targetAttribute' => ['user_role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Surname',
            'name' => 'Name',
            'patronymic' => 'Patronymic',
            'login' => 'Login',
            'password' => 'Password',
            'email' => 'Email',
            'user_role_id' => 'User Role ID',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[OrderUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderUsers()
    {
        return $this->hasMany(OrderUser::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRole()
    {
        return $this->hasOne(UserRole::class, ['id' => 'user_role_id']);
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

        return null;
    }

    /**
     * Finds user by username
     * 
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($login)
    {
        return User::findOne(['login' => $login]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
    public function isAdmin()
    {
        return $this->userRole === "admin";
    }
}