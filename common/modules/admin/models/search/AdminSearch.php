<?php

namespace common\modules\admin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Admin;

/**
 * AdminSearch represents the model behind the search form of `common\models\Admin`.
 */
class AdminSearch extends Admin
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'string'],
            [['created_at', 'updated_at'], 'date', 'format' => 'php:d.m.Y'],
            [['created_at', 'updated_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
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
        $query = Admin::find();

        $query->andWhere(['!=', 'id', 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->created_at) {
            $query->andFilterWhere([
                'AND',
                ['>', 'created_at', $this->created_at],
                ['<=', 'created_at', $this->created_at + 24*60*60],
            ]);
        }

        if ($this->updated_at) {
            $query->andFilterWhere([
                'AND',
                ['>', 'updated_at', $this->updated_at],
                ['<=', 'updated_at', $this->updated_at + 24*60*60],
            ]);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
