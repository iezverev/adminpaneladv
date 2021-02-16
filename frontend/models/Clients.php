<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int|null $tg_id
 * @property string|null $xmr_address
 * @property int|null $xmr_id
 * @property float|null $balance
 * @property float|null $real_balance
 * @property string|null $remember_token
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['balance', 'real_balance'], 'number'],
            [['username', 'password', 'xmr_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'tg_id' => 'Tg ID',
            'xmr_address' => 'Xmr Address',
            'xmr_id' => 'Xmr ID',
            'balance' => 'Balance',
            'real_balance' => 'Real Balance',
            'remember_token' => 'Remember Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
