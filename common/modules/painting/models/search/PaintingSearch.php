<?php

namespace common\modules\painting\models\search;

use common\components\ActiveSearchModel;
use common\modules\painting\models\data\Painting;
use common\modules\subject\models\data\Subject;
use yii\db\ActiveQuery;

class PaintingSearch extends ActiveSearchModel
{
    public array $subjects = [];

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['subjects'], 'safe'],
            ],
        );
    }

    public function buildQuery(): ActiveQuery
    {
        $query = Painting::find()->alias('p')
        ->joinWith(['subjects']);

        return $query;
    }

    public function applyFilter(ActiveQuery $query)
    {
        $query->andFilterWhere([Subject::tableName() . '.id' => $this->subjects]);
    }
}