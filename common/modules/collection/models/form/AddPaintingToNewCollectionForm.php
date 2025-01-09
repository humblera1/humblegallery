<?php

namespace common\modules\collection\models\form;

use common\modules\collection\models\data\Collection;

/**
 * @property int $painting_id
 */
class AddPaintingToNewCollectionForm extends Collection
{
    public int $painting_id;

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 32],
            [['is_private'], 'boolean'],
            [['painting_id'], 'integer'],
            [['painting_id'], 'exist', 'targetClass' => Collection::class, 'targetAttribute' => 'id'],
        ];
    }
}
