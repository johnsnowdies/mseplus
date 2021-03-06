<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "markets_history".
 *
 * @property int $id
 * @property int $fk_market
 * @property double $delta
 * @property double $delta_abs
 * @property float $capitalization
 * @property int $tick
 */
class MarketsHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'markets_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_market', 'tick'], 'integer'],
            [['delta','delta_abs'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_market' => 'Fk Market',
            'delta' => 'Delta',
            'tick' => 'Tick',
        ];
    }

    public function getMarketsForTick($tick){
        return self::find()->where(['tick' => $tick])->all();
    }

    public function getCapitalizationHistoryInFiat($marketId, $ticks,$currency){
        $currentTick = Settings::getKeyValue('lastTick');
        $lowTick = $currentTick - $ticks;



        if($lowTick < 1)
            $lowTick = 1;

        $data = self::find()->select('capitalization')->where(['fk_market' => $marketId])->andWhere('tick >= :tick',[
            ':tick' => $lowTick
        ])->all();


        $result = [];

        foreach ($data as $record){
            if ($record->capitalization){
                $result[] = $record->capitalization  / 1000000000;
            }

        }

        return $result;
    }

    public function getCapitalizationHistory($marketId, $ticks,$currency){
        $currentTick = Settings::getKeyValue('lastTick');
        $lowTick = $currentTick - $ticks;

        $rateService = new Rates();

        $rate = $rateService->getRateBetween($currency,1);
        //var_dump($rate);
        //die;

        if($lowTick < 1)
            $lowTick = 1;

        $data = self::find()->select('capitalization')->where(['fk_market' => $marketId])->andWhere('tick >= :tick',[
            ':tick' => $lowTick
        ])->all();


        $result = [];

        foreach ($data as $record){
            if ($record->capitalization){
                $result[] = $record->capitalization * $rate  / 1000000000;
            }

        }

        return $result;
    }

    public function getLastTicksMarketsHistory(){
        $lastTickSettings = Settings::findOne(['key' => 'lastTick']);
        $tick = $lastTickSettings->value;


        $result = [];
        $first = ($tick - 10);

        for($i = $first; $i <= $tick; $i++){
            $result[] = $this->getMarketsForTick($i);
        }

        return $result;
    }

    public function getDiffLastTwoDeltas($marketId){

        $hist = $this->getLastTicksMarketsHistory();
        $last = count($hist) - 1;

        $delta1 = 0;
        $delta2 = 0;

        foreach ($hist[$last] as $currentTick){
            if($currentTick->fk_market == $marketId){
                $delta1 = $currentTick->delta;
            }
        }

        foreach ($hist[$last - 1] as $currentTick){
            if($currentTick->fk_market == $marketId){
                $delta2 = $currentTick->delta;
            }
        }

        return  $delta1 < $delta2;
    }

    public function getHistoryForMarket($id){
        $data = $this->getLastTicksMarketsHistory();

        $result = [];

        foreach ($data as $ticks){
            foreach($ticks as $market)
                if ($market->fk_market == $id)
                    $result[] = round($market->delta,4);
        }

        return $result;
    }

}
