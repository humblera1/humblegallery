<?php

namespace common\modules\collection\models\form;

use common\modules\collection\models\data\Collection;
use common\modules\painting\models\query\PaintingQuery;
use Yii;
use yii\data\ActiveDataProvider;

class CollectionPaintingSearch extends Collection
{
    const SORT_BY_TITLE = 'title';

    const SORT_BY_LAST_SAVE = 'save';

    public string $sort = self::SORT_BY_TITLE;

    public string|array $artistIds = '';

    public string|array $subjectIds = '';

    public ?string $paintingsTitle = '';

    protected ?Collection $collection = null;

    public function __construct(Collection $collection, $config = [])
    {
        $this->collection = $collection;

        $this->setAttributes($collection->getAttributes(), false);

        parent::__construct($config);
    }

    /** {@inheritdoc} */
    public function rules(): array
    {
        return [
            [['paintingsTitle'], 'string', 'max' => 255],
            [['artistIds', 'subjectIds'], 'each', 'rule' => ['integer']],
            [['sort'], 'in', 'range' => [self::SORT_BY_TITLE, self::SORT_BY_LAST_SAVE]],
            [['sort'], 'in', 'range' => [self::SORT_BY_TITLE, self::SORT_BY_LAST_SAVE]],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'sort' => 'Сортировка',
            'subjectIds' => 'Жанры',
            'artistIds' => 'Художники',
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        /** @var PaintingQuery $query */
        $query = $this->collection->getPaintings();

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

        $query->andFilterWhere(['like', 'title', $this->paintingsTitle]);
        $this->applySubjectFilters($query);
        $this->applyArtistFilters($query);
        $this->applySorting($query);

        return $dataProvider;
    }

    public function applySubjectFilters(PaintingQuery $query): void
    {
        if ($this->subjectIds) {
            $query->joinWith('subjects s')
                ->andFilterWhere(['s.id' => $this->subjectIds]);
        }
    }

    public function applyArtistFilters(PaintingQuery $query): void
    {
        if ($this->artistIds) {
            $query->andFilterWhere(['artist_id' => $this->artistIds]);
        }
    }

    public function applySorting(PaintingQuery $query): void
    {
        $order = ['title' => SORT_ASC];

        if ($this->sort === self::SORT_BY_LAST_SAVE) {
            $query->joinWith(['paintingCollections pc'])
                ->addSelect(['painting.*', 'saved_at' => 'pc.created_at']);

            // todo: why SORT_DESC works incorrectly?
            $order = ['pc.created_at' => SORT_DESC];
        }

        $query->orderBy($order);
    }
}