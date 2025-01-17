<?php

use common\widgets\ModalWidget;
use yii\web\View;

/**
 * @var View $this
 */

?>

<?php ModalWidget::begin(); ?>
    <div id="modal-collections" class="modal-collections">
        <div class="modal-collections__header">
            <h3 class="modal-collections__title">Добавление в коллекцию</h3>
        </div>
        <div class="modal-collections__body">
            <div id="collections-preview" class="modal-collections__preview">
                <!-- painting preview -->
                <img src="" alt="Painting" />
            </div>
            <div id="collections-content" class="modal-collections__content">
                <!-- user collections preview -->
            </div>
        </div>
    </div>
<?php ModalWidget::end(); ?>
