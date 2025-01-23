<?php

namespace common\modules\painting\controllers\admin;

use common\components\CrudController;
use common\modules\painting\models\data\Painting;
use common\modules\painting\models\search\PaintingSearch;

/**
 * DefaultController implements the CRUD actions for Painting model.
 *
 * @var Painting $model
 */
class DefaultController extends CRUDController
{
    /** {@inheritDoc} */
    public function initController(): void
    {
        $this->model = Painting::class;
        $this->searchModel = PaintingSearch::class;
    }
}
