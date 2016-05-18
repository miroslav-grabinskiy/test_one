<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Rgb;

/**
 * SearchRgb represents the model behind the search form about `common\models\Rgb`.
 */
class SearchRgb extends Rgb
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'red', 'green', 'blue'], 'integer'],
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
        $query = Rgb::find();

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
            'red' => $this->red,
            'green' => $this->green,
            'blue' => $this->blue,
        ]);

        return $dataProvider;
    }
}
