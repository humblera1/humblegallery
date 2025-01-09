<?php

use common\modules\collection\models\data\Collection;
use common\widgets\ModalWidget;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 */

?>

<?php ModalWidget::begin([
    'toggleButton' => '.painting-card__wrapper_collect',
]); ?>
    <div id="modal-collections" class="modal-collections">
        <div class="modal-collections__header">
            <h3 class="modal-collections__title"><?= 'Добавление в коллекцию' ?></h3>
        </div>
        <div class="modal-collections__body">
            <div id="collections-preview" class="modal-collections__preview">
                <img src="" alt="Painting" />
            </div>
            <div id="collections-content" class="modal-collections__content">
                <!-- user collections preview -->
            </div>
        </div>
    </div>
<?php ModalWidget::end(); ?>
