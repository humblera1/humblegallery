<?php

namespace common\modules\user\models\repository;

use common\components\interfaces\RepositoryInterface;
use common\modules\user\models\data\User;
use Exception;
use Yii;

class UserRepository implements RepositoryInterface
{
    public function saveWithFile(User $user): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($user->saveFile() && $user->save()) {
                $transaction->commit();

                return true;
            }

            throw new Exception('Failed to save collection or file');
        } catch (Exception $e) {
            $transaction->rollBack();

            Yii::error($e->getMessage(), __METHOD__);

            return false;
        }
    }
}
