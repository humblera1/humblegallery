<?php

namespace common\modules\movement\controllers\admin;

use common\components\CrudController;
use common\modules\movement\models\data\Movement;
use common\modules\movement\models\search\MovementSearch;

/**
 * DefaultController implements the CRUD actions for Movement model.
 */
class DefaultController extends CRUDController
{
    /** {@inheritDoc} */
    public function initController(): void
    {
        $this->model = Movement::class;
        $this->searchModel = MovementSearch::class;
    }
}
