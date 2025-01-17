<?php

namespace common\modules\collection\controllers\frontend;

use common\components\FrontendController;
use common\modules\collection\models\data\Collection;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\filters\VerbFilter;
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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => AjaxFilter::class,
                'only' => [
                    'create-form',
                    'edit-form',
                    'with-painting-form',
                    'available-collections',
                    'validate-form',
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create-form' => ['GET'],
                    'edit-form' => ['GET'],
                    'with-painting-form' => ['GET'],
                    'available-collections' => ['GET'],
                    'validate-form' => ['POST'],
                    'create' => ['POST'],
                    'create-with-painting' => ['POST'],
                    'update' => ['POST'],
                    'toggle-painting' => ['POST'],
                    'restore' => ['PATCH'],
                    'delete' => ['DELETE'],
                ],
            ],
        ];
    }

    /**
     * Возвращает форму создания коллекции.
     *
     * @return string
     */
    public function actionCreateForm(): string
    {
        return $this->renderAjax('includes/_form', [
            'model' => new Collection(),
        ]);
    }

    /**
     * Возвращает форму редактирования коллекции.
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEditForm(int $id): string
    {
        return $this->renderAjax('includes/_form', [
            'model' => $this->getCollectionToEdit($id),
        ]);
    }

    /**
     * Возвращает форму создания коллекции с выбранной картиной.
     *
     * @param int $paintingId
     * @return string
     */
    public function actionWithPaintingForm(int $paintingId): string
    {
        return $this->renderAjax('includes/_with-painting-form', [
            'model' => new Collection(),
            'paintingId' => $paintingId,
        ]);
    }

    /**
     * @param int $paintingId
     * @return string
     */
    public function actionAvailableCollections(int $paintingId): string
    {
        $collections = Yii::$app->user->identity->service->getMarkedCollections($paintingId);

        if ($collections) {
            return $this->renderPartial('includes/_collections-list', [
                'collections' => $collections,
            ]);
        }

        return $this->actionWithPaintingForm($paintingId);
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

    /**
     * @return array
     */
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
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): array
    {
        $model = $this->getCollectionToEdit($id);

        if ($model->softDelete()) {
            return $this->successResponse('Коллекция помещена в архив');
        }

        return $this->errorResponse('Не удалось удалить коллекцию');
    }

    /**
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionRestore(int $id): array
    {
        $model = $this->getCollectionToEdit($id);

        if ($model->restore()) {
            return $this->successResponse('Коллекция восстановлена из архива!');
        }

        return $this->errorResponse('Не удалось восстановить коллекцию из архива');
    }

    /**
     * Отвечает за создание новой коллекции с последующим добавлением картины.
     *
     * @throws Exception
     */
    public function actionCreateWithPainting(): array
    {
        $collection = new Collection();
        $collection->load($this->request->post());

        if ($collection->validate() && $collection->service->createCollectionWithPainting($this->request->post('painting_id'))) {
            return $this->successResponse('Картина успешно добавлена в новую коллекцию!');
        }

        return $this->errorResponse('Не удалось создать коллекцию');
    }

    /**
     * Обрабатывает добавление или удаление картины из существующей коллекции.
     * @throws NotFoundHttpException
     */
    public function actionTogglePainting(int $id, int $paintingId): array
    {
        $collection = $this->getCollectionToEdit($id);

        if ($collection->service->togglePainting($paintingId)) {
            return $this->successResponse('Коллекция успешно обновлена!');
        }

        return $this->errorResponse('Не удалось обновить коллекцию');
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
