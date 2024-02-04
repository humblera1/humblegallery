<?php

use common\modules\collection\models\data\Collection;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 */
if (!Yii::$app->user->isGuest) {
    $hasCollections = Yii::$app->user->identity->service->hasCollections();
    $this->registerJsVar('hasCollections', $hasCollections);
}

?>

<div id="overlay"> </div>
<div id="collection-modal" class="modal">
    <div class="modal__wrapper">
        <div class="modal__content modal_content_collections">
            <div class="modal__header">
                <div class="modal-head">
                    <div class="modal-head__close">
                        <div class="close-button">×</div>
                    </div>
                    <div class="modal-head__title">
                        <h3><?= $hasCollections ? 'Выберите коллекцию' : 'Создайте свою первую коллекцию!' ?></h3>
                    </div>
                </div>
            </div>
            <div class="modal__body">
                <div class="modal__body-content">
                    <div id="collectionModalContent" class="collection-choice">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
