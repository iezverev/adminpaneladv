<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tg_config".
 *
 * @property int $id
 * @property string $bot_token
 * @property string|null $xmr_address
 */
class TgConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tg_config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bot_token'], 'required'],
            [['bot_token', 'xmr_address'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bot_token' => 'Bot Token',
            'xmr_address' => 'Xmr Address',
        ];
    }
}
