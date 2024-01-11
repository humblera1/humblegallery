<?php

namespace common\modules\painting\controllers\frontend;

use common\modules\painting\models\data\Painting;
use common\modules\painting\models\search\PaintingSearch;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Painting::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $query = Painting::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function createPagination()
    {
        
    }

    public function actionApplyFilters()
    {
        if ($this->request->isAjax) {
            $searchModel = new PaintingSearch();
            $dataProvider = $searchModel->search($this->request->post());

            return $this->renderPartial('includes/_content', ['provider' => $dataProvider]);
        }

        throw new \Exception();
    }
}