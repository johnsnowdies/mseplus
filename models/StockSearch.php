<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Stock;

/**
 * StockSearch represents the model behind the search form of `app\models\Stock`.
 */
class StockSearch extends Stock
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fk_market', 'amount', 'created_at', 'updated_at'], 'integer'],
            [['company_name', 'behavior', 'sector'], 'safe'],
            [['capitalization', 'share_price', 'delta', 'initial_share_price', 'initial_capitalization'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Stock::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['capitalization',   'fk_market',
            'company_name',
            'amount',
            'share_price']]
        ]);

         /**
     * Setup your sorting attributes
     * Note: This is setup before the $this->load($params) 
     * statement below
     */
    $dataProvider->setSort([
        'attributes' => [
            'capitalization' => [
                'asc' => ['capitalization' => SORT_ASC],
                'desc' => ['capitalization' => SORT_DESC],
                'label' => 'CAP',
                'default' => SORT_ASC
            ],
            
            'fk_market',
            'company_name',
            'amount',
            'share_price'
        ]
    ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fk_market' => $this->fk_market,
            'amount' => $this->amount,
            'capitalization' => $this->capitalization,
            'share_price' => $this->share_price,
            'delta' => $this->delta,
            'initial_share_price' => $this->initial_share_price,
            'initial_capitalization' => $this->initial_capitalization,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'behavior', $this->behavior])
            ->andFilterWhere(['like', 'sector', $this->sector]);

        return $dataProvider;
    }
}
