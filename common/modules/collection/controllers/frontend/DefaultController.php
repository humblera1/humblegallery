<?php

namespace common\modules\collection\controllers\frontend;

use common\components\FrontendController;
use common\modules\collection\models\data\Collection;
use common\modules\collection\models\form\AddPaintingToNewCollectionForm;
use common\modules\collection\models\form\PaintingCollectionForm;
use common\modules\collection\models\service\CollectionService;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\data\PaintingCollection;
use common\modules\user\models\data\User;
use Exception;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `collection` module
 */
class DefaultController extends FrontendController
{
    /** {@inheritdoc} */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['get-form', 'get-list'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => AjaxFilter::class,
                'only' => ['get-form', 'get-list'],
            ],
        ];
    }

    /**
     * Возвращает форму создания коллекции.
     */
    public function actionGetForm(int $paintingId): string
    {
        return $this->renderAjax('includes/_collections-form', [
            'model' => new AddPaintingToNewCollectionForm(),
            'paintingId' => $paintingId,
        ]);
    }


    /**
     * Return collection creation template to display it in modal window
     *
     * @throws Exception
     */
    public function actionGetNewCollection(): string
    {
        if ($this->request->isAjax) {
            return $this->renderAjax('includes/_new');
        }

        throw new Exception();
    }

    /**
     * Returns ids of all collections, containing specific painting
     */
    public function actionGetPaintingCollections($paintingId): string
    {
        $painting = Painting::findOne($paintingId);

        return Json::encode($painting->service->getCollectionsIdsByUser());
    }

    /**
     * @throws Exception
     */
    public function actionCreateAndAdd(): array
    {
        $this->response->format = Response::FORMAT_JSON;

        $indicator = Yii::$container->get(CollectionService::class)->performCreateAndAdd($this->request->post());

        return [
            'success' => $indicator,
        ];
    }

    /**
     * Обеспечивает AJAX-валидацию формы.
     *
     * @return array
     */
    public function actionValidateForm(): array
    {
        $this->response->format = Response::FORMAT_JSON;

        $model = new AddPaintingToNewCollectionForm();
        $model->load(Yii::$app->request->post());

        return ActiveForm::validate($model);
    }
}
