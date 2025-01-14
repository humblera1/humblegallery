import {post, showSuccessMessage, showErrorMessage, get, redirectToLoginPage} from "@utils";
import { closeModal } from "@widgets/ModalWidget";
import  imagesLoaded  from 'imagesloaded';
import './masonry';

/**
 * Логика страницы с каталогом картин.
 */
new class PaintingsManager {
    static LIKE_URL = '/paintings/toggle-like';
    static COLLECTIONS_LIST_URL = '/collections/get-list'
    static COLLECTION_FORM_URL = '/collections/get-form'
    static TOGGLE_PAINTING_URL = '/collections/toggle-painting'

    constructor() {
        if ($('.paintings').length > 0) {
            this.searchFormData = [];
            this.filtersFormData = [];
            this.init();
        }
    }

    init() {
        this.initMasonryLogic();

        this.initFiltersLogic();

        this.initLikeLogic();
        this.initCollectionLogic();
    }

    /**
     * Выполняет первоначальную инициализацию кладки masonry.
     * Также регистрирует обработчик перестройки плагина после обновления контента.
     */
    initMasonryLogic() {
        $(document).on('DOMContentLoaded', () => {
            $('.paintings__list').masonry({
                columnWidth: '.painting-card',
                itemSelector: '.painting-card',
                transitionDuration: '1s',
                percentPosition: true
            });
        });

        // todo: создать отдельный виджет под masonry
        // Дожидаемся загрузки контента в Pjax
        $('.paintings__list').on('pjax:success', () => {
            const masonryContent = $('.paintings__list');

            // Дожидаемся загрузки изображений
            imagesLoaded(masonryContent[0], () => {
                masonryContent.masonry('reloadItems');
                masonryContent.masonry();
            });
        });
    }

    /**
     * Логика фильтрации картин.
     */
    initFiltersLogic() {
        $(document).on('search:applied', (event, formData) => {
            this.searchFormData = formData;
            this.reloadContent();
        });

        $(document).on('filters:applied', (event, formData) => {
            this.filtersFormData = formData;
            this.reloadContent();
        });
    }

    /**
     * Логика добавления картин в избранное (лайков).
     */
    initLikeLogic() {
        $('.painting-card__wrapper_heart').on('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            if (isGuest) {
                redirectToLoginPage();
                return;
            }

            const $elem = $(event.currentTarget);

            $elem.toggleClass('liked');

            post(PaintingsManager.LIKE_URL, { paintingId: $elem.data('painting-id') })
                .done((response) => {
                    this.onResponse(response);
                })
                .fail(() => $elem.toggleClass('liked'));

            return false;
        });
    }

    /**
     * Логика управления коллекциями: добавление картины в существующие коллекции, создание новых.
     */
    initCollectionLogic() {
        $('.painting-card__wrapper_collect').on('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            if (isGuest) {
                redirectToLoginPage();
                return;
            }

            this.paintingId = $(event.currentTarget).data('painting-id');

            $(document).off('modalOpened').on('modalOpened', () => {
                this.loadPreviewImage(event);
                this.loadContent(event);
            });
        });
    }

    /**
     * Загружает изображение для предпросмотра в модальном окне.
     * @param event
     */
    loadPreviewImage(event) {
        const elem = event.currentTarget;
        const imageElement = $(elem).closest('.painting-card').find('.painting-card__image img');
        const imageUrl = imageElement.attr('src');

        $('#collections-preview img').attr('src', imageUrl);
    }

    /**
     * Загружает содержимое модального окна для добавления картины в коллекцию.
     * Это может быть список пользовательских коллекций или форма создания, если у пользователя нет открытых неархивированных коллекций.
     */
    loadContent() {
        get(PaintingsManager.COLLECTIONS_LIST_URL, { paintingId: this.paintingId })
            .done((response) => {
                $('#collections-content').html(response);

                this.addFormListeners();
                this.addListListeners();
            });
    }

    /**
     * Обработчики на форме создания коллекции. Выполняет отправку формы на сервер.
     */
    addFormListeners() {
        $('#collection-form').on('beforeSubmit', (event) => {
            const form = $(event.currentTarget);

            post(form.attr('action'), form.serializeArray())
                .done((response) => {
                    this.onResponse(response);

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
     * Если элемент является особенным (например, используется для создания коллекции), загружает форму для создания.
     * Если элемент является коллекцией, добавляет картину в эту коллекцию (togglePainting).
     */
    addListListeners() {
        $('.collection-preview').on('click', (event) => {
            const elem = $(event.currentTarget);

            if (elem.data('type') === 'action') {
                get(PaintingsManager.COLLECTION_FORM_URL, { paintingId: this.paintingId })
                    .done((response) => {
                        $('#collections-content').html(response);

                        this.addFormListeners();
                    });
            } else {
                this.togglePainting(elem.data('collection-id'));
            }
        })
    }

    /**
     * Обрабатывает добавление или удаление картины из коллекции.
     * @param collectionId
     */
    togglePainting(collectionId) {
        post(PaintingsManager.TOGGLE_PAINTING_URL, {
            collectionId: collectionId,
            paintingId: this.paintingId,
        })
            .done((response) => {
                if (response.success) {
                    showSuccessMessage(response.message);
                } else {
                    showErrorMessage(response.message);
                }

                closeModal();
            });
    }

    /**
     * Выполняет перезагрузку контента на странице при применении фильтров или условия поиска.
     */
    reloadContent() {
        return $.pjax.reload({
            container: '#paintings-pjax-container',
            type: 'POST',
            data: this.getCombinedData(),
            push: false,
            replace: false
        });
    }

    /**
     * Возвращает объединенный массив данных для фильтрации и поиска.
     * @returns {*[]}
     */
    getCombinedData() {
        return [...this.filtersFormData, ...this.searchFormData];
    }

    /**
     * Вспомогательная функция для обработки успешного ответа от сервера.
     * @param response
     */
    onResponse(response) {
        if (response.success) {
            showSuccessMessage(response.message);
        } else {
            showErrorMessage(response.message);
        }
    }
}();
