<?php

namespace common\modules\collection\models\service;

use common\components\interfaces\RepositoryInterface;
use common\components\Service;
use common\modules\collection\models\data\Collection;
use common\modules\collection\models\repository\CollectionRepository;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\data\PaintingCollection;
use Exception;
use Yii;
use yii\db\ActiveRecord;

/**
 * @property Collection $model
 */

class CollectionService extends Service
{
    protected RepositoryInterface $repository;

    public function __construct(ActiveRecord $model)
    {
        $this->repository = new CollectionRepository();

        parent::__construct($model);
    }

    public function getCover(): string
    {
        return Yii::$app->params['collectionsUrl'] . $this->model->cover;
    }

    public function getPreviewImage(): bool|string
    {
        /** @var Painting $lastPainting */
        $lastPainting = Painting::find()
            ->andFilterWhere(['c.id' => $this->model->id])
            ->joinWith('collections c')
            ->orderBy([PaintingCollection::tableName() . '.created_at' => SORT_DESC])
            ->one();

        if ($lastPainting) {
            return $lastPainting->service->getThumbnail();
        }

        return false;
    }

    public function saveCollectionWithFile(): bool
    {
        return $this->repository->saveWithFile($this->model);
    }

    /**
     * @param int $paintingId
     * @return bool
     */
    public function createCollectionWithPainting(int $paintingId): bool
    {
        $painting = Painting::findOne($paintingId);
        $this->model->user_id = Yii::$app->user->id;

        if ($painting) {
            return $this->repository->createWithPainting($this->model, $painting);
        }

        return false;
    }

    public function togglePainting(int $paintingId): bool
    {
        $model = $this->model;
        $existingRecord = PaintingCollection::findOne([
            'painting_id' => $paintingId,
            'collection_id' => $model->id,
        ]);

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($existingRecord) {
                if (!$existingRecord->delete()) {
                    throw new Exception();
                }
            } else {
                $paintingCollection = new PaintingCollection();

                $paintingCollection->collection_id = $model->id;
                $paintingCollection->painting_id = $paintingId;

                if (!$paintingCollection->save()) {
                    throw new Exception();
                }
            }
        } catch (\Throwable $t) {
            $transaction->rollBack();

            return false;
        }

        $transaction->commit();

        return true;
    }
}