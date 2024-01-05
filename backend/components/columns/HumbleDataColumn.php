<?php

namespace backend\components\columns;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\ActiveQueryInterface;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\helpers\Inflector;

class HumbleDataColumn extends DataColumn
{
    public $label = false;
    protected function renderFilterCellContent()
    {
        if (is_string($this->filter)) {
            return $this->filter;
        }

        $model = $this->grid->filterModel;

        if ($this->filter !== false && $model instanceof Model && $this->filterAttribute !== null && $model->isAttributeActive($this->filterAttribute)) {
            $filterInputOptions = array_merge(
                $this->filterInputOptions,
                [
                    'placeholder' => $this->getFilterCellLabel(),
                ]
            );
            if ($model->hasErrors($this->filterAttribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' ' . Html::error($model, $this->filterAttribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            if (is_array($this->filter)) {
                $options = array_merge(
                    [
                        'prompt' => '',
                        'strict' => true
                    ],
                    $filterInputOptions
                );
                return Html::activeDropDownList($model, $this->filterAttribute, $this->filter, $options) . $error;
            } elseif ($this->format === 'boolean') {
                $options = array_merge(['prompt' => '', 'strict' => true], $filterInputOptions);
                return Html::activeDropDownList($model, $this->filterAttribute, [
                        1 => $this->grid->formatter->booleanFormat[1],
                        0 => $this->grid->formatter->booleanFormat[0],
                    ], $options) . $error;
            }
            $options = array_merge(['maxlength' => true], $filterInputOptions);

            return Html::activeTextInput($model, $this->filterAttribute, $options) . $error;
        }

        return parent::renderFilterCellContent();
    }

    protected function getFilterCellLabel()
    {
        $provider = $this->grid->dataProvider;

        if ($this->attribute === null) {
            $label = '';
        } elseif ($provider instanceof ActiveDataProvider && $provider->query instanceof ActiveQueryInterface) {
            /* @var $modelClass Model */
            $modelClass = $provider->query->modelClass;
            $model = $modelClass::instance();
            $label = $model->getAttributeLabel($this->attribute);
        } elseif ($provider instanceof ArrayDataProvider && $provider->modelClass !== null) {
            /* @var $modelClass Model */
            $modelClass = $provider->modelClass;
            $model = $modelClass::instance();
            $label = $model->getAttributeLabel($this->attribute);
        } elseif ($this->grid->filterModel !== null && $this->grid->filterModel instanceof Model) {
            $label = $this->grid->filterModel->getAttributeLabel($this->filterAttribute);
        } else {
            $models = $provider->getModels();
            if (($model = reset($models)) instanceof Model) {
                /* @var $model Model */
                $label = $model->getAttributeLabel($this->attribute);
            } else {
                $label = Inflector::camel2words($this->attribute);
            }
        }


        return $label;
    }

}