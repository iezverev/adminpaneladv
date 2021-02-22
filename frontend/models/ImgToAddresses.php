<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "img_to_addresses".
 *
 * @property int $id
 * @property int $address_id
 * @property string $img
 *
 * @property Addresses $address
 */
class ImgToAddresses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'newimg_to_addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address_id', 'img'], 'required'],
            [['address_id'], 'integer'],
            [['img'], 'string'],
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
