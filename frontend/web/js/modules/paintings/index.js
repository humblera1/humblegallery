import {post, showSuccessMessage, showErrorMessage, get} from "@utils";
import { closeModal } from "@widgets/ModalWidget";

new class PaintingsManager {
    static LIKE_URL = '/paintings/toggle-like';
    static COLLECTIONS_LIST_URL = '/collections/get-list'
    static COLLECTION_FORM_URL = '/collections/get-form'
    static TOGGLE_PAINTING_URL = '/collections/toggle-painting'

    constructor() {
        this.init();
    }

    init() {
        /**
         * Лайк.
         */
        $('.painting-card__wrapper_heart').on('click', function () {
            $(this).toggleClass('liked');

            post(PaintingsManager.LIKE_URL, { paintingId: $(this).data('painting-id') })
                .done((response) => {
                    showSuccessMessage(response.message);
                })
                .fail(() => $(this).toggleClass('liked'));
        });

        /**
         * Открытие модального окна с коллекциями.
         */
        $('.painting-card__wrapper_collect').on('click', (event) => {
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

    loadContent(event) {
        get(PaintingsManager.COLLECTIONS_LIST_URL, { paintingId: this.paintingId })
            .done((response) => {
                $('#collections-content').html(response);

                this.addFormListeners();
                this.addListListeners();
            });
    }

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

    addFormListeners() {
        $('#collection-form').on('beforeSubmit', function () {
            const form = $(this);

            post(form.attr('action'), form.serializeArray())
                .done((response) => {
                    showSuccessMessage(response.message);

                    closeModal();
                })
                .fail(() => {
                    showErrorMessage('Не удалось создать коллекцию');
                });

            return false;
        });
    }

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
}();
