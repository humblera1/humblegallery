<?php

use common\helpers\Html;
use common\modules\user\models\data\User;
use yii\bootstrap5\ActiveForm;
use yii\web\View;

/**
 * @var $this View
 * @var $user User
 */

$isOwner = Yii::$app->user->identity?->id === $user->id;
$hasAvatar = isset($user->avatar);

?>

<div class="profile-info">
    <?php if ($isOwner): ?>
        <?php $form = ActiveForm::begin([
            'id' => 'edit-form',
            'action' => Yii::$app->request->url,
            'options' => [
                'enctype' => 'multipart/form-data'
            ]
        ]); ?>
        <div class="profile-info__content profile-info__content_owner">
            <div class="profile-info__avatar">
                <div class="profile-info__image">
                    <?php if ($user->avatar): ?>
                        <img src="<?= $user->service->getAvatar() ?>" alt="avatar">
                    <?php endif; ?>

                    <?= Html::icon('avatar-placeholder'); ?>
                </div>

                <div id="preview-actions" class="profile-info__actions <?= $hasAvatar ? 'visible' : '' ?>">
                    <span id="delete-action" class="profile-info__delete">
                        <?= Html::icon('trash'); ?>
                    </span>
                </div>

                <div class="profile-info__uploader">
                    <div class="profile-info__action">
                        <?= Html::icon('upload'); ?>
                        <p>Загрузить</p>
                    </div>

                    <?= $form->field($user, 'remove_avatar')->hiddenInput(['id' => 'avatar-delete-input'])->label(false) ?>

                    <?= $form->field($user, 'file')->fileInput(['class' => 'file-input'])->label(false) ?>
                </div>
            </div>
            <div class="profile-info__form">
                <section class="profile-info__body">
                    <?= $form->field($user, 'name')->textInput() ?>

                    <?= $form->field($user, 'surname')->textInput() ?>

                    <?= $form->field($user, 'username')->textInput() ?>

                    <?= $form->field($user, 'email')->textInput() ?>
                </section>
                <div class="profile-info__footer">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn_brown', 'name' => 'edit-button']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    <?php else: ?>
        <div class="profile-info__avatar">
            <div class="profile-info__image">
                <?php if ($user->avatar): ?>
                    <img src="<?= $user->service->getAvatar() ?>" alt="avatar">
                <?php else: ?>
                    <?= Html::icon('avatar-placeholder'); ?>
                <?php endif; ?>
            </div>
            <div class="profile-info__info">
                <p class="profile-info__name"><?= $user->service->getName()  ?></p>
                <p class="profile-info__email"><?= $user->email  ?></p>
            </div>
        </div>
    <?php endif; ?>
</div>