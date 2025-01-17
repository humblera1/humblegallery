/**
 * Логика страницы с коллекциями в профиле пользователя.
 */
import {get, patch, post, put, requestDelete, showErrorMessage, showSuccessMessage} from "@utils";
import {closeModal, openModal} from "@widgets/ModalWidget";
import urls from "@urls";

new class CollectionsManager {
    constructor() {
        if ($('.profile-collections').length > 0) {
            this.modal = $('#modal-collections');

            this.searchFormData = [];
            this.filtersFormData = [];

            this.init();
        }
    }

    init() {
        this.initFiltersLogic();
        this.initEditLogic();
    }

    initEditLogic() {
        $('.collection-card__edit').on('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            this.collectionId = $(event.target).closest('.collection-card').data('collection-id');

            this.openEditForm();
        })
    }

    /**
     * Запрашивает форму для редактирования коллекции с сервера.
     * Открывает модальное окно, предварительно загрузив туда форму.
     */
    openEditForm() {
        get(urls.collections.editForm(this.collectionId))
            .done((response) => {
                this.modal.html(response);
                this.loadPreview();

                openModal(this.modal);
                this.addFormListeners();
            });
    }

    loadPreview() {
        const previewContainer = this.modal.find('#collections-preview');
        const coverInput = this.modal.find('#cover-input');
        const previewActions = this.modal.find('#preview-actions');

        const refreshIcon = this.modal.find('#refresh-action');
        const deleteIcon = this.modal.find('#delete-action');

        previewContainer.on('click', function(e) {
            if (!previewActions.hasClass('.visible')) {
                coverInput.click();
            }
        });

        coverInput.on('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    let img = previewContainer.find('img');

                    if (img.length) {
                        img.attr('src', e.target.result);
                    } else {
                        img = $('<img>', {src: e.target.result, alt: 'Cover'});
                        previewContainer.append(img);
                    }

                    // previewContainer.html('<img src="' + e.target.result + '" alt="Cover" />');
                    previewActions.addClass('visible');
                }

                reader.readAsDataURL(file);
            }
        });

        refreshIcon.on('click', (event) => {
            coverInput.click();
        });

        deleteIcon.on('click', function() {
            $('#cover-delete-input').val(1);

            previewContainer.find('img').remove();
            coverInput.val(''); // Clear the file input
            previewActions.removeClass('visible');
        });
    }

    /**
     * Навешивает обработчики на форму редактирования.
     * Сюда входит отключение стандартного поведения сабмита, отправка формы ajax'ом и закрытие модального окна.
     */
    addFormListeners() {
        $('#restore-button').on('click', (event) => {
            patch(urls.collections.restore(this.collectionId))
                .done((response) => {
                    this.reloadContent();
                    closeModal();

                    this.onResponse(response);
                });
        });

        $('#delete-button').on('click', (event) => {
            requestDelete(urls.collections.delete(this.collectionId))
                .done((response) => {
                    this.reloadContent();
                    closeModal();

                    this.onResponse(response);
                });
        });


        $('#collection-form').on('beforeSubmit', (event) => {
            event.preventDefault();

            const form = $(event.currentTarget)[0]; // Получаем DOM-элемент формы
            const formData = new FormData(form);

            post(urls.collections.update(this.collectionId), formData)
                .done((response) => {
                    this.reloadContent();
                    closeModal();
                })
                .fail(() => {
                    showErrorMessage('Не удалось обновить коллекцию');
                });

            return false;
        });
    }

    /**
     * Логика фильтрации коллекций.
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
     * Выполняет перезагрузку контента на странице при применении фильтров или условия поиска.
     */
    reloadContent() {
        $.pjax.reload({
            container: '#collections-pjax-container',
            type: 'POST',
            data: this.getCombinedData(),
            push: false,
            replace: false,
        })
            .done(() => this.initEditLogic());
    }

    /**
     * Возвращает объединенный массив данных для фильтрации и поиска.
     * @returns {*[]}
     */
    getCombinedData() {
        return [...this.filtersFormData, ...this.searchFormData];
    }

    onResponse(response) {
        if (response.success) {
            showSuccessMessage(response.message);
        } else {
            showErrorMessage(response.message);
        }
    }
}();