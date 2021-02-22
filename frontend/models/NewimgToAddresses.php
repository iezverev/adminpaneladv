<?php

namespace app\models;

use frontend\models\ImgToAddresses;
use Yii;

/**
 * This is the model class for table "newimg_to_addresses".
 *
 * @property int $id
 * @property int $address_id
 * @property string $img
 */
class NewimgToAddresses extends \yii\db\ActiveRecord
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
        ];
    }

    public function UploadMulti($address_id, $package_id)
    {
        foreach ($this->img as $picture) {
            if ($picture != null) {
                $image = new ImgToAddresses();
                //$picture->saveAs('uploads/' . $picture->basename .'id'. $address_id .  '.' . $picture->extension);
                $blob = file_get_contents($picture->tempName);
                $image->img = $blob;

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
}
