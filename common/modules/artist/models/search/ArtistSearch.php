<?php

namespace common\modules\artist\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\artist\models\data\Artist;

/**
 * ArtistSearch represents the model behind the search form of `common\modules\artist\models\data\Artist`.
 */
class ArtistSearch extends Artist
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'born', 'died'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Artist::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'born' => $this->born,
            'died' => $this->died,
            'rating' => $this->rating,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
