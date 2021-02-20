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
            [['img'], 'file', 'extensions' => 'jpg, png', 'maxFiles' => 10, 'skipOnEmpty' => true],
            [['address_id'  ], 'integer'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addresses::className(), 'targetAttribute' => ['address_id' => 'id']],
        ];
    }


    public function UploadMulti($address_id, $package_id)
    {
        foreach ($this->img as $picture) {
            if ($picture != null) {
                $image = new ImgToAddresses();
                $picture->saveAs('uploads/' . $picture->basename . '.' . $picture->extension);
                $image->img = 'https://itssecrethui.herokuapp.com/uploads/' . $picture->basename .'id'. $address_id . '.' . $picture->extension;
                $image->address_id = $address_id;
                $image->save();
            } else {
                $picture->img = 'none';
                return $this->redirect('addresses?package_id='.$package_id);
            }
        }
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
