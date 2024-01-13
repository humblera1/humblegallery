<?php

namespace common\components;

use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller as BaseWebController;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * CrudController implements the CRUD actions for a model, specified by the `model` property.
 * You need to define the model (searchModel also) yourself by implementing the method `initController()`
 */
abstract class CrudController extends BaseWebController
{
    public string $model;
    public string $searchModel;
    public string $form;

    /** {@inheritDoc} */
    public function init()
    {
        $this->initController();
        parent::init();
    }

    /** {@inheritDoc} */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex(): string
    {
        $searchModel = new $this->searchModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate(): string|Response
    {
        $model = new $this->model();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id): string|Response
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function findModel($value, $field = 'id'): ?ActiveRecord
    {
        if (($model = $this->model::findOne([$field => $value])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist');
    }

    /**
     * This method will be called by init() to initialize the controller properties, such as
     * `model`, `searchModel` and `form`.
     *
     * For example:
     *  ```php
     *  $this->model = ExampleModel::class,
     *  $this->searchModel = ExampleSearchModel::class,
     *  ```
     */
    abstract protected function initController(): void;
}
