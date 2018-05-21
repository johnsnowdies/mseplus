<?php

namespace app\models;

use Yii;
use app\models\Currencies;
use app\models\CurrencyDelta;

/**
 * This is the model class for table "rates".
 *
 * @property int $id
 * @property int $fk_source_currency
 * @property int $fk_target_currency
 * @property double $exchange_rate
 *
 * @property Currencies $fkSourceCurrency
 * @property Currencies $fkTargetCurrency
 */
class Rates extends \yii\db\ActiveRecord
{
    const UNIVERSAL_UNIT = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_source_currency', 'fk_target_currency', 'exchange_rate'], 'required'],
            [['fk_source_currency', 'fk_target_currency'], 'integer'],
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
    public function getRateBetween($sourceCurrencyId, $targetCurrencyId){
        $uuToSourceRate = self::find()->where(['fk_source_currency' => Rates::UNIVERSAL_UNIT, 'fk_target_currency' => $sourceCurrencyId ])->one();
        $uuToTargetRate = self::find()->where(['fk_source_currency' => Rates::UNIVERSAL_UNIT, 'fk_target_currency' => $targetCurrencyId ])->one();

        if (!$uuToSourceRate || !$uuToTargetRate){
            return 0;
        }

        $rate = $uuToTargetRate->exchange_rate / $uuToSourceRate->exchange_rate;
        return $rate;
    }


    public function getSystemRates(){
        $currencies = Currencies::find()->where(['active' => true])->all();
        
        $result = [];

        foreach($currencies as $source){
            foreach($currencies as $target){
                if ($source->id != $target->id){
                    $rate = $this->getRateBetween($source->id,$target->id);
                    //print("{$source->currency_short_name}/{$target->currency_short_name}: {$rate}\r\n");
                    //if ($source->currency_short_name!= 'EU' && $target->currency_short_name!='EU')

                    $result[$source->currency_short_name][$target->currency_short_name] = $rate;
                }
            }
        }

        return $result;
    }


    public function getSystemRatesWithoutEU(){
        $currencies = Currencies::find()->where(['active' => true])->all();

        $result = [];

        foreach($currencies as $source){
            foreach($currencies as $target){
                if ($source->id != $target->id){
                    $rate = $this->getRateBetween($source->id,$target->id);
                    //print("{$source->currency_short_name}/{$target->currency_short_name}: {$rate}\r\n");
                    if ($source->currency_short_name!= 'EU' && $target->currency_short_name!='EU')

                    $result[$source->currency_short_name][$target->currency_short_name] = $rate;
                }
            }
        }

        return $result;
    }
                    
    public function recalculateRates($changes = null){
        $changes = (!$changes)? CurrencyDelta::find()->all(): $changes;
        $lastTickSettings = Settings::findOne(['key' => 'lastTick']);
        
        foreach ($changes as $change){
            
            print("{$change->currency} changed for {$change->getDeltaPercent()} %\r\n");

            $currency = Currencies::find()->where(['currency_short_name' => $change->currency])->one();

            $universalUnit = Currencies::find()->where(['id' => self::UNIVERSAL_UNIT])->one();
            if($change->currency == $universalUnit->currency_short_name){
                break;
            }

            $rate = self::find()->where(['fk_target_currency' => $currency->id])->one();
            $diff = $rate->exchange_rate * ( abs($change->getDeltaPercent()) / 100 );

            print("Old exchange rate:{$rate->exchange_rate}\r\n");

            // Валюта растет: мы вычитаем
            if ($change->getDeltaPercent() > 0){
                $rate->exchange_rate = abs($rate->exchange_rate - abs($diff));
            }
            else{
                $rate->exchange_rate = $rate->exchange_rate + abs($diff);
            }

            $rate->save(false);

            // Сохраняем курс в историю

            $history = RatesHistory::find()->where(
                [
                    'tick' => $lastTickSettings->value,
                    'fk_target_currency' => $rate->fk_target_currency,
                    'fk_source_currency' => $rate->fk_source_currency
                ])->one();

            if (!$history)
                $history = new RatesHistory();

            $history->exchange_rate = $rate->exchange_rate;
            $history->fk_source_currency = $rate->fk_source_currency;
            $history->fk_target_currency = $rate->fk_target_currency;
            $history->tick = $lastTickSettings->value;

            $history->save();

            print("New exchange rate:{$rate->exchange_rate}\r\n");
            print("\r\n");
        }

    }

    public function saveMarketsHistory(){
        $tick = Settings::getKeyValue('lastTick');
        // Сохраняем тренды бирж

        $marketsDelta = MarketsDelta::find()->all();
        foreach ($marketsDelta as $market){
            $marketHistoryRecord = new MarketsHistory();
            $marketObj =  Markets::find()->where(['market_short_name' => $market->market])->one();


            if ($marketObj){
                $id = $marketObj->id;


                // t = 100%
                // delta = x%
                // x% = delta * 100 / t

                $marketHistoryRecord->fk_market = $id;
                $marketHistoryRecord->delta_abs = $market->delta;
                $marketHistoryRecord->delta =  $market->getDeltaPercent();
                $marketHistoryRecord->capitalization = Stock::find()->where(['fk_market' => $id])->sum('capitalization');
                $marketHistoryRecord->tick = $tick;
                $marketHistoryRecord->save(false);
            }


        }
    }
}
