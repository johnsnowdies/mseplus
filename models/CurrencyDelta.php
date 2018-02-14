<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currency_delta".
 *
 * @property string $currency
 * @property double $delta
 */
class CurrencyDelta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency_delta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delta'], 'number'],
            [['currency'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'currency' => 'Currency',
            'delta' => 'Delta',
        ];
    }
}
