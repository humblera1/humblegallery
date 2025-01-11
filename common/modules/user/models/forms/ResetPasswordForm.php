<?php

namespace common\modules\user\models\forms;

use common\components\services\AuthService;
use common\modules\user\models\data\User;
use Yii;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public ?string $password = null;

    public ?string $passwordAgain = null;

    private ?User $_user = null;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties.
     * @throws InvalidArgumentException if token is empty or not valid.
     */
    public function __construct(string $token, array $config = [])
    {
        if ($token && ($this->_user = AuthService::findByPasswordResetToken($token))) {
            return parent::__construct($config);
        }

        throw new InvalidArgumentException('Не удалось сбросить пароль. Проверьте правильность ссылки, указанной в письме.');
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['password', 'passwordAgain'], 'required'],
            [['password', 'passwordAgain'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            [
                'passwordAgain',
                'compare',
                'compareAttribute' => 'password',
                'message' => 'Пароли не совпадают',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'password' => 'Пароль',
            'passwordAgain' => 'Пароль ещё раз',
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     * @throws Exception
     */
    public function resetPassword(): bool
    {
        $user = $this->_user;

        $user->service->setPassword($this->password);
        $user->service->removePasswordResetToken();
        $user->service->generateAuthKey();

        return $user->save(false);
    }
}
