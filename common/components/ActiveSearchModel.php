<?php

namespace common\components;

use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;

abstract class ActiveSearchModel extends Model
{
    public int $page = 0;
    public int $per_page = 100;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['page', 'per_page'], 'safe'],
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    public function search(array $params): ActiveDataProvider
    {
        $this->load($params);

        $query = $this->buildQuery();
        $provider = $this->buildProvider($query);

        if (!$this->validate()) {
            return $provider;
        }

        $this->applyFilter($query);

        return $provider;
    }

    abstract protected function buildQuery(): ActiveQuery;

    /**
     * @throws InvalidConfigException
     */
    protected function buildProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'pagination' => $this->buildPagination(),
            'sort' => $this->buildSort(),
            'query' => $query,
        ]);
    }

    /**
     * @throws InvalidConfigException
     */
    protected function buildPagination(): array
    {
        return [
            'class' => Pagination::class,
            'page' => $this->page - 1,
            'pageParam' => $this->formName() . '[page]',
            'pageSize' => $this->per_page,
            'pageSizeParam' => $this->formName() . '[per_page]',
            'pageSizeLimit' => false,
        ];
    }

    protected function buildSort(): array
    {
        return [];
    }

    protected function applyFilter(ActiveQuery $query)
    {
    }
}
