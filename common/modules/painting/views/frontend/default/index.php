<?php

use yii\helpers\Html;

$model = \common\modules\painting\models\data\Painting::findOne(2);

echo Html::img($model->service->getImagePath()); ?>
