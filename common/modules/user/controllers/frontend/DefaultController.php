<?php

namespace common\modules\user\controllers\frontend;

use common\modules\user\models\data\User;
use common\modules\user\models\forms\LoginForm;
use common\modules\user\models\forms\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class DefaultController extends Controller
{

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

    public function actionPersonalArea(int $id): string
    {
        $model = User::findOne($id);

        return $this->render('personal-area', [
            'model' => $model,
        ]);
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