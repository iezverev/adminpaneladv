<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property int $count
 * @property int $city_id
 * @property int $ed_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Packages[] $packages
 * @property Cities $city
 * @property Eds $ed
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'city_id', 'ed_id'], 'required'],
            [['count', 'city_id', 'ed_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['ed_id'], 'exist', 'skipOnError' => true, 'targetClass' => Eds::className(), 'targetAttribute' => ['ed_id' => 'id']],
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
            'count' => 'Count',
            'city_id' => 'City ID',
            'ed_id' => 'Ed ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Packages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPackages()
    {
        return $this->hasMany(Packages::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Ed]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEd()
    {
        return $this->hasOne(Eds::className(), ['id' => 'ed_id']);
    }
}
