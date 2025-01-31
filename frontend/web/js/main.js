import '@modules/about-page/index.js';
import '@modules/main-page/index.js';
import '@modules/paintings/index.js';
import '@modules/collections/index.js';
import '@modules/profile/settings.js';
import '@modules/profile/collection.js';
import '@modules/profile/view.js';

import '@widgets/MasonryWidget/index.js';
import '@widgets/FlashWidget/index.js';
import '@widgets/ToastWidget/index.js';
import '@widgets/FilterWidget/index.js';
import '@widgets/SearchWidget/index.js';
import '@widgets/SwiperWidget/index.js';
import '@widgets/PopupFilterWidget/index.js';

import '@styles/frontend.scss';

$(document).ready(() => {
    if ($('#modal-widget').length > 0) {
        import(/* webpackChunkName: "modal-widget" */ './widgets/ModalWidget/index.js')
            .then(({ init: initModalWidget, openModal, closeModal }) => {
                initModalWidget();
            })
            .catch((error) => console.error('Ошибка при загрузке виджета модального окна:', error));
    }
});