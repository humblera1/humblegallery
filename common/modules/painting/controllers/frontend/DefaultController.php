<?php

namespace common\modules\painting\controllers\frontend;

use common\modules\painting\models\search\PaintingSearch;
use Exception;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index', [
            'dataProvider' => $this->getProvider(),
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

    public function getProvider(): ActiveDataProvider
    {
        $searchModel = new PaintingSearch();

        return $searchModel->search($this->request->post());
    }
}