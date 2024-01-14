<?php

namespace common\modules\painting\controllers\frontend;

use common\modules\painting\models\data\PaintingLike;
use common\modules\painting\models\search\PaintingSearch;
use Exception;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\StaleObjectException;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index', [
            'dataProvider' => $this->getProvider(),
        ]);
    }

    public function actionApplyFilters(): string
    {
        if ($this->request->isAjax) {
            return $this->renderPartial('includes/_content', [
                'provider' => $this->getProvider()
            ]);
        }

        throw new Exception();
    }

    /**
     * This function handles the action of liking a painting.
     *
     * @throws Exception if the request is not an AJAX request.
     * @throws StaleObjectException|Throwable if deleting fails
     */
    public function actionLike(): bool
    {
        if ($this->request->isAjax) {
            $tableName = PaintingLike::tableName();

            $userId = Yii::$app->user->getId();
            $paintingId = Yii::$app->request->post('paintingId');

            $isLike = Yii::$app->request->post('isLike');

            if ($isLike) {
                return Yii::$app->db->createCommand()
                    ->insert($tableName, [
                        'user_id' => $userId,
                        'painting_id' => $paintingId,
                    ])->execute();
            }

            return Yii::$app->db->createCommand()
                ->delete($tableName, [
                    'user_id' => $userId,
                    'painting_id' => $paintingId
                ])->execute();
        }

        throw new Exception();
    }

    protected function getProvider(): ActiveDataProvider
    {
        $searchModel = new PaintingSearch();

        return $searchModel->search($this->request->post());
    }
}