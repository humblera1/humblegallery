<?php

namespace common\modules\user\controllers\frontend;

use common\models\LoginForm;
use common\modules\user\models\forms\RegisterForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class DefaultController extends Controller
{
    /**
     * New user registration action
     */
    public function actionRegister(): string|Response
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('includes/_signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logs in a user
     */
    public function actionLogin(): string|Response
    {
        return 'hello there';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('includes/_login', [
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

}