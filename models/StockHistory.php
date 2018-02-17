<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "history".
 *
 * @property int $id
 * @property int $fk_stock
 * @property int $tickId
 * @property double $capitalization
 * @property double $share_price
 * @property double $delta
 * @property string $behavior
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Stock $fkStock
 */
class StockHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock_history';
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
            [['fk_stock', 'tickId', 'share_price', 'delta', 'behavior'], 'required'],
            [['fk_stock', 'tickId', 'created_at', 'updated_at'], 'integer'],
            [['capitalization', 'share_price', 'delta'], 'number'],
            [['behavior'], 'string'],
            [['fk_stock'], 'exist', 'skipOnError' => true, 'targetClass' => Stock::className(), 'targetAttribute' => ['fk_stock' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_stock' => 'Fk Stock',
            'tickId' => 'Tick ID',
            'capitalization' => 'Capitalization',
            'share_price' => 'Share Price',
            'delta' => 'Delta',
            'behavior' => 'Behavior',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkStock()
    {
        return $this->hasOne(Stock::className(), ['id' => 'fk_stock']);
    }
}
