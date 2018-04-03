<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "meta_news".
 *
 * @property int $id
 * @property string $titl
 * @property string $sectors
 * @property string $news
 * @property int $created_at
 * @property int $updated_at
 */
class MetaNews extends \yii\db\ActiveRecord
{

    public $dataSectors;
    public $dataNews;

    public $tmpMarket;
    public $tmpType;
    public $tmpTtl;
    public $tmpPriority;
    public $startTick;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meta_news';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getSectors(){
        return unserialize($this->sectors);
    }


    public function setSectors($sectors){
        $this->sectors = serialize($sectors);
    }


    public function getNews(){
        return unserialize($this->news);
    }

    public function setNews($news){
        $this->news = serialize($news);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sectors', 'news'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['titl'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titl' => 'Заголовок',
            'dataNews' => 'Список новостей',
            'sectors' => 'Sectors',
            'news' => 'News',
            'startTick' => 'Стартовый такт',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
