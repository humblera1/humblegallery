<?php

namespace common\modules\collection\models\repository;

use common\components\interfaces\RepositoryInterface;
use common\modules\collection\models\data\Collection;
use common\modules\painting\models\data\Painting;
use Exception;
use Yii;

class CollectionRepository implements RepositoryInterface
{
    public function createWithPainting(Collection $collection, Painting $painting): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($collection->save()) {
                $collection->link('paintings', $painting, ['created_at' => time()]);

                $transaction->commit();

                return true;
            }

            throw new Exception();
        } catch (Exception $e) {
            $transaction->rollBack();

            Yii::error($e->getMessage(), __METHOD__);

            return false;
        }
    }
}
