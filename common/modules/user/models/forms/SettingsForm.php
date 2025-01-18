<?php

namespace common\modules\user\models\forms;

use Yii;
use yii\base\Model;
use yii\db\Exception;

class SettingsForm extends Model
{
    public ?bool $is_closed = null;

    public function __construct($config = [])
    {
        $this->is_closed = Yii::$app->user->identity->is_closed;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['is_closed'], 'boolean'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'is_closed' => 'Закрытый профиль',
        ];
    }

    /**
     * @throws Exception
     */
    public function saveChanges(): bool
    {
        $user = Yii::$app->user->identity;

        $user->is_closed = $this->is_closed;

        return $user->save();
    }
}