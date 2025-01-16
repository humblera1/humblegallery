<?php

namespace common\modules\user\models\search;

use common\modules\collection\models\data\Collection;
use common\modules\collection\models\query\CollectionQuery;
use common\modules\user\models\data\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserCollectionSearch extends Collection
{
    const SORT_BY_TITLE = 'title';

    const SORT_BY_LAST_SAVE = 'save';

    public string $sort = self::SORT_BY_TITLE;

    protected ?User $user = null;

    protected bool $isOwner = false;

    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
        $this->isOwner = $this->user->id === Yii::$app->user->id;
    }

    /** {@inheritdoc} */
    public function rules(): array
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['is_private', 'is_archived'], 'trim'],
            [['is_private', 'is_archived'], 'default', 'value' => null],
            [['is_private', 'is_archived'], 'boolean'],
            [['sort'], 'in', 'range' => [self::SORT_BY_TITLE, self::SORT_BY_LAST_SAVE]],
        ];
    }

    /** {@inheritdoc} */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    {
        return [
            'sort' => 'Сортировка',
            'is_private' => 'Публичность',
            'is_archived' => 'Активность',
        ];
    }

    /**
     * Creates data provider instance with search query applied.
     */
    public function search(array $params): ActiveDataProvider
    {
        // Подгружаем первые сохраненные картины, для формирования обложки
        /** @var CollectionQuery $query */
        $query = $this->user->getCollections()
            ->with('firstPaintingsWithLimit.artist');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['collectionsPerPage'],
            ],
        ]);

        $this->load($params);

        $isset = isset($this->is_archived);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Handle the specific case for 'is_archived'
        if (!$isset) {
            $this->is_archived = false;
        }

        // Применяем фильтры, после чего клонируем запрос до потенциального объединения с картинами для оптимизации подсчета
        $this->applyFilters($query);
        $query->andFilterWhere(['like', 'title', $this->title]);

        $countQuery = clone $query;

        $this->applySorting($query);

        $dataProvider->setTotalCount($countQuery->count());

        return $dataProvider;
    }

    /**
     * Applies sorting conditions to the query.
     *
     * @param CollectionQuery $query
     * @return void
     */
    public function applySorting(CollectionQuery $query): void
    {
        $order = ['title' => SORT_ASC];

        // Perform join only when necessary: if sorting by save date is selected, it is necessary to join with the intermediate table
        if ($this->sort === self::SORT_BY_LAST_SAVE) {
            $query->joinWith('collectionPaintings')
                ->addSelect(['collection.*', 'saved_at' => 'painting_collection.created_at']);

            $order = ['saved_at' => SORT_DESC];
        }

        $query->orderBy($order);
    }

    /**
     * Applies filters to the collection query.
     * If the request is made by the collection owner, archived and private collections can be shown.
     * Otherwise, always hide archived and private collections.
     *
     * @param CollectionQuery $query
     * @return void
     */
    public function applyFilters(CollectionQuery $query): void
    {
        if ($this->isOwner) {
            if (isset($this->is_private)) {
                $query->andWhere(['is_private' => $this->is_private]);
            }

            if (isset($this->is_archived)) {
                $query->andWhere(['is_archived' => $this->is_archived]);
            }
        } else {
            $query->publicOnly();
            $query->activeOnly();
        }
    }
}
