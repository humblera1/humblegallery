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
                $(this.modal).find('#collections-content').html(response);

                openModal(this.modal);
                this.addFormListeners();
            });
    }

    /**
     * Навешивает обработчики на форму редактирования.
     * Сюда входит отключение стандартного поведения сабмита, отправка формы ajax'ом и закрытие модального окна.
     */
    addFormListeners() {
        console.log('listeners!!!');

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
            const form = $(event.currentTarget);

            put(urls.collections.update(this.collectionId), form.serializeArray())
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