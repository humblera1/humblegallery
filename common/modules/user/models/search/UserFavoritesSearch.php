<?php

namespace common\modules\user\models\search;

use common\modules\painting\models\data\Painting;
use Yii;
use yii\data\ActiveDataProvider;

class UserFavoritesSearch extends Painting
{
    public function rules(): array
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Yii::$app->user->identity->getLikedPaintings();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}