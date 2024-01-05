<?php

namespace common\modules\painting\components\behaviors;

use common\modules\painting\models\data\Painting;
use common\modules\subject\models\data\Subject;
use yii\base\Behavior;

class SubjectBehavior extends Behavior
{
    /**
     * Saves new Subject model if it doesn't exist
     */
    public function saveSubjects(): bool
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

                return false;
            }

            $newIds[] = $subjectToSave;
        }

        $model->subjectIds = $newIds;

        return true;
    }
}