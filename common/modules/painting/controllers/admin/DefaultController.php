<?php

namespace common\modules\painting\controllers\admin;

use common\components\CrudController;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\search\PaintingSearch;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * DefaultController implements the CRUD actions for Painting model.
 *
 * @var Painting $model
 */
class DefaultController extends CRUDController
{
    /** {@inheritDoc} */
    public function initController(): void
    {
        $this->model = Painting::class;
        $this->searchModel = PaintingSearch::class;
    }

    /** {@inheritDoc} */
    public function actionCreate(): string|Response
    {
        $model = new Painting();

        if ($this->request->isPost) {
            $model->setScenario(Painting::SCENARIO_CREATE);

            $model->load($this->request->post());
            $model->image = UploadedFile::getInstance($model, 'image');

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /** {@inheritDoc} */
    public function actionUpdate($id): string|Response
    {
        /** @var Painting $model */
        $model = $this->findModel($id);

        if ($this->request->isPost) {

            $model->load($this->request->post());
            $model->image = UploadedFile::getInstance($model, 'image');

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
