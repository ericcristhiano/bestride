<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ride;

/**
 * RideSearch represents the model behind the search form about `app\models\Ride`.
 */
class RideSearch extends Ride
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'available_seats', 'price', 'user_id'], 'integer'],
            [['date', 'origin', 'destination', 'more_information'], 'safe'],
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
        $query = Ride::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'date' => $this->date,
            'available_seats' => $this->available_seats,
            'price' => $this->price,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'origin', $this->origin])
            ->andFilterWhere(['like', 'destination', $this->destination])
            ->andFilterWhere(['like', 'more_information', $this->more_information]);

        return $dataProvider;
    }
}
