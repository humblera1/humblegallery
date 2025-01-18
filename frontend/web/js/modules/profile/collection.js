new class ProfileCollectionManager {
    constructor() {
        if ($('.profile-collection').length > 0) {
            this.searchFormData = [];
            this.filtersFormData = [];
            this.init();
        }
    }

    init() {
        this.initFiltersLogic();
    }

    /**
     * Логика фильтрации картин.
     */
    initFiltersLogic() {
        $(document).on('search:applied', (event, formData) => {
            this.searchFormData = formData;
            $(document).trigger('masonry:reload', [this.getCombinedData()]);
        });

        $(document).on('filters:applied', (event, formData) => {
            this.filtersFormData = formData;
            $(document).trigger('masonry:reload', [this.getCombinedData()]);
        });
    }

    /**
     * Возвращает объединенный массив данных для фильтрации и поиска.
     * @returns {*[]}
     */
    getCombinedData() {
        return [...this.filtersFormData, ...this.searchFormData];
    }
}()