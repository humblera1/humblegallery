<?php

use common\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 */

$this->title = 'О нас';
?>
<div class="about">
    <header class="about__header">
        <div class="about__image">
            <img src="/images/winking-cat.png" alt="Winking Car">
        </div>
        <h1 class="title">Привет, меня зовут Максим Кошкин</h1>
    </header>
    <section class="about__content">
        <div class="about__container">
            <h2 class="about__subtitle">Кто я такой?</h2>
        </div>
        <div class="about__text">
            <p class="about__paragraph">
                Я являюсь веб-разработчиком и специализируюсь на создании современных и функциональных веб-приложений.
            </p>
            <p class="about__paragraph">
                Я начинал как бэкенд-разработчик, впоследствии начал работать и на фронте. В своей работе я преимущественно использую такие инструменты, как Yii2, Laravel, Vue и Nuxt.
            </p>
        </div>
        <div class="about__container">
            <h2 class="about__subtitle">Откуда я пришёл?</h2>
        </div>
        <div class="about__text">
            <p class="about__paragraph">
                Идея написать данный сайт - достаточно спонтанная. Я с детства рисую, неравнодушно отношусь к истории искусства, направлениям последнего столетия, а потому этот проект для меня - возможность объединить два увлечения. Может, стать чуточку грамотнее в вопросах веб-разработки и в вопросах живописи.
            </p>
        </div>
        <div class="about__container">
            <h2 class="about__subtitle">Куда я иду?</h2>
        </div>
        <div class="about__text">
            <p class="about__paragraph">
                Я планирую поддерживать и всячески развивать этот сайт, чтобы сделать пользовательский опыт более запоминающимся и увлекательным. В частности, в ближайшем будущем я планирую сосредоточиться на следующих аспектах:
            </p>
            <ul class="about__list">
                <li>
                    <span class="about__paragraph">
                        Добавление возможности оценивать картины и художников, что позволит вести динамичные рейтинги произведений
                    </span>
                </li>
                <li>
                    <span class="about__paragraph">
                        Создание персонализированной ленты рекомендаций, которая поможет вам находить новые шедевры, соответствующие вашим интересам
                    </span>
                </li>
                <li>
                    <span class="about__paragraph">
                        Расширение функционала коллекций: возможность добавлять соавторов с различными правами доступа, будь то просмотр или редактирование
                    </span>
                </li>
                <li>
                    <span class="about__paragraph">
                        Добавление образовательного контента: статей, курсов и возможности обсуждения, чтобы каждый мог пополнить свои знания в области искусства
                    </span>
                </li>
                <li>
                    <span class="about__paragraph">
                        Работа над адаптивом: добавление возможности просматривать сайт на планшетах и мобильных устройствах
                    </span>
                </li>
            </ul>
            <p class="about__paragraph">
                Я искренне надеюсь, что мой сайт станет для вас источником вдохновения и новых открытий.
            </p>
            <p class="about__paragraph">
                Приятного просмотра и положительных впечатлений!
            </p>
        </div>
        <div class="about__container">
            <h2 class="about__subtitle">Два слова о нашей команде</h2>
        </div>
        <div class="about__text">
            <p class="about__paragraph">
                Отдельная благодарность всей команде разработчиков, которая помогала мне трудиться над проектом.
            </p>
            <p class="about__paragraph">
                Очевидно, ничего бы не вышло, будь она меньше хотя бы на одного человека.
            </p>
        </div>
        <div class="about__credits">
            <div class="about__credit">
                <div class="about__preview">
                    <span class="about__icon">
                        <?= Html::icon('arrow-right'); ?>
                    </span>
                    <p class="about__post">Проектный менеджер</p>
                    <p class="about__name">Максим Кошкин</p>
                </div>
                <p class="about__paragraph">
                    Человек, координировавший работу всей команды. Всегда был в курсе всех изменений и решений каждого отдельного её члена
                </p>
            </div>
            <div class="about__credit">
                <div class="about__preview">
                    <span class="about__icon">
                        <?= Html::icon('arrow-right'); ?>
                    </span>
                    <p class="about__post">UX/UI Дизайнер</p>
                    <p class="about__name">Максим Кошкин</p>
                </div>
                <p class="about__paragraph">
                    Второе лицо в дизайне после графического дизайнера. Кстати, вы знали, что в Dribbble три буквы b?
                </p>
            </div>
            <div class="about__credit">
                <div class="about__preview">
                    <span class="about__icon">
                        <?= Html::icon('arrow-right'); ?>
                    </span>
                    <p class="about__post">Графический дизайнер</p>
                    <p class="about__name">Максим Кошкин</p>
                </div>
                <p class="about__paragraph">
                    Наше второе лицо в дизайне после UX/UI. Ответственен за создание логотипа и хранение закладки с https://fontawesome.com/search?ic=free
                </p>
            </div>
            <div id="frontend-credit" class="about__credit">
                <div class="about__preview">
                    <span class="about__icon">
                        <?= Html::icon('arrow-right'); ?>
                    </span>
                    <p class="about__post">Фронтенд-разработчик</p>
                    <p class="about__name">Максим Кошкин</p>
                </div>
                <p class="about__paragraph">
                    Человек, с достоинством перенесший дизайн в код
                </p>
            </div>
            <div id="backend-credit" class="about__credit">
                <div class="about__preview">
                    <span class="about__icon">
                        <?= Html::icon('arrow-right'); ?>
                    </span>
                    <p class="about__post">Бэкенд-разработчик</p>
                    <p class="about__name">Максим Кошкин</p>
                </div>
                <p class="about__paragraph">
                    500 Internal Server Error
                </p>
            </div>
            <div id="qa-credit" class="about__credit">
                <div class="about__preview">
                    <span class="about__icon">
                        <?= Html::icon('arrow-right'); ?>
                    </span>
                    <p class="about__post">Мануальный тестировщик</p>
                    <p class="about__name">Максим Кошкин</p>
                </div>
                <p class="about__paragraph">
                    Çàõîäèò êàê-òî òåñòèðîâùèê â áàð è çàêàçûâàåò NaN ïèâà...
                </p>
            </div>
            <div class="about__credit">
                <div class="about__preview">
                    <span class="about__icon">
                        <?= Html::icon('arrow-right'); ?>
                    </span>
                    <p class="about__post">SEO специалист</p>
                    <p class="about__name">Максим Кошкин</p>
                </div>
                <p class="about__paragraph">
                    Наш специалист по ключевым словам! К сожалению, проект получился настолько уникальным и эксклюзивным, что напрочь отсутствует в поисковой выдаче
                </p>
            </div>
        </div>
    </section>
</div>
