<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "markets".
 *
 * @property int $id
 * @property int $fk_currency
 * @property string $type
 * @property string $name
 * @property string $market_short_name
 *
 * @property Currencies $fkCurrency
 * @property Stock[] $stocks
 *
 * @property string $logo [varchar(255)]
 * @property int $max_companies [int(11)]
 * @property int $max_agents [int(11)]
 * @property int $max_amount [int(11)]
 * @property int $min_amount [int(11)]
 * @property float $max_capitalization
 * @property float $min_capitalization
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 * @prorerty int rate_agri
 * @property int rate_indus
 * @property int rate_serv
 */
class Markets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'markets';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_currency','market_short_name','name','type'], 'required'],
            [['fk_currency','max_agents','max_companies'], 'integer'],
            [['type','logo'], 'string'],
            [['name', 'market_short_name'], 'string', 'max' => 255],
            [['fk_currency'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::className(), 'targetAttribute' => ['fk_currency' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_currency' => 'Валюта',
            
            'logo' => 'Логотип',
            'type' => 'Тип',
            'name' => 'Название',
            'market_short_name' => 'Индекс',
            'max_amount' => 'MAX AM',
            'min_amount' => 'MIN AM',
            'max_capitalization' => 'MAX CAP',
            'min_capitalization' => 'MIN CAP',
            'max_companies' => 'COMP QUOTE',
            'max_agents' => 'MAX AGENTS',
            'rate_agri' => 'Агрокультурный сектор',
            'rate_indus' => 'Индустриальный сектор',
            'rate_serv' => 'Сектор услуг'
        ];
    }

    public static function getMarketsArray(){
        $markets = self::find()->all();

        $arMarkets = [];
        foreach ($markets as $market){
            $arMarkets[$market->id] = $market->market_short_name;
        }

        return $arMarkets;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkCurrency()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'fk_currency']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['fk_market' => 'id']);
    }
}
