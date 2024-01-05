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
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title'], 'string'],
            [['artist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artist::class, 'targetAttribute' => ['artist_id' => 'id']],
            [[ 'start_date', 'end_date'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
        ];
    }

    /**
     * {@inheritdoc}
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

        if ($this->start_date) {
            $query->andFilterWhere(['start_date' => $this->start_date]);
        }

        if ($this->end_date) {
            $query->andFilterWhere(['end_date' => $this->end_date]);
        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
