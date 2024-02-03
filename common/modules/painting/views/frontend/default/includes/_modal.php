<?php

use common\modules\collection\models\data\Collection;
use yii\web\View;

/**
 * @var View $this
 */

$collections = Yii::$app->user->identity->service->getCollections();

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
                        <h3><?= $collections ? 'Выберите коллекцию' : 'Создайте свою первую коллекцию!' ?></h3>
                    </div>
                </div>
            </div>
            <div class="modal__body">
                <div id="login-content" class="modal__body-content">
                    <div class="collection-choice">
                        <?= $collections ? $this->render('_painting', ['collections' => $collections])
                            : $this->render('_new') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
