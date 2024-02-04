<?php

namespace common\modules\collection\controllers\frontend;

use common\modules\collection\models\data\Collection;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\data\PaintingCollection;
use Exception;
use Throwable;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `collection` module
 */
class DefaultController extends Controller
{

    /**
     * Return collection creation template to display it in modal window
     *
     * @throws Exception
     */
    public function actionGetNewCollection(): string
    {
        if ($this->request->isAjax) {
            return $this->renderAjax('includes/_new');
        }

        throw new Exception();
    }

    /**
     * Return list of user's collections to display it in modal window
     *
     * @throws Exception
     */
    public function actionGetUserCollections(): string
    {
        if ($this->request->isAjax && $collections = Yii::$app->user->identity->service->getCollections()) {
            return $this->renderPartial('includes/_collections', ['collections' => $collections]);
        }

        throw new Exception();
    }

    /**
     * Returns ids of all collections, containing specific painting
     */
    public function actionGetPaintingCollections($paintingId): string
    {
        $painting = Painting::findOne($paintingId);

        return Json::encode($painting->service->getCollectionsIdsByUser());
    }

    /**
     * @throws Throwable
     */
    public function actionAdd(int $collectionId, int $paintingId): string
    {
        if ($this->request->isAjax) {
            $collections = Yii::$app->user->identity->service->getCollections();

            if ($paintingCollection = PaintingCollection::findOne(['collection_id' => $collectionId, 'painting_id' => $paintingId])) {
                $paintingCollection->delete();
            } else {
                $this->saveNewPaintingCollection($collectionId, $paintingId);
            }

            return $this->renderPartial('includes/_collections', ['collections' => $collections]);
        }

        throw new Exception();
    }

    /**
     * @throws Exception
     */
    public function actionCreateAndAdd(int $paintingId): string
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

            return $this->renderPartial('includes/_collections', ['collections' => Yii::$app->user->identity->service->getCollections()]);
        }

        throw new Exception();
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

    public function actionValidateForm(): array
    {
        $this->response->format = Response::FORMAT_JSON;

        $model = new Collection();
        $model->load(Yii::$app->request->post());

        return ActiveForm::validate($model);
    }
}