<?php

namespace common\modules\painting\models\search;

use common\modules\artist\models\data\Artist;
use common\modules\movement\models\data\Movement;
use common\modules\painting\models\query\PaintingQuery;
use common\modules\subject\models\data\Subject;
use common\modules\technique\models\data\Technique;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\painting\models\data\Painting;

/**
 * PaintingSearch represents the model behind the search form of `common\modules\painting\models\data\Painting`.
 */
class PaintingSearch extends Painting
{
    public string|array $subjects = '';
    public string|array $movements = '';
    public string|array $techniques = '';
    public string|array $artists = '';


    public function rules(): array
    {
        return [
            [['title', 'start_date', 'end_date'], 'string'],
            [['artist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artist::class, 'targetAttribute' => ['artist_id' => 'id']],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y'],
            [['subjects', 'movements', 'techniques', 'artists'], 'each', 'rule' => ['integer']],
        ];
    }

    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Painting::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $this->applySubjectFilter($query);
        $this->applyMovementFilter($query);
        $this->applyTechniqueFilter($query);
        $this->applyArtistFilter($query);

        $query->andFilterWhere(['start_date' => $this->start_date])
            ->andFilterWhere(['end_date' => $this->end_date])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    public function applySubjectFilter(PaintingQuery $query): void
    {
        if ($this->subjects) {
            $query->joinWith('subjects');

            $query->andFilterWhere([Subject::tableName() . '.id' => $this->subjects]);
        }
    }

    public function applyMovementFilter(PaintingQuery $query): void
    {
        if ($this->movements) {
            $query->joinWith('movements');

            $query->andFilterWhere([Movement::tableName() . '.id' => $this->movements]);
        }
    }

    public function applyTechniqueFilter(PaintingQuery $query): void
    {
        if ($this->techniques) {
            $query->joinWith('technique');

            $query->andFilterWhere([Technique::tableName() . '.id' => $this->techniques]);
        }
    }

    public function applyArtistFilter(PaintingQuery $query): void
    {
        if ($this->artists) {
            $query->joinWith('artist');

            $query->andFilterWhere([Artist::tableName() . '.id' => $this->artists]);
        }
    }
}
