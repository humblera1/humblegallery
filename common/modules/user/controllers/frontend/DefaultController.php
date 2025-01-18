<?php

namespace common\modules\user\controllers\frontend;

use common\components\filters\SelfHealingUrlFilter;
use common\components\FrontendController;
use common\modules\collection\models\data\Collection;
use common\modules\collection\models\form\CollectionPaintingSearch;
use common\modules\user\models\data\User;
use common\modules\user\models\forms\EditForm;
use common\modules\user\models\forms\SettingsForm;
use common\modules\user\models\search\UserCollectionSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
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

    public function behaviors()
    {
        return [
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
     * @return string
     */
    public function actionView(): string
    {
        $form = new EditForm($this->currentUser);

        $isOwner = Yii::$app->user->identity?->id === $this->currentUser->id;

        if ($isOwner) {
            if ($form->load($this->request->post())) {
                $form->file = UploadedFile::getInstance($form, 'file');

                if ($form->validate() && $form->saveChanges()) {
                    Yii::$app->session->setFlash('success', 'Данные профиля успешно обновлены!');
                }
            }
        }

        return $this->render('view', [
            'user' => $this->currentUser,
            'model' => $form,
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

        return $this->render('collection-view', [
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

    /**
     * @throws NotFoundHttpException
     */
    protected function findUser(string $username): User
    {
        $user = User::findOne(['username' => $username]);

//        if (!$user) {
//            throw new NotFoundHttpException();
//        }

        return $user;
    }


//    /**
//     * @throws NotFoundHttpException
//     */
//    public function actionProfile($section): string
//    {
//        if (!in_array($section, ProfileSectionsEnum::getLabels())) {
//            throw new NotFoundHttpException();
//        }
//
//        if ($this->request->isAjax) {
//            return match ($section)  {
//                'info' => $this->getInfo(),
//                'collections' => $this->getCollections(),
//                'courses' => $this->getCourses(),
//                'favorites' => $this->getFavorites(),
//                'settings' => $this->getSettings(),
//                default => throw new NotFoundHttpException('Not found section ' . $section),
//
//            };
//        }
//
//        return $this->render('sections/info');
//    }
//
//    protected function getInfo(): string
//    {
//        return $this->renderPartial('sections/info');
//    }
//
//    public function getCollections(): string
//    {
//        $model = new Collection();
//
//        if ($model->load($this->request->post())) {
//            $model->user_id = Yii::$app->user->id;
//
//            $model->save();
//        }
//
//        $searchModel = new UserCollectionSearch();
//
//        $dataProvider = $searchModel->search($this->request->post());
//
//        return $this->renderAjax('sections/collections', [
//            'model' => $model,
//            'searchModel' => $searchModel,
//            'provider' => $dataProvider,
//        ]);
//    }
//
//    protected function getCourses()
//    {
//        return $this->renderPartial('sections/courses');
//    }
//
//
//    protected function getFavorites(): string
//    {
//        $searchModel = new FavoritePaintingSearch();
//        $dataProvider = $searchModel->search($this->request->post());
//
//        return $this->renderAjax('sections/favorites', [
//            'model' => $searchModel,
//            'provider' => $dataProvider,
//        ]);
//    }
//
//    protected function getSettings()
//    {
//        return $this->renderPartial('sections/settings');
//    }
}