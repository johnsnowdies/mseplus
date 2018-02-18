<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "markets_history".
 *
 * @property int $id
 * @property int $fk_market
 * @property double $delta
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
            [['delta'], 'number'],
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

    public function getLastTicksMarketsHistory(){
        $lastTickSettings = Settings::findOne(['key' => 'lastTick']);
        $tick = $lastTickSettings->value;
        $result = [];
        for($i = ($tick - 10); $i <= $tick; $i++){
            $result[] = $this->getMarketsForTick($i);
        }

        return $result;
    }

    public function getHistoryForMarket($id){
        $data = $this->getLastTicksMarketsHistory();

        $result = [];

        foreach ($data as $ticks){
            foreach($ticks as $market)
                if ($market->fk_market == $id)
                    $result[] = round($market->delta,2);
        }

        return $result;


    }
}
