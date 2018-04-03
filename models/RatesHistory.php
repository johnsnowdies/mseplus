<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rates_history".
 *
 * @property int $id
 * @property int $fk_source_currency
 * @property int $fk_target_currency
 * @property double $exchange_rate
 * @property int $tick
 *
 * @property Currencies $fkSourceCurrency
 * @property Currencies $fkTargetCurrency
 */
class RatesHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rates_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_source_currency', 'fk_target_currency', 'exchange_rate','tick'], 'required'],
            [['fk_source_currency', 'fk_target_currency', 'tick'], 'integer'],
            [['exchange_rate'], 'number'],
            [['fk_source_currency'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::className(), 'targetAttribute' => ['fk_source_currency' => 'id']],
            [['fk_target_currency'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::className(), 'targetAttribute' => ['fk_target_currency' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_source_currency' => 'Fk Source Currency',
            'fk_target_currency' => 'Fk Target Currency',
            'exchange_rate' => 'Exchange Rate',
            'tick' => 'Tick',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkSourceCurrency()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'fk_source_currency']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkTargetCurrency()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'fk_target_currency']);
    }

    // В одном source RESULT target
    public function getRateBetween($sourceCurrencyId, $targetCurrencyId,$tick){
        $uuToSourceRate = self::find()->where(['fk_source_currency' => Rates::UNIVERSAL_UNIT, 'fk_target_currency' => $sourceCurrencyId, 'tick' => $tick ])->one();
        $uuToTargetRate = self::find()->where(['fk_source_currency' => Rates::UNIVERSAL_UNIT, 'fk_target_currency' => $targetCurrencyId , 'tick' => $tick])->one();

        if (!$uuToSourceRate || !$uuToTargetRate){
            return 0;
        }

        $rate = $uuToTargetRate->exchange_rate / $uuToSourceRate->exchange_rate;
        return $rate;
    }


    public function getSystemRatesForTick($tick){
        $currencies = Currencies::find()->all();

        $result = [];

        foreach($currencies as $source){
            foreach($currencies as $target){
                if ($source->id != $target->id){
                    $rate = $this->getRateBetween($source->id,$target->id,$tick);
                    $result[$source->currency_short_name][$target->currency_short_name] = $rate;
                }
            }
        }

        return $result;
    }

    public function getLastTicksHistory(){
        $lastTickSettings = Settings::findOne(['key' => 'lastTick']);
        $tick = $lastTickSettings->value;
        $result = [];
        for($i = ($tick - 10); $i <= $tick; $i++){
            $result[] = $this->getSystemRatesForTick($i);
        }

        return $result;
    }


}
