<?php

namespace common\modules\painting\components\behaviors;

use common\modules\movement\models\data\Movement;
use common\modules\painting\models\data\Painting;
use Exception;
use yii\base\Behavior;

class MovementBehavior extends Behavior
{
    /**
     * Saves new Movement model if it doesn't exist
     *
     * @throws Exception if one of new movement can't be saved
     */
    public function saveMovements(): void
    {
        /** @var Painting $model */
        $model = $this->owner;
        $newIds = [];

        foreach ($model->movementIds as $movementToSave) {
            if (!Movement::findOne($movementToSave)) {
                $movement = new Movement();
                $movement->name = $movementToSave;

                if ($movement->save()) {
                    $newIds[] = $movement->id;

                    continue;
                }

                throw new Exception('Ошибка при сохранении направления');
            }

            $newIds[] = $movementToSave;
        }

        $model->movementIds = $newIds;
    }
}
