<?php

namespace common\modules\collection\controllers\frontend;

use common\components\FrontendController;
use common\modules\collection\models\form\AddPaintingToNewCollectionForm;
use common\modules\collection\models\form\PaintingCollectionForm;
use common\modules\collection\models\service\CollectionService;
use common\modules\painting\models\data\PaintingCollection;
use Exception;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `collection` module
 */
class DefaultController extends FrontendController
{
    /** {@inheritdoc} */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['get-form', 'get-list'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => AjaxFilter::class,
                'only' => ['get-form', 'get-list'],
            ],
        ];
    }

    /**
     * Возвращает форму создания коллекции.
     */
    public function actionGetForm(int $paintingId): string
    {
        return $this->renderAjax('includes/_collections-form', [
            'model' => new AddPaintingToNewCollectionForm(),
            'paintingId' => $paintingId,
        ]);
    }


    /**
     * Возвращает набор коллекций пользователя или форму для создания коллекции, если у пользователя их нет.
     * Данный контент отображается в модальном окне при попытке добавить картину в коллекцию.
     *
     * @param int $paintingId
     * @return string
     */
    public function actionGetList(int $paintingId): string
    {
        $collections = Yii::$app->user->identity->service->getCollectionsContainingPainting($paintingId);

        if ($collections) {
            return $this->renderPartial('includes/_collections-list', [
                'collections' => $collections,
            ]);
        }

        return $this->actionGetForm($paintingId);
    }

    /**
     * @throws Exception
     */
    public function actionCreateAndAdd(): array
    {
        $this->response->format = Response::FORMAT_JSON;

        $indicator = Yii::$container->get(CollectionService::class)->performCreateAndAdd($this->request->post());

        return [
            'success' => $indicator,
        ];
    }

    /**
     * Обеспечивает AJAX-валидацию формы.
     *
     * @return array
     */
    public function actionValidateForm(): array
    {
        $this->response->format = Response::FORMAT_JSON;

        $model = new AddPaintingToNewCollectionForm();
        $model->load(Yii::$app->request->post());

        return ActiveForm::validate($model);
    }


    public function actionTogglePainting(): array
    {
        $paintingCollection = new PaintingCollectionForm();
        $paintingCollection->load([
            'collection_id' => $this->request->post('collectionId'),
            'painting_id' => $this->request->post('paintingId'),
        ], '');

        if (!$paintingCollection->validate()) {
            return $this->errorResponse(implode(', ', $paintingCollection->getFirstErrors()));
        }

        $existingRecord = PaintingCollection::findOne([
            'painting_id' => $paintingCollection->painting_id,
            'collection_id' => $paintingCollection->collection_id,
        ]);

        try {
            if ($existingRecord) {
                $existingRecord->delete();
                $message = 'Картина успешно удалена из коллекции';
            } else {
                $paintingCollection->save();
                $message = 'Картина успешно добавлена в коллекцию';
            }
        } catch (Throwable $exception) {
            return $this->errorResponse($exception->getMessage());
        }

        return $this->successResponse($message);
    }
}
