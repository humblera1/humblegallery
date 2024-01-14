<?php

namespace common\modules\artist\controllers\admin;

use common\components\CrudController;
use common\modules\artist\models\data\Artist;
use common\modules\artist\models\search\ArtistSearch;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * DefaultController implements the CRUD actions for Artist model.
 */
class DefaultController extends CRUDController
{
    /** {@inheritDoc} */
    public function initController(): void
    {
        $this->model = Artist::class;
        $this->searchModel = ArtistSearch::class;
    }

    /** {@inheritDoc} */
    public function actionCreate(): string|Response
    {
        $model = new $this->model();

        if ($this->request->isPost) {
            $model->setScenario(Artist::SCENARIO_CREATE);

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
