<?php

namespace common\modules\collection\models\data;

use common\components\behaviors\SelfHealingUrlBehavior;
use common\modules\collection\models\query\CollectionQuery;
use common\modules\collection\models\service\CollectionService;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\data\PaintingCollection;
use common\modules\user\models\data\User;
use yii\base\InvalidConfigException;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 *
 * @property int $id
 * @property string $title
 * @property string $cover
 * @property string $slug
 * @property int $user_id
 * @property bool $is_private
 * @property bool $is_archived
 * @property int $created_at
 *
 * @property User $user
 * @property PaintingCollection[] $collectionPaintings
 * @property Painting[] $paintings
 * @property Painting[] $firstPaintingsWithLimit Первые картины, сохраненные в коллекции.
 *
 * @method SelfHealingUrlBehavior getSelfHealingUrl Generate a self-healing URL for the collection
 */

class Collection extends ActiveRecord
{
    public ?CollectionService $service = null;

    public int $contains_painting = 0;

    public function init(): void
    {
        $this->service = new CollectionService($this);

        parent::init();
    }

    /** {@inheritdoc} */
    public static function tableName(): string
    {
        return '{{%collection}}';
    }

    public function behaviors(): array
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => false,
            ],
            'sluggable' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
            ],
            'selfHealingUrl' => [
                'class' => SelfHealingUrlBehavior::class,
            ],
        ];
    }

    /** {@inheritdoc} */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 32],
            [['is_private', 'is_archived'], 'boolean'],
            [['user_id'], 'integer'],
            [['user_id'], 'exist', 'targetRelation' => 'user'],

        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    {
        return [
            'title' => 'Название',
            'user_id' => 'Пользователь',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getCollectionPaintings(): ActiveQuery
    {
        return $this->hasMany(PaintingCollection::class, ['collection_id' => 'id']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getPaintings(): ActiveQuery
    {
        return $this->hasMany(Painting::class, ['id' => 'painting_id'])
            ->viaTable('{{%painting_collection}}', ['collection_id' => 'id']);
    }

    /**
     * Возвращает первые три картины для каждой коллекции на странице.
     *
     * @param int $limit
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getFirstPaintingsWithLimit(int $limit = 3): ActiveQuery
    {
        $subquery = PaintingCollection::find()
            ->select([
                'collection_id',
                'painting_id',
                'created_at',
                'row_number' => new Expression('ROW_NUMBER() OVER (PARTITION BY collection_id ORDER BY created_at)'),
            ]);

        return $this->hasMany(Painting::class, ['id' => 'painting_id'])
            ->viaTable('painting_collection', ['collection_id' => 'id'], function($query) use ($subquery, $limit) {
                $query->alias('pc')
                    ->innerJoin(
                        ['lp' => $subquery],
                        'lp.painting_id = pc.painting_id AND lp.collection_id = pc.collection_id AND lp.row_number <= :limit',
                        ['limit' => $limit]
                    );
            });
    }

    /** {@inheritdoc} */
    public static function find(): CollectionQuery
    {
        return new CollectionQuery(get_called_class());
    }
}