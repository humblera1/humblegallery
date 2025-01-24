<?php

namespace common\modules\painting\models\search;

use common\modules\artist\models\data\Artist;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\query\PaintingQuery;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PaintingSearch represents the model behind the search form of `common\modules\painting\models\data\Painting`.
 */
class PaintingSearch extends Painting
{
    public string|array $subjects = '';
    public string|array $movements = '';
    public string|array $techniques = '';
    public string|array $artists = '';


    /** {@inheritdoc} */
    public function rules(): array
    {
        return [
            [['title', 'start_date', 'end_date'], 'string'],
            [['artist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artist::class, 'targetAttribute' => ['artist_id' => 'id']],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y'],
            [['subjects', 'movements', 'techniques', 'artists'], 'each', 'rule' => ['integer']],
        ];
    }

    /** {@inheritdoc} */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Painting::find()->distinct();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['paintingsPerPage'],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $this->applySubjectFilter($query);
        $this->applyMovementFilter($query);
        $this->applyTechniqueFilter($query);
        $this->applyArtistFilter($query);

        $query->andFilterWhere(['like', Painting::tableName() . '.title', $this->title]);

        $query->andFilterWhere(['start_date' => $this->start_date])
            ->andFilterWhere(['end_date' => $this->end_date])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    /**
     * Applies subject filter to query.
     */
    public function applySubjectFilter(PaintingQuery $query): void
    {
        if ($this->subjects) {
            $query->filterBySubject($this->subjects);
        }
    }

    /**
     * Applies movement filter to query.
     */
    public function applyMovementFilter(PaintingQuery $query): void
    {
        if ($this->movements) {
            $query->filterByMovement($this->movements);
        }
    }

    /**
     * Applies technique filter to query.
     */
    public function applyTechniqueFilter(PaintingQuery $query): void
    {
        if ($this->techniques) {
            $query->filterByTechnique($this->techniques);
        }
    }

    /**
     * Applies artist filter to query.
     */
    public function applyArtistFilter(PaintingQuery $query): void
    {
        if ($this->artists) {
            $query->filterByArtist($this->artists);
        }
    }
}
