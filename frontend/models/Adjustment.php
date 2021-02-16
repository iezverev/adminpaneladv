<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "adjustment".
 *
 * @property int $id
 * @property int $adjustment
 */
class Adjustment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adjustment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adjustment'], 'required'],
            [['adjustment'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adjustment' => 'Adjustment',
        ];
    }
}
