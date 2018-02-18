<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "markets_delta".
 *
 * @property string $market
 * @property double $delta
 */
class MarketsDelta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'markets_delta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delta'], 'number'],
            [['market'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'market' => 'Market',
            'delta' => 'Delta',
        ];
    }
}
