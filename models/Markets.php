<?php

namespace app\models;

use Yii;

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_currency'], 'required'],
            [['fk_currency'], 'integer'],
            [['type'], 'string'],
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
            'fk_currency' => '',
            'type' => 'Тип',
            'name' => 'Название',
            'market_short_name' => 'Индекс',
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
