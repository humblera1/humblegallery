<?php

namespace frontend\controllers;

use common\components\services\AuthService;
use common\modules\user\models\forms\LoginForm;
use common\modules\user\models\forms\PasswordResetRequestForm;
use common\modules\user\models\forms\ResendVerificationEmailForm;
use common\modules\user\models\forms\ResetPasswordForm;
use common\modules\user\models\forms\SignupForm;
use Yii;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class AuthController extends Controller
{
    public $layout = 'auth';

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'login', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'transparent' => true,
                'foreColor' => 0x381A1C,
            ],
        ];
    }

    /**
     * Signs user up.
     *
     * @return string|Response
     * @throws Exception
     */
    public function actionSignup(): string|Response
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Завершите регистрацию, перейдя по ссылке, отправленной на ваш почтовый ящик.');

            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return string|Response
     */
    public function actionLogin(): string|Response
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     * @throws Exception
     */
    public function actionRequestPasswordReset(): string|Response
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Инструкции по сбросу пароля были отправлены на ваш почтовый ящик.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Не удалось сбросить пароль. Пожалуйста, повторите попытку позднее.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return string|Response
     * @throws Exception
     */
    public function actionResetPassword(string $token): string|Response
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());

            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль успешно сохранён!');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address.
     *
     * @param string $token
     * @return Response
     * @throws \yii\db\Exception
     */
    public function actionVerifyEmail(string $token): Response
    {
        if (AuthService::verifyEmail($token)) {
            Yii::$app->session->setFlash('success', 'Почта успешно подтверждена!');
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось подтвердить почту. Проверьте правильность ссылки, указанной в письме.');
        }

        return $this->goHome();
    }

    /**
     * Resend verification email.
     *
     * @return string|Response
     * @throws Exception
     */
    public function actionResendVerificationEmail(): string|Response
    {
        $model = new ResendVerificationEmailForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Инструкции для подтверждения почты были отправлены на ваш почтовый ящик.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Не удалось письмо для подтверждения почты. Пожалуйста, повторите попытку позднее.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
