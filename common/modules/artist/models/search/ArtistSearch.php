<?php

namespace common\modules\artist\models\search;

use common\modules\artist\models\query\ArtistQuery;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\artist\models\data\Artist;

/**
 * ArtistSearch represents the model behind the search form of `common\modules\artist\models\data\Artist`.
 */
class ArtistSearch extends Artist
{
    public string|array $movements = [];

    public string|array $subjects = [];

    public string|array $techniques = [];

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'born', 'died'], 'string'],
            [['movements', 'subjects', 'techniques'], 'each', 'rule' => ['integer']],
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
    public function search(array $params, $loadRelations = false): ActiveDataProvider
    {
        $query = Artist::find();

        if ($loadRelations) {
            $query->with(['paintings.movements']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $this->applyMovementFilter($query);
        $this->applySubjectFilter($query);
        $this->applyTechniqueFilter($query);

        // grid filtering conditions
        $query->andFilterWhere([
            'born' => $this->born,
            'died' => $this->died,
            'rating' => $this->rating,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', Artist::tableName() . '.name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    /**
     * Applies movement filter to query.
     */
    public function applyMovementFilter(ArtistQuery $query): void
    {
        if ($this->movements) {
            $query->filterByMovement($this->movements);
        }
    }

    /**
     * Applies subject filter to query.
     */
    public function applySubjectFilter(ArtistQuery $query): void
    {
        if ($this->subjects) {
            $query->filterBySubject($this->subjects);
        }
    }

    /**
     * Applies technique filter to query
     */
    public function applyTechniqueFilter(ArtistQuery $query): void
    {
        if ($this->techniques) {
            $query->filterByTechnique($this->techniques);
        }
    }
}
