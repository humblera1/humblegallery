<?php

namespace common\modules\painting\controllers\frontend;

use common\components\filters\SelfHealingUrlFilter;
use common\modules\artist\models\data\Artist;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\search\PaintingSearch;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * @property Painting $model
 */
class DefaultController extends Controller
{
    public function behaviors()
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
                'only' => ['toggle-like', 'collections'],
            ],
            [
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
    public function actionToggleLike()
    {
        $this->response->format = Response::FORMAT_JSON;

        $paintingId = $this->request->post('paintingId');
        $painting = Painting::findOne($paintingId);

        if (!$painting) {
            throw new NotFoundHttpException("Painting with ID $paintingId not found.");
        }

        return [
            'success' => $painting->service->toggleLike(),
        ];
    }




    public function actionGetUserCollections(): string
    {
        return $this->renderPartial('includes/_collections', ['collections' => Yii::$app->user->identity->getCollections()]);
    }

    protected function getProvider(): ActiveDataProvider
    {
        $searchModel = new PaintingSearch();

        return $searchModel->search($this->request->post());
    }
}