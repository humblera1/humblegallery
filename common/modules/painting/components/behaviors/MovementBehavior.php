<?php

namespace common\modules\painting\components\behaviors;

use common\modules\movement\models\data\Movement;
use common\modules\painting\models\data\Painting;
use yii\base\Behavior;

class MovementBehavior extends Behavior
{
    /**
     * Saves new Movement model if it doesn't exist
     */
    public function saveMovements(): bool
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

                return false;
            }

            $newIds[] = $movementToSave;
        }

        $model->movementIds = $newIds;

        return true;
    }
}