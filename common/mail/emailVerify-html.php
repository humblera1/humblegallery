<?php

use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var string $verifyLink
 */

$imagePath = Yii::$app->urlManager->createAbsoluteUrl('/images/verify-email-mail.png');

?>
<div class="verify-email">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="450" style="border-collapse: collapse; background-color: #ffffff; box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td>
                            <!-- Main Content Table with Padding -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding: 24px 24px 0 24px;">
                                        <table width="100%">
                                            <tr>
                                                <td align="left" style="font-size: 16px; font-weight: bold; color: #381a1c;">
                                                    <span style="color: #381a1c;">HUMBLE</span><span style="color: #c98412;">GALLERY</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding: 20px 30px 40px 30px;">
                                                    <img src="<?= $imagePath ?>" alt="Verification Image" style="max-height: 210px; width: auto;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding-bottom: 8px; font-size: 24px; font-weight: bold; color: #381a1c;">
                                                    Подтверждение почты
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding-bottom: 36px; font-size: 14px; color: #7D6F61;">
                                                    Нажмите на кнопку ниже, чтобы завершить процесс подтверждения почты!
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding-bottom: 60px;">
                                                    <a href="<?= Html::encode($verifyLink) ?>" style="background-color: #8B4E1C; color: #ffffff; padding: 10px 24px; text-decoration: none; font-weight: bold; border-radius: 100px; display: inline-block;">
                                                        Подтвердить
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom: 24px; font-size: 14px; color: #7D6F61;">
                                                    Или используйте ссылку:
                                                    <a href="<?= Html::encode($verifyLink) ?>" style="color: #C98412; text-decoration: none;">
                                                        <?= Html::encode($verifyLink) ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Footer Table without Padding -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; background-color: #FDF1E3;">
                                <tr>
                                    <td align="left" style="padding: 12px 0 12px 24px; width: 100%; position: relative;">
                                        <div style="font-size: 12px; font-weight: 500; color: #381A1C;">humblerat</div>
                                        <div style="font-size: 10px; color: #8E8174;"><?= date('Y') ?></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
