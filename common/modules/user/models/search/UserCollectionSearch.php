<?php

namespace common\modules\user\models\search;

use common\modules\collection\models\data\Collection;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserCollectionSearch extends Collection
{
    /** {@inheritdoc} */
    public function rules(): array
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /** {@inheritdoc} */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     */
    public function search(array $params): ActiveDataProvider
    {
        $user = Yii::$app->user->identity;
        $query = $user->getCollections();

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
