<?php

namespace common\modules\user\controllers\frontend;

use common\components\filters\SelfHealingUrlFilter;
use common\components\FrontendController;
use common\modules\collection\models\data\Collection;
use common\modules\collection\models\form\CollectionPaintingSearch;
use common\modules\user\models\data\User;
use common\modules\user\models\forms\SettingsForm;
use common\modules\user\models\search\UserCollectionSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class DefaultController extends FrontendController
{
    public $layout = 'profile';

    protected ?User $currentUser = null;

    /**
     * Сигнализирует о том, что профиль просматривается владельцем.
     */
    protected bool $isOwner = false;

    /**
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        $username = $this->request->get('username');

        if ($username !== null) {
            $this->currentUser = User::findOne(['username' => $username, 'is_blocked' => false]);

            if ($this->currentUser === null) {
                throw new NotFoundHttpException('Пользователь не найден');
            }

            $this->isOwner = Yii::$app->user->identity?->id === $this->currentUser->id;

            if (!$this->isOwner && $this->currentUser->is_closed) {
                $this->layout = '@frontend/views/layouts/main';

                echo $this->render('profile-closed');

                return false;
            }
        }

        return parent::beforeAction($action);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'settings',
                    'validate-setting',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Allow access only if the current user is the owner of the profile
                            return $this->isOwner;
                        },
                    ],
                ],
            ],
            'ajax' => [
                'class' => AjaxFilter::class,
                'only' => [
                    'validate-setting',
                ],
            ],
            'selfHealingUrl' => [
                'class' => SelfHealingUrlFilter::class,
                'only' => [
                    'collection-view',
                ],
                'modelClass' => Collection::class,
                'queryConstraints' => function ($query) {
                    // Только публичные и не архивированные коллекции, если они запрашиваются не владельцем
                    if (!$this->isOwner) {
                        $query->andWhere([
                            'is_private' => false,
                            'is_archived' => false,
                        ]);
                    }
                },
            ],
        ];
    }

    /**
     * @return string|array
     */
    public function actionView(): string|array|Response
    {
        if ($this->isOwner && $this->request->isPost) {
            $this->currentUser->load($this->request->post());

            if ($this->currentUser->validate() && $this->currentUser->save()) {
                Yii::$app->session->setFlash('success', 'Данные профиля успешно обновлены!');

                return $this->redirect($this->currentUser->username);
            } else {
                return $this->errorResponse('Не удалось обновить данные профиля');
            }
        }

        return $this->render('view', [
            'user' => $this->currentUser,
        ]);
    }

    public function actionCollections(): string
    {
        $model = new UserCollectionSearch($this->currentUser);

        return $this->render('collections', [
            'user' => $this->currentUser,
            'model' => $model,
            'provider' => $model->search($this->request->post()),
        ]);
    }

    public function actionCollectionView(): string
    {
        $model = new CollectionPaintingSearch($this->model);

        return $this->render('collection', [
            'user' => $this->currentUser,
            'model' => $model,
            'provider' => $model->search($this->request->post()),
        ]);
    }

    public function actionFavorites(): string
    {
        return $this->render('favorites', [
            'provider' => new ActiveDataProvider([
                'query' => $this->currentUser->getFavoritePaintings(),
                'pagination' => [
                    'pageSize' => Yii::$app->params['paintingsPerPage'],
                ],
            ]),
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionSettings(): string|array
    {
        $form = new SettingsForm();

        if ($this->request->isPost) {
            $form->load($this->request->post());

            if ($form->validate() && $form->saveChanges()) {
                return $this->successResponse('Настройки профиля успешно обновлены!');
            }

            return $this->errorResponse('Не удалось обновить настройки профиля');
        }

        return $this->render('settings', [
            'model' => $form
        ]);
    }

    public function actionValidateSettings(): array
    {
        $this->response->format = Response::FORMAT_JSON;

        $model = new SettingsForm();
        $model->load(Yii::$app->request->post());

        return ActiveForm::validate($model);
    }
}
