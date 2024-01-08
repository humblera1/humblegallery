<?php

namespace common\modules\painting\components\behaviors;

use common\modules\painting\models\data\Painting;
use common\modules\subject\models\data\Subject;
use Exception;
use yii\base\Behavior;

class SubjectBehavior extends Behavior
{
    /**
     * Saves new Subject model if it doesn't exist
     */
    public function saveSubjects(): void
    {
        /** @var Painting $model */
        $model = $this->owner;
        $newIds = [];

        foreach ($model->subjectIds as $subjectToSave) {
            if (!Subject::findOne($subjectToSave)) {
                $subject = new Subject();
                $subject->name = $subjectToSave;

                if ($subject->save()) {
                    $newIds[] = $subject->id;

                    continue;
                }

                throw new Exception('Ошибка при сохранении жанра');
            }

            $newIds[] = $subjectToSave;
        }

        $model->subjectIds = $newIds;
    }
}