<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $markets
 * @property string $sector
 * @property string $type
 * @property string $priority
 * @property int $created_at
 * @property int $updated_at
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
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
}
