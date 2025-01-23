<?php

namespace common\modules\artist\controllers\admin;

use common\components\CrudController;
use common\modules\artist\models\data\Artist;
use common\modules\artist\models\search\ArtistSearch;

/**
 * DefaultController implements the CRUD actions for Artist model.
 */
class DefaultController extends CRUDController
{
    /** {@inheritDoc} */
    public function initController(): void
    {
        $this->model = Artist::class;
        $this->searchModel = ArtistSearch::class;
    }
}
