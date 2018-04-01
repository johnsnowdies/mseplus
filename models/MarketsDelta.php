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

    public function getDeltaPercent(){
        $id =  Markets::find()->where(['market_short_name' => $this->market])->one()['id'];

        $totalCapitalization = $this->getTotalMarketCapitalization($id);
        return round(($this->delta * 100) / $totalCapitalization,4);
    }



    public function getTotalMarketCapitalization($id){

        return Stock::find()->where(['fk_market' => $id])->sum('capitalization');
    }
}
