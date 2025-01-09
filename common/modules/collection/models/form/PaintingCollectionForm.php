<?php

namespace common\modules\collection\models\form;

use common\modules\painting\models\data\PaintingCollection;

class PaintingCollectionForm extends PaintingCollection
{
    public function rules(): array
    {
        return [
            [['painting_id', 'collection_id'], 'required'],
            [['painting_id', 'collection_id'], 'integer'],
            [['collection_id'], 'exist', 'targetRelation' => 'collection'],
            [['painting_id'], 'exist', 'targetRelation' => 'painting'],
        ];
    }
}