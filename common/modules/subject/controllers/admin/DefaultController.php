<?php

namespace common\modules\subject\controllers\admin;

use common\components\CrudController;
use common\modules\subject\models\data\Subject;
use common\modules\subject\models\search\SubjectSearch;

/**
 * DefaultController implements the CRUD actions for Subject model.
 */
class DefaultController extends CRUDController
{
    /** {@inheritDoc} */
    public function initController(): void
    {
        $this->model = Subject::class;
        $this->searchModel = SubjectSearch::class;
    }
}
