<?php

namespace common\modules\collection\models\repository;

use common\components\interfaces\RepositoryInterface;
use common\modules\collection\models\data\Collection;
use Exception;
use Yii;

class CollectionRepository implements RepositoryInterface
{
    public function saveWithFile(Collection $collection): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($collection->saveFile() && $collection->save()) {
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
