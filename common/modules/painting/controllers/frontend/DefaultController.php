<?php

namespace common\modules\painting\controllers\frontend;

use common\modules\collection\models\form\AddPaintingToNewCollectionForm;
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