<?php

namespace common\modules\painting\controllers\frontend;

use common\components\filters\SelfHealingUrlFilter;
use common\components\FrontendController;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\search\PaintingSearch;
use Exception;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\NotFoundHttpException;

/**
 * @property Painting $model
 */
class DefaultController extends FrontendController
{
    /** {@inheritdoc} */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['toggle-like'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => AjaxFilter::class,
                'only' => ['toggle-like'],
            ],
            'selfHealingUrl' => [
                'class' => SelfHealingUrlFilter::class,
                'only' => [
                    'view',
                ],
                'modelClass' => Painting::class,
            ],
        ];
    }

    public function actionIndex(): string
    {
        $model = new PaintingSearch();

        return $this->render('index', [
            'dataProvider' => $this->getProvider(),
            'model' => $model,
        ]);
    }

    public function actionView(): string
    {
        return $this->render('view', [
            'model' => $this->model,
        ]);
    }

    /**
     * This function handles the action of liking a painting.
     *
     * @throws Exception if the request is not an AJAX request.
     */
    public function actionToggleLike(int $id): array
    {
        $painting = Painting::findOne($id);

        if (!$painting) {
            throw new NotFoundHttpException("Painting with ID $id not found.");
        }

        $success = $painting->service->toggleLike();

        if (!$success) {
            return $this->errorResponse('Не удалось выполнить запрос');
        }

        return $this->successResponse();
    }

    protected function getProvider(): ActiveDataProvider
    {
        $searchModel = new PaintingSearch();

        return $searchModel->search($this->request->post());
    }
}