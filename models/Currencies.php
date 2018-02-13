<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property int $id
 * @property string $country
 * @property string $currency
 * @property int $max_companies
 * @property int $max_agents
 * @property string $logo
 * @property string $currency_short_name
 *
 * @property Markets[] $markets
 */
class Currencies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['max_companies', 'max_agents'], 'integer'],
            [['country', 'currency'], 'string', 'max' => 255],
            [['currency_short_name'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Государство',
            'currency' => 'Валюта',
            'max_companies' => 'Квота компаний',
            'max_agents' => 'Квота брокеров',
            'currency_short_name' => 'Индекс',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarkets()
    {
        return $this->hasMany(Markets::className(), ['fk_currency' => 'id']);
    }
}
