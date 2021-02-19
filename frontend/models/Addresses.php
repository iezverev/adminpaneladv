<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property string $desc
 * @property string $status
 * @property int $package_id
 * @property int $region_id
 * @property int $leg_id
 * @property int|null $tg_id
 * @property double|null $reservation_price
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $leg
 * @property Packages $package
 * @property Regions $region
 */
class Addresses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desc', 'status', 'package_id', 'region_id', 'leg_id'], 'required'],
            [['package_id', 'region_id', 'leg_id', 'tg_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['reservation_price'], 'number'],
            [['desc',  'status'], 'string', 'max' => 255],
            [['leg_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['leg_id' => 'id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packages::className(), 'targetAttribute' => ['package_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desc' => 'Desc',
            'status' => 'Status',
            'package_id' => 'Package ID',
            'region_id' => 'Region ID',
            'leg_id' => 'Leg ID',
            'tg_id' => 'Tg ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Leg]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeg()
    {
        return $this->hasOne(User::className(), ['id' => 'leg_id']);
    }

    /**
     * Gets query for [[Package]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Packages::className(), ['id' => 'package_id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regions::className(), ['id' => 'region_id']);
    }
    public function getImgs()
    {
        return $this->hasOne(ImgsToAddresses::className(), ['address_id' => 'id']);
    }
}
