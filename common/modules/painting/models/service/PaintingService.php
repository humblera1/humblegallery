<?php

namespace common\modules\painting\models\service;

use common\components\Service;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\data\PaintingLike;
use Exception;
use Yii;
use yii\helpers\Url;

/**
 * @property Painting $model
 */

class PaintingService extends Service
{
    /**
     * Retrieves the main image path for the painting
     */
    public function getImage(): string
    {
        $model = $this->model;

        return '/uploads/images/paintings/' . $model->artist->name . '/' . $model->image_name;
    }

    /**
     * Retrieves the thumbnail path for the painting
     */
    public function getThumbnail(): string
    {
        $model = $this->model;

        return '/uploads/thumbnails/paintings/' . $model->artist->name . '/' . $model->image_name;
    }

    /**
     * Retrieves a list of movements of the painting and return them as a links
     */
    public function getMovementsList(): string
    {
        $list = '';

        foreach ($this->model->movements as $movement) {
            $list .= '<a href="' . Url::to(['/movement/default/view', 'id' => $movement->id]) . '">' . $movement->name . '</a>' . ', ';
        }

        return rtrim($list, ', ');
    }

    /**
     * Retrieves a list of subjects of the painting
     */
    public function getSubjectsList(): string
    {
        $list = '';

        foreach ($this->model->subjects as $subject) {
            $list .= '<a href="' . Url::to(['/subject/default/view', 'id' => $subject->id]) . '">' . $subject->name . '</a>' . ', ';
        }

        return rtrim($list, ', ');
    }

    public function getSubjectNames($limit = 3): string
    {
        return join(', ', $this->model->getSubjects()->select('name')->limit($limit)->column());
    }

    /**
     * Returns the start (if it exists) and end date of the painting as a string
     */
    public function getDateToDisplay(): string
    {
        $dates = '';

        if ($this->model->start_date) {
            $dates .= $this->model->start_date . ' — ';
        }

        return $dates . $this->model->end_date;
    }

    /**
     * Return string that contains title and dates info to display it
     */
    public function getNameToDisplay(): string
    {
        return $this->model->title . ' ' . $this->getDateToDisplay();
    }

    /**
     * Check if the painting is liked by the current user
     */
    public function isLikedByCurrentUser(): bool
    {
        return $this->model->getLikes()->byCurrentUser()->exists();
    }

    /**
     * Check if the painting is collected by the current user
     */
    public function isCollectedByCurrentUser(): bool
    {
        return $this->model->getCollections()->byCurrentUser()->exists();
    }

    public function getCollectionsIdsByUser(): array
    {
        return $this->model->getCollections()
            ->byCurrentUser()
            ->select('id')
            ->column();
    }

    public function getCollectionsCountByUser(): int
    {
        return $this->model->getCollections()
            ->byCurrentUser()
            ->count();
    }

    public function toggleLike(): bool
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            return false;
        }

        $userId = $user->id;
        $paintingId = $this->model->id;

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $like = PaintingLike::findOne(['user_id' => $userId, 'painting_id' => $paintingId]);

            if ($like) {
                $like->delete();
            } else {
                $newLike = new PaintingLike([
                    'user_id' => $userId,
                    'painting_id' => $paintingId,
                ]);

                if (!$newLike->save()) {
                    throw new Exception('Failed to save like');
                }
            }

            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollBack();

            Yii::error("Error toggling like: " . $e->getMessage(), __METHOD__);

            return false;
        }
    }
}
