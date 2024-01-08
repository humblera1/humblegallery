<?php

namespace common\modules\painting\controllers\frontend;

use common\modules\painting\models\data\Painting;
use yii\data\Pagination;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
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
}