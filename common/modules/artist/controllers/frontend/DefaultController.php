<?php

namespace common\modules\artist\controllers\frontend;

use common\components\filters\SelfHealingUrlFilter;
use common\modules\artist\models\data\Artist;
use common\modules\artist\models\search\ArtistSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * @property Artist $model
 */
class DefaultController extends Controller
{
    public function behaviors(): array
    {
        return [
            [
                'class' => SelfHealingUrlFilter::class,
                'only' => [
                    'view',
                ],
                'modelClass' => Artist::class,
            ],
        ];
    }

    public function actionIndex(): string
    {
        $model = new ArtistSearch();

        return $this->render('index', [
            'dataProvider' => $this->getProvider(loadRelations: true),
            'model' => $model,
        ]);
    }

    public function actionView(): string
    {
        return $this->render('view', [
            'model' => $this->model,
        ]);
    }

    protected function getProvider($loadRelations = false): ActiveDataProvider
    {
        $searchModel = new ArtistSearch();

        return $searchModel->search($this->request->post(), $loadRelations);
    }
}