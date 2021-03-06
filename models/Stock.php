<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "stock".
 *
 * @property int $id
 * @property int $fk_market
 * @property string $company_name
 * @property int $amount
 * @property int $capitalization
 * @property string $behavior
 * @property string $sector
 * @property float $delta [double]
 * @property float $delta_abs [double]
 * @property Markets $fkMarket
 * @property StockHistory[] $stockHistories
 * @property float $share_price [double]  Цена акции по итогам торгов
 * @property float $initial_share_price [double]  Установочная цена акции
 * @property float $initial_capitalization [double]  Установочная капитализация
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 */
class Stock extends \yii\db\ActiveRecord
{

    // Behavior enum possible values
    const BEHAVIOR_GROWTH = 'GROWTH';
    const BEHAVIOR_FALLING = 'FALLING';

    // Sector enum possible values
    const SECTOR_AGRICULTURAL = 'AGRI';
    const SECTOR_INDUSTRIAL = 'INDUS';
    const SECTOR_SERVICE = 'SERV';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock';
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
            [['fk_market','share_price','amount','initial_share_price','capitalization','initial_capitalization','company_name'], 'required'],
            [['fk_market', 'amount'], 'integer'],
            [['share_price','capitalization','initial_share_price','initial_capitalization'], 'number'],
            [['company_name'], 'string', 'max' => 255],
            [['fk_market'], 'exist', 'skipOnError' => true, 'targetClass' => Markets::className(), 'targetAttribute' => ['fk_market' => 'id']],
            [['calc_cap'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_market' => 'MARKET',
            'company_name' => 'COMPANY',
            'amount' => 'AMOUNT',
            'sector' => 'SECTOR',
            'capitalization' => 'CAP',
            'share_price' => 'U PRICE',
            'initial_capitalization' => 'INIT CAP',
            'initial_share_price' => 'INIT PRICE',
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkMarket()
    {
        return $this->hasOne(Markets::className(), ['id' => 'fk_market']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockHistories()
    {
        return $this->hasMany(StockHistory::className(), ['fk_stock' => 'id']);
    }
}
