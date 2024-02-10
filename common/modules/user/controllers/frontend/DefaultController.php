<?php

namespace common\modules\user\controllers\frontend;

use common\modules\user\models\data\User;
use common\modules\user\models\enums\ProfileSectionsEnum;
use common\modules\user\models\forms\EditForm;
use common\modules\user\models\forms\LoginForm;
use common\modules\user\models\forms\SignupForm;
use common\modules\user\models\search\FavoritePaintingSearch;
use common\modules\user\models\search\UserFavoritesSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class DefaultController extends Controller
{
    public $layout = 'profile';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['personal-area'],
                'rules' => [
                    [
                        'actions' => ['personal-area'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    $cache = Yii::$app->cache;
                    $cache->set('needToShowLoginModal', true, 10);

                    return $this->redirect('/');
                },
            ],
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionProfile($section): string
    {
        if (!in_array($section, ProfileSectionsEnum::getLabels())) {
            throw new NotFoundHttpException();
        }

        if ($this->request->isAjax) {
            return match ($section)  {
                'info' => $this->getInfo(),
                'collections' => $this->getCollections(),
                'courses' => $this->getCourses(),
                'favorites' => $this->getFavorites(),
                'settings' => $this->getSettings(),
                default => throw new NotFoundHttpException('Not found section ' . $section),

            };
        }

        return $this->render('sections/info');
    }

    protected function getInfo(): string
    {
        return $this->renderPartial('sections/info');
    }

    public function getCollections(): string
    {
        return $this->renderPartial('sections/collections');
    }

    protected function getCourses()
    {
        return $this->renderPartial('sections/courses');
    }


    protected function getFavorites(): string
    {
        $searchModel = new FavoritePaintingSearch();
        $dataProvider = $searchModel->search($this->request->post());

        return $this->renderAjax('sections/favorites', [
            'model' => $searchModel,
            'provider' => $dataProvider,
        ]);
    }

    protected function getSettings()
    {
        return $this->renderPartial('sections/settings');
    }

    /**
     * New user registration action
     */
    public function actionSignup(): string|Response
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(['personal-area', 'id' => Yii::$app->user->id]);
        }

        return $this->renderAjax('includes/_signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logs in a user
     */
    public function actionLogin(): string|Response
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['personal-area', 'id' => Yii::$app->user->id]);
        }

        $model->password = '';

        return $this->renderAjax('includes/_login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionValidateLogin(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new LoginForm();
        $model->load(Yii::$app->request->post());

        return ActiveForm::validate($model);
    }

    public function actionValidateSignup(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new SignupForm();
        $model->load(Yii::$app->request->post());

        return ActiveForm::validate($model);
    }
}