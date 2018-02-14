<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "currencies".
 *
 * @property int $id
 * @property string $country
 * @property string $currency
 * @property string $currency_short_name
 *
 * @property Markets[] $markets
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 */
class Currencies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currencies';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function getCurrencyArray(){
        $currencies = self::find()->all();

        $arCurrency = [];
        foreach ($currencies as $currency){
            $arCurrency[$currency->id] = $currency->currency_short_name;
        }

        return $arCurrency;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country', 'currency','currency_short_name'], 'required'],
            [['country', 'currency'], 'string', 'max' => 255],
            [['currency_short_name'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Государство',
            'currency' => 'Валюта',
            'currency_short_name' => 'Индекс',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarkets()
    {
        return $this->hasMany(Markets::className(), ['fk_currency' => 'id']);
    }
}
