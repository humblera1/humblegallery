<?php

use common\widgets\ModalWidget;

$type = 'edit';

$title = $type === 'edit' ? 'Редактирование коллекции' : 'Создание коллекции';

?>

<?php ModalWidget::begin(); ?>
<div id="modal-collections" class="modal-collections">
    <div class="modal-collections__header">
        <h3 class="modal-collections__title"><?= $title ?></h3>
    </div>
    <div class="modal-collections__body">
        <div id="collections-preview" class="modal-collections__preview">
            <img src="" alt="Painting" />
        </div>
        <div id="collections-content" class="modal-collections__content">
        </div>
    </div>
</div>
<?php ModalWidget::end(); ?>
