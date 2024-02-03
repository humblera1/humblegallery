<?php

namespace common\modules\painting\controllers\frontend;

use common\modules\collection\models\data\Collection;
use common\modules\painting\models\data\PaintingCollection;
use common\modules\painting\models\data\PaintingLike;
use common\modules\painting\models\search\PaintingSearch;
use Exception;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\StaleObjectException;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        $model = new PaintingSearch();

        return $this->render('index', [
            'dataProvider' => $this->getProvider(),
            'model' => $model,
        ]);
    }

    public function actionApplyFilters(): string
    {
        if ($this->request->isAjax) {
            return $this->renderPartial('includes/_content', [
                'provider' => $this->getProvider()
            ]);
        }

        throw new Exception();
    }

    /**
     * This function handles the action of liking a painting.
     *
     * @throws Exception if the request is not an AJAX request.
     * @throws StaleObjectException|Throwable if deleting fails
     */
    public function actionLike(): bool
    {
        if ($this->request->isAjax) {
            $userId = Yii::$app->user->getId();
            $paintingId = Yii::$app->request->post('paintingId');

            if (Yii::$app->user->isGuest) {
                //окно логина
            }

            if ($like = PaintingLike::findOne(['user_id' => $userId, 'painting_id' => $paintingId])) {
                return $like->delete();
            }

            $newLike = new PaintingLike();

            $newLike->user_id = $userId;
            $newLike->painting_id = $paintingId;

            return $newLike->save();
        }

        throw new Exception();
    }

    /**
     * @throws Exception
     */
    public function actionNewCollection(): string
    {
        if ($this->request->isAjax) {
            return $this->renderPartial('includes/_new');
        }

        throw new Exception();
    }

    /**
     * @throws Throwable
     */
    public function actionAdd(int $collectionId, int $paintingId): string
    {
        if ($this->request->isAjax) {
            if ($paintingCollection = PaintingCollection::findOne(['collection_id' => $collectionId, 'painting_id' => $paintingId])) {
                $paintingCollection->delete();

                if ($collections = Yii::$app->user->identity->service->getCollections()) {
                    return $this->renderPartial('includes/_collections', ['collections' => $collections]);
                }

                return $this->renderPartial('includes/_new');
            }

            $this->saveNewPaintingCollection($collectionId, $paintingId);

            return $this->renderPartial('includes/_collections', ['collections' => Yii::$app->user->identity->getCollections()]);
        }

        throw new Exception();
    }

    /**
     * @throws Exception
     */
    public function actionCreateAndAdd(int $paintingId): void
    {
        if ($this->request->isAjax) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $collection = $this->saveNewCollection();
                $this->saveNewPaintingCollection($collection->id, $paintingId);
            } catch (Exception $exception) {
                $transaction->rollBack();

                Yii::error($exception->getMessage(), 'collection');

                throw $exception;
            }

            $transaction->commit();

            return;
        }

        throw new Exception();
    }

    public function actionGetUserCollections(): string
    {
        return $this->renderPartial('includes/_collections', ['collections' => Yii::$app->user->identity->getCollections()]);
    }

    /**
     * Save new collection to database
     *
     * @throws Exception
     */
    protected function saveNewCollection(): Collection
    {
        $collection = new Collection();

        $collection->load($this->request->post());
        $collection->user_id = Yii::$app->user->id;

        if ($collection->validate() && $collection->save()) {
            return $collection;
        }

        throw new Exception();
    }

    /**
     * Save new painting to specific collection
     *
     * @throws Exception
     */
    protected function saveNewPaintingCollection(int $collectionId, int $paintingId): void
    {
        $paintingCollection = new PaintingCollection();

        $paintingCollection->collection_id = $collectionId;
        $paintingCollection->painting_id = $paintingId;

        if ($paintingCollection->validate() && $paintingCollection->save()) {
            return;
        }

        throw new Exception();
    }

    protected function getProvider(): ActiveDataProvider
    {
        $searchModel = new PaintingSearch();

        return $searchModel->search($this->request->post());
    }
}