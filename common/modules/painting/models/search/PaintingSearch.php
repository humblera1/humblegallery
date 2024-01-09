<?php

namespace common\modules\painting\models\search;

use common\modules\artist\models\data\Artist;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\painting\models\data\Painting;

/**
 * PaintingSearch represents the model behind the search form of `common\modules\painting\models\data\Painting`.
 */
class PaintingSearch extends Painting
{
    public function rules(): array
    {
        return [
            [['title', 'start_date', 'end_date'], 'string'],
            [['artist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artist::class, 'targetAttribute' => ['artist_id' => 'id']],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y'],
        ];
    }

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
        $query = Painting::find();

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

        $query->andFilterWhere(['start_date' => $this->start_date])
            ->andFilterWhere(['end_date' => $this->end_date])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
