<?php

namespace common\modules\user\models\search;


use common\modules\artist\models\data\Artist;
use common\modules\movement\models\data\Movement;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\query\PaintingQuery;
use common\modules\subject\models\data\Subject;
use common\modules\technique\models\data\Technique;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class FavoritePaintingSearch extends Painting
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
            [['artist_id'], 'exist', 'skipOnError' => true, 'targetRelation' => 'artist'],
            //TODO: ЗА ЧТО
//            [['subjects', 'movements', 'techniques', 'artists'], 'each', 'rule' => ['integer']],
            [['subjects', 'movements', 'techniques', 'artists'], 'safe'],
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
        $user = Yii::$app->user->identity;
        $query = $user->getFavoritePaintings();

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

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    /**
     * Applies subject filter to query
     */
    public function applySubjectFilter(ActiveQuery $query): void
    {
        if ($this->subjects) {
            $query->joinWith('subjects');

            $query->andFilterWhere([Subject::tableName() . '.id' => $this->subjects]);
        }
    }

    /**
     * Applies movement filter to query
     */
    public function applyMovementFilter(ActiveQuery $query): void
    {
        if ($this->movements) {
            $query->joinWith('movements');

            $query->andFilterWhere([Movement::tableName() . '.id' => $this->movements]);
        }
    }

    /**
     * Applies technique filter to query
     */
    public function applyTechniqueFilter(ActiveQuery $query): void
    {
        if ($this->techniques) {
            $query->joinWith('technique');

            $query->andFilterWhere([Technique::tableName() . '.id' => $this->techniques]);
        }
    }

    /**
     * Applies artist filter to query
     */
    public function applyArtistFilter(ActiveQuery $query): void
    {
        if ($this->artists) {
            $query->joinWith('artist');

            $query->andFilterWhere([Artist::tableName() . '.id' => $this->artists]);
        }
    }
}