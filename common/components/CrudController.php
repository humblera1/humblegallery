<?php

namespace common\components;

use Throwable;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
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

    /**
     * Lists all models
     */
    public function actionIndex(): string
    {
        $searchModel = new $this->searchModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single model
     */
    public function actionView($id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page
     */
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

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException if [[optimisticLock|optimistic locking]] is enabled and the data being deleted is outdated
     * @throws Throwable in case delete failed
     */
    public function actionDelete($id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown
     *
     * @throws NotFoundHttpException
     */
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
     * See usage example below:
     *  ```php
     *  $this->model = ExampleModel::class,
     *  $this->searchModel = ExampleSearchModel::class,
     *  ```
     */
    abstract protected function initController(): void;
}
