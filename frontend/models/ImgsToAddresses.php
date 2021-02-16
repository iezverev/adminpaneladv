<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "img_to_adresses".
 *
 * @property int $id
 * @property int $address_id
 * @property int $img
 *
 * @property Addresses $address
 */
class ImgsToAddresses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'img_to_addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'img'], 'required'],
            [['img'], 'file', 'extensions' => 'jpg, png', 'maxFiles' => 10, 'skipOnEmpty' => false],
            [['address_id'  ], 'integer'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addresses::className(), 'targetAttribute' => ['address_id' => 'id']],
        ];
    }




    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address_id' => 'Address ID',
            'img' => 'Img',
        ];
    }

    /**
     * Gets query for [[Address]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Addresses::className(), ['id' => 'address_id']);
    }
}
