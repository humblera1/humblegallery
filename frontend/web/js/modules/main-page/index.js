new class MainPageManager {
    constructor() {
        if ($('.main').length > 0) {
            this.init();
        }
    }

    init() {
        $(document).on('search:applied', (event, formData) => {
            localStorage.setItem('searchData', JSON.stringify(formData));
            window.location.href = '/paintings';
        });
    }
}