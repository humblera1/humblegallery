/**
 * Логика страницы с коллекциями в профиле пользователя.
 */
new class CollectionsManager {
    constructor() {
        if ($('.profile-collections').length > 0) {
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

            this.paintingId = $(event.target).closest('.collection-card').data('collection-id');

            console.log(this.paintingId);
        })
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
        });
    }

    /**
     * Возвращает объединенный массив данных для фильтрации и поиска.
     * @returns {*[]}
     */
    getCombinedData() {
        return [...this.filtersFormData, ...this.searchFormData];
    }
}();