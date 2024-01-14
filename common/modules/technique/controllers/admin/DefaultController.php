<?php

namespace common\modules\technique\controllers\admin;

use common\components\CrudController;
use common\modules\technique\models\data\Technique;
use common\modules\technique\models\search\TechniqueSearch;

/**
 * DefaultController implements the CRUD actions for Technique model.
 */
class DefaultController extends CRUDController
{
    /** {@inheritDoc} */
    public function initController(): void
    {
        $this->model = Technique::class;
        $this->searchModel = TechniqueSearch::class;
    }
}
