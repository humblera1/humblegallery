<?php

namespace common\modules\user\models\forms;

use common\modules\user\models\data\User;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

class EditForm extends Model
{
    protected ?User $_user = null;

    public string|null $name = null;
    public string|null $surname = null;
    public string|null $username = null;
    public string|null $email = null;

    public UploadedFile|string|null $file = null;

    public function __construct(?User $user = null, $config = [])
    {
        $this->_user = $user;

        if ($this->_user) {
            $this->username = $this->_user->username;
            $this->email = $this->_user->email;
            $this->name = $this->_user->name;
            $this->surname = $this->_user->surname;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [
                [
                    'name',
                    'surname',
                    'username',
                    'email',
                ],
                'trim',
            ],
            [
                [
                    'username',
                    'email',
                ],
                'required'
            ],
            [
                'username',
                'unique',
                'targetClass' => User::class,
                'filter' => function ($query) {
                    if ($this->_user) {
                        $query->andWhere(['not', ['id' => $this->_user->id]]);
                    }
                },
            ],
            [
                'username',
                'string',
                'min' => 2,
                'max' => 255
            ],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => User::class,
                'filter' => function ($query) {
                    if ($this->_user) {
                        $query->andWhere(['not', ['id' => $this->_user->id]]);
                    }
                },
            ],
            [['file'], 'file', 'maxSize' => 2 * 1024 * 1024, 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'username' => 'Логин',
            'email' => 'E-mail',
        ];
    }

    public function saveChanges(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $user = $this->_user;

            $user->name = $this->name;
            $user->surname = $this->surname;
            $user->username = $this->username;
            $user->email = $this->email;

            if ($this->saveAvatar() && $user->save()) {
                $user->refresh();

                $transaction->commit();

                return true;
            }

            throw new \Exception();
        } catch (\Exception $e) {
            $transaction->rollBack();

            return false;
        }
    }

    /**
     * @throws \Exception
     */
    public function saveAvatar(): bool
    {
        $file = $this->file;

        if (!$file) {
            return true;
        }

        $this->removeOldAvatar();

        $path = Url::to('@common/uploads/avatars/');
        $name = $this->username . '-' . time() . '.' . $file->extension;

        FileHelper::createDirectory($path);

        if ($file->saveAs($path . $name)) {
            $this->_user->avatar = $name;

            return true;
        }

        return false;
    }

    /**
     * @throws \Exception
     */
    public function removeOldAvatar(): void
    {
        $oldName = $this->_user->avatar;

        if ($oldName) {
            $path = Url::to('@common/uploads/avatars/') . '/' . $oldName;

            if (FileHelper::unlink($path)) {
                $this->_user->avatar = null;

                return;
            }

            throw new \Exception();
        }
    }
}