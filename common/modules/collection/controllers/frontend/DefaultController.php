<?php

namespace common\modules\collection\controllers\frontend;

use common\modules\collection\models\data\Collection;
use common\modules\painting\models\data\PaintingCollection;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `collection` module
 */
class DefaultController extends Controller
{

    /**
     * Saves new PaintingCollection
     * @throws Exception
     */
    public function actionAdd(int $collectionId, int $paintingId): void
    {
        if ($this->request->isAjax && $this->saveNewPaintingCollection($collectionId, $paintingId)) {
            return;
        }

        throw new Exception();
    }

    public function actionCreateAndAdd(int $paintingId): void
    {
        if (
            $this->request->isAjax
            && ($collection = $this->saveNewCollection())
            && $this->saveNewPaintingCollection($collection->id, $paintingId)
        ) {
            return;
        }

        throw new Exception();
    }

    protected function saveNewCollection(): bool|Collection
    {
        $collection = new Collection();

        $collection->load($this->request->post());
        $collection->user_id = Yii::$app->user->id;

        if ($collection->validate() && $collection->save()) {
            return $collection;
        }

        return false;
    }

    protected function saveNewPaintingCollection(int $collectionId, int $paintingId): bool
    {
        $paintingCollection = new PaintingCollection();

        $paintingCollection->painting_id = $collectionId;
        $paintingCollection->collection_id = $paintingId;

        if ($paintingCollection->validate()) {
            return $paintingCollection->save();
        }

        return false;
    }

    public function actionValidateForm(): array
    {
        $this->response->format = Response::FORMAT_JSON;

        $model = new Collection();
        $model->load(Yii::$app->request->post());

        return ActiveForm::validate($model);
    }
}
