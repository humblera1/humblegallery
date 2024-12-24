import '@styles/frontend.scss';

$(document).ready(() => {
    // Регистрация виджета
    if ($('#filter-widget').length > 0) {
        import(/* webpackChunkName: "filter-widget" */ './widgets/FilterWidget/index.js')
            .then(({ default: FilterWidget }) => {
                new FilterWidget();
            })
            .catch((error) => console.error('Ошибка при загрузке виджета фильтра:', error));
    }
});