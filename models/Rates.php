<?php

namespace app\models;

use Yii;
use app\models\Currencies;

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
        $uuToSourceRate = Self::find()->where(['fk_source_currency' => Rates::UNIVERSAL_UNIT, 'fk_target_currency' => $sourceCurrencyId ])->one();
        $uuToTargetRate = Self::find()->where(['fk_source_currency' => Rates::UNIVERSAL_UNIT, 'fk_target_currency' => $targetCurrencyId ])->one();

        $rate = $uuToTargetRate->exchange_rate / $uuToSourceRate->exchange_rate;
        return $rate;
    }


    public function getSystemRates(){
        $currencies = Currencies::find()->andWhere(['!=', 'id', Rates::UNIVERSAL_UNIT])->all();
        
        $result = [];

        foreach($currencies as $source){
            foreach($currencies as $target){
                if ($source->id != $target->id){
                    $rate = $this->getRateBetween($source->id,$target->id);
                    //print("{$source->currency_short_name}/{$target->currency_short_name}: {$rate}\r\n");
                    $result[$source->currency_short_name][$target->currency_short_name] = $rate;
                }
            }
        }

        return $result;
    }
}
