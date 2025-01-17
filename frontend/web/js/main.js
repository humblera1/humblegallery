import '@modules/paintings/index.js';
import '@modules/collections/index.js';
import '@widgets/MasonryWidget/index.js';
import '@styles/frontend.scss';

$(document).ready(() => {
    // Регистрация виджетов
    if ($('#filter-widget').length > 0) {
        import(/* webpackChunkName: "filter-widget" */ './widgets/FilterWidget/index.js')
            .then(({ default: FilterWidget }) => {
                new FilterWidget();
            })
            .catch((error) => console.error('Ошибка при загрузке виджета фильтра:', error));
    }

    if ($('#search-widget').length > 0) {
        import(/* webpackChunkName: "search-widget" */ './widgets/SearchWidget/index.js')
            .then(({ default: SearchWidget }) => {
                new SearchWidget();
            })
            .catch((error) => console.error('Ошибка при загрузке виджета поиска:', error));
    }

    if ($('#swiper-widget').length > 0) {
        import(/* webpackChunkName: "swiper-widget" */ './widgets/SwiperWidget/index.js')
            .then(({ default: SwiperWidget }) => {
                new SwiperWidget();
            })
            .catch((error) => console.error('Ошибка при загрузке виджета свайпера:', error));
    }

    if ($('#modal-widget').length > 0) {
        import(/* webpackChunkName: "modal-widget" */ './widgets/ModalWidget/index.js')
            .then(({ init: initModalWidget, openModal, closeModal }) => {
                initModalWidget();
            })
            .catch((error) => console.error('Ошибка при загрузке виджета модального окна:', error));
    }

    if ($('#popup-filter-widget').length > 0) {
        import(/* webpackChunkName: "popup-filter-widget" */ './widgets/PopupFilterWidget/index.js')
            .then(({ default: PopupFilterWidget }) => {
                new PopupFilterWidget();
            })
            .catch((error) => console.error('Ошибка при загрузке виджета фильтров:', error));
    }
});