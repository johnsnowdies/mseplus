<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stock".
 *
 * @property int $id
 * @property int $fk_market
 * @property string $company_name
 * @property int $amount
 * @property int $capitalization
 * @property double $sum
 *
 * @property Markets $fkMarket
 * @property StockHistory[] $stockHistories
 */
class Stock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_market'], 'required'],
            [['fk_market', 'amount', 'capitalization'], 'integer'],
            [['sum'], 'number'],
            [['company_name'], 'string', 'max' => 255],
            [['fk_market'], 'exist', 'skipOnError' => true, 'targetClass' => Markets::className(), 'targetAttribute' => ['fk_market' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_market' => 'Биржа',
            'company_name' => 'Название кампании',
            'amount' => 'Размешено акций',
            'capitalization' => 'Капитализация',
            'sum' => 'Стоимость акции',
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
