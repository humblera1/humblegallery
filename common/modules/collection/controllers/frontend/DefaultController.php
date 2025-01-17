<?php

namespace common\modules\collection\controllers\frontend;

use common\components\FrontendController;
use common\modules\collection\models\data\Collection;
use common\modules\collection\models\form\AddPaintingToNewCollectionForm;
use common\modules\collection\models\form\PaintingCollectionForm;
use common\modules\collection\models\service\CollectionService;
use common\modules\painting\models\data\PaintingCollection;
use Exception;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `collection` module
 */
class DefaultController extends FrontendController
{
    /** {@inheritdoc} */
    public function behaviors(): array
    {
        return [
//            'access' => [
//                'class' => AccessControl::class,
//                'only' => ['get-form', 'get-list', 'create-and-add', 'toggle-painting', 'edit-form'],
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'ajax' => [
//                'class' => AjaxFilter::class,
//                'only' => ['get-form', 'get-list', 'create-and-add', 'validate-form', 'toggle-painting'],
//            ],
        ];
    }

    /**
     * Возвращает форму создания коллекции.
     *
     * @param int $paintingId
     * @return string
     */
    public function actionGetForm(int $paintingId): string
    {
        return $this->renderAjax('includes/_collections-form', [
            'model' => new AddPaintingToNewCollectionForm(),
            'paintingId' => $paintingId,
        ]);
    }

    /**
     * @return string
     */
    public function actionCreateForm(): string
    {
        return $this->renderAjax('includes/_edit-form', [
            'model' => new Collection(),
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEditForm(int $id): string
    {
        return $this->renderAjax('includes/_edit-form', [
            'model' => $this->getCollectionToEdit($id),
        ]);
    }

    /**
     * Обеспечивает AJAX-валидацию формы.
     *
     * @return array
     */
    public function actionValidateForm(): array
    {
        $this->response->format = Response::FORMAT_JSON;

        $model = new Collection();
        $model->load(Yii::$app->request->post());

        return ActiveForm::validate($model);
    }

    public function actionCreate(): array
    {
        $model = new Collection();
        $model->loadWithFile($this->request->post());

        if ($model->validate() && $model->service->saveCollectionWithFile()) {
            return $this->successResponse('Коллекция успешно создана!');
        }

        return $this->errorResponse('Не удалось создать коллекцию');
    }

    /**
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): array
    {
        $model = $this->getCollectionToEdit($id);
        $model->loadWithFile($this->request->post());

        if ($model->validate() && $model->service->saveCollectionWithFile()) {
            return $this->successResponse('Коллекция успешно обновлена!');
        }

        return $this->errorResponse('Не удалось обновить коллекцию');
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDelete(int $id): string
    {
        $model = $this->getCollectionToEdit($id);

        if ($model->softDelete()) {
            return 'ok';
        }

        return 'not ok';
    }

    public function actionRestore(int $id): string
    {
        $model = $this->getCollectionToEdit($id);

        if ($model->restore()) {
            return 'ok';
        }

        return 'not ok';
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
     * Отвечает за создание новой коллекции с последующим добавлением картины.
     *
     * @throws Exception
     */
    public function actionCreateAndAdd(): array
    {
        $success = Yii::$container->get(CollectionService::class)->performCreateAndAdd($this->request->post());

        if (!$success) {
            return $this->errorResponse('Не удалось создать коллекцию');
        }

        return $this->successResponse('Картина успешно добавлена в новую коллекцию!');
    }

//    /**
//     * Обеспечивает AJAX-валидацию формы.
//     *
//     * @return array
//     */
//    public function actionValidateForm(): array
//    {
//        $this->response->format = Response::FORMAT_JSON;
//
//        $model = new AddPaintingToNewCollectionForm();
//        $model->load(Yii::$app->request->post());
//
//        return ActiveForm::validate($model);
//    }

    /**
     * Обрабатывает добавление или удаление картины из существующей коллекции.
     *
     * @return array
     */
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

    /**
     * @param int $collectionId
     * @return Collection
     * @throws NotFoundHttpException
     */
    protected function getCollectionToEdit(int $collectionId): Collection
    {
        /** @var Collection $collection */
        $collection = Yii::$app->user->identity
            ->getCollections()
            ->where(['id' => $collectionId])
            ->one();

        if (!$collection) {
            throw new NotFoundHttpException();
        }

        return $collection;
    }
}
