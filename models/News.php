<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int $tick
 * @property string $title
 * @property string $text
 * @property int $fk_market
 * @property string $sector
 * @property string $type
 * @property string $priority
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Markets $fkMarket
 */
class News extends \yii\db\ActiveRecord
{

    const TYPE_POSITIVE = 'POSITIVE';
    const TYPE_NEGATIVE = 'NEGATIVE';

    const PRIORITY_LOW = 'LOW';
    const PRIORITY_MEDIUM = 'MEDIUM';
    const PRIORITY_HIGH = 'HIGH';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
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
            [['text', 'sector', 'type', 'priority'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'markets'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'markets' => 'Markets',
            'sector' => 'Sector',
            'type' => 'Type',
            'priority' => 'Priority',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkMarket()
    {
        return $this->hasOne(Markets::className(), ['id' => 'fk_market']);
    }
}
