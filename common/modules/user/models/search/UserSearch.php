<?php

namespace common\modules\user\models\search;

use common\modules\user\models\data\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form of `common\models\data\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [
                [
                    'username',
                    'email',
                    'name',
                    'surname',
                    'created_at',
                ],
                'string',
            ],
            [
                ['created_at'],
                'filter',
                'filter' => function ($value) {
                    return $value !== null ? strtotime($value) : null;
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->created_at) {
            $query->andFilterWhere([
                'AND' => [
                    ['>=','created_at', $this->created_at],
                    ['<', 'created_at', $this->created_at + 24*60*60],
                ],
            ]);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname]);

        return $dataProvider;
    }
}
