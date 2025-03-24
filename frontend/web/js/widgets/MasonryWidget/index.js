import * as styles from './styles.scss';
import imagesLoaded from "imagesloaded";
import './masonry';
import {get, onResponse, patch, post, redirectToLoginPage, showErrorMessage} from "@utils";
import urls from "@urls";
import {closeModal, openModal} from "@widgets/ModalWidget";

/**
 * Модуль для работы с Masonry-контейнером с картинами.
 * Инициализирует кладку masonry, а также обрабатывает взаимодействия с элементами: добавление в избранное и в коллекции.
 */
export default new class MasonryWidget {
    constructor() {
        this.widget = $('#masonry-widget');

        if (this.widget.length > 0) {
            this.init();
        }
    }

    init() {
        this.modal = $('#modal-collections');
        this.pjaxId = this.widget.data('pjax-id');

        $(this.widget).on('pjax:beforeSend', () => {
            this.hideContent()
        });

        this.initMasonry();
        this.bindEvents();
    }

    /**
     * Инициализирует Masonry-контейнер с картинами.
     */
    initMasonry() {
        $(document).on('masonry:reload', (event, data) => {
            this.reloadContent(data);
        });

        imagesLoaded(this.widget[0], () => {
            $(this.widget).masonry({
                columnWidth: '.card',
                itemSelector: '.card',
                transitionDuration: '1s',
                percentPosition: true
            });

            this.updateContainerHeight();
            this.showContent();
        });

        // Дожидаемся загрузки контента в Pjax
        $(this.widget).on('pjax:success', () => {
            this.bindEvents();

            imagesLoaded(this.widget[0], () => {
                this.widget.masonry('reloadItems');
                this.widget.masonry();

                this.updateContainerHeight();
                this.showContent()
            });
        });
    }

    showContent() {
        this.widget.removeClass('loading');
    }

    hideContent() {
        this.widget.addClass('loading');
    }

    updateContainerHeight() {
        $('#masonry-container').css('height', this.widget.height());
    }

    /**
     * Добавляет обработчики для кликов на элементы коллекций.
     */
    bindEvents() {
        $('.card__wrapper_heart').on('click', (event) => this.handleLike(event));
        $('.card__wrapper_collect').on('click', (event) => this.handleCollectionsPreview(event));
    }

    /**
     * Обрабатывает событие добавления картины в избранное (лайка).
     */
    handleLike(event) {
        event.preventDefault();
        event.stopPropagation();

        if (isGuest) {
            redirectToLoginPage();

            return;
        }

        const $elem = $(event.currentTarget);
        const paintingId = $elem.data('painting-id');


        $elem.toggleClass('liked');

        patch(urls.paintings.toggleLike(paintingId))
            .fail(() => {
                $elem.toggleClass('liked');
                showErrorMessage('Не удалось добавить в избранное');
            });
    }

    /**
     * Обрабатывает событие добавление картины в коллекцию.
     * Подготавливает контент и открывает модальное окно.
     *
     * @param event
     */
    handleCollectionsPreview(event) {
        event.preventDefault();
        event.stopPropagation();

        if (isGuest) {
            redirectToLoginPage();
            return;
        }

        this.paintingId = $(event.currentTarget).data('painting-id');

        this.loadPreviewImage(event);
        this.loadModalForm(event);
    }

    /**
     * Загружает изображение картины для отображения в модальном окне.
     * @param event
     */
    loadPreviewImage(event) {
        const elem = event.currentTarget;
        const imageElement = $(elem).closest('.card').find('.card__image img');
        const imageUrl = imageElement.attr('src');

        this.modal.find('#collections-preview img').attr('src', imageUrl);
    }

    /**
     * Загружает основное содержимое модальное окна:
     * это может быть форма создания коллекции или список существующих коллекций пользователя.
     */
    loadModalForm() {
        get(urls.collections.availableCollections(this.paintingId))
            .done((response) => {
                this.modal.find('#collections-content').html(response);
                this.bindFormEvents()
                this.bindCollectionsEvents();

                openModal(this.modal);
            });
    }

    /**
     * Добавляет обработчик сабмита формы. Выполняет ajax-запрос на сервер для создания коллекции.
     */
    bindFormEvents() {
        this.modal.find('#collection-form').on('beforeSubmit', (event) => {
            const form = $(event.currentTarget);

            post(form.attr('action'), form.serializeArray())
                .done((response) => {
                    onResponse(response);
                    closeModal();
                })
                .fail(() => {
                    showErrorMessage('Не удалось создать коллекцию');
                });

            return false;
        });
    }

    /**
     * Добавляет обработчиков кликов на элементы коллекций.
     * Если элемент является особенным (используется для создания коллекции), загружает форму для создания.
     * Если элемент является коллекцией, добавляет картину в эту коллекцию (togglePainting).
     */
    bindCollectionsEvents() {
        this.modal.find('.collection-preview').on('click', (event) => {
            const elem = $(event.currentTarget);

            if (elem.data('type') === 'action') {
                get(urls.collections.withPaintingForm(this.paintingId))
                    .done((response) => {
                        this.modal.find('#collections-content').html(response);
                        this.bindFormEvents();
                    });
            } else {
                this.togglePainting(elem.data('collection-id'));
            }
        });
    }

    /**
     * Обрабатывает добавление или удаление картины из коллекции.
     * @param collectionId
     */
    togglePainting(collectionId) {
        post(urls.collections.togglePainting(collectionId, this.paintingId))
            .done((response) => {
                onResponse(response);
                closeModal();
            })
            .fail(() => {
                showErrorMessage('Не удалось выполнить запрос');
            });
    }

    /**
     * Выполняет перезагрузку pjax-контейнера.
     * @param data
     */
    reloadContent(data) {
        $.pjax.reload({
            container: `#${this.pjaxId}`,
            type: 'POST',
            data: data,
            push: false,
            replace: false
        });
    }
}()