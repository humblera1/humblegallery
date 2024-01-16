<?php

namespace common\modules\user\controllers\frontend;

use yii\web\Controller;

class DefaultController extends Controller
{

    function actionPersonalArea(): string
    {
        return $this->render('personal-area');
    }

}