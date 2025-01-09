<?php

namespace common\modules\collection\models\service;

use common\components\Service;
use common\modules\collection\models\data\Collection;
use common\modules\collection\models\form\AddPaintingToNewCollectionForm;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\data\PaintingCollection;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property Collection $model
 */

class CollectionService extends Service
{
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

    public function performCreateAndAdd(array $params): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $form = new AddPaintingToNewCollectionForm();
            $form->load($params);

            if (!$form->validate()) {
                return false;
            }

            $collection = new Collection();

            $collection->title = $form->title;
            $collection->is_private = $form->is_private;
            $collection->user_id = Yii::$app->user->id;

            if (!$collection->save()) {
                throw new Exception();
            }

            $paintingCollection = new PaintingCollection();

            $paintingCollection->collection_id = $collection->id;
            $paintingCollection->painting_id = $form->painting_id;

            if (!$paintingCollection->save()) {
                throw new Exception();
            }
        } catch (Exception $e) {
            $transaction->rollBack();

            Yii::error($e->getMessage());

            return false;
        }

        $transaction->commit();

        return true;
    }

//    public function togglePainting(array $params): bool
//    {
//        $paintingCollection = new PaintingCollection();
//        $paintingCollection->load([
//            'collection_id' => $params['collectionId'],
//            'painting_id' => $params['paintingId'],
//        ], '');
//
//        if (!$paintingCollection->validate()) {
//            return false;
//        }
//
//        $existingRecord = PaintingCollection::findOne([
//            'painting_id' => $paintingCollection->painting_id,
//            'collection_id' => $paintingCollection->collection_id,
//        ]);
//
//        try {
//            if ($existingRecord) {
//                $success = $existingRecord->delete();
//            } else {
//                $success = $paintingCollection->save();
//            }
//        } catch (\Throwable) {
//            return false;
//        }
//
//        return $success;
//    }
}