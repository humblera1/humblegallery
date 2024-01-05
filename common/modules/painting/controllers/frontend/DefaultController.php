<?php

namespace common\modules\painting\controllers\frontend;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }

}