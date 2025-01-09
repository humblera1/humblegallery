import * as styles from './styles.scss';

export default class ModalWidget {
    constructor() {
        this.overlay = $('.modal__overlay');
        this.close = $('.modal__close');

        this.baseModal = $('#modal-widget');
        this.wrapper = $('.modal__wrapper');

        this.modals = $('.modal');

        this.init();
    }

    init() {
        this.overlay.on('click', () => closeModal());

        this.modals.each((_idx, modal) => {
            const toggleButtonSelector = $(modal).data('toggle-button');

            if (!toggleButtonSelector) {
                console.warn('No toggle-button data attribute found on modal');

                return;
            }

            const toggleButton = $(toggleButtonSelector);

            if (!toggleButton.length) {
                console.warn(`No element found for selector: ${toggleButtonSelector}`);

                return;
            }

            toggleButton.on('click', () => {
                this.toggleModal(modal);
            });
        })
    }

    toggleModal(modal) {
        const isModalOpened = this.baseModal.hasClass('active');

        if (isModalOpened) {
            closeModal();
        } else {
            this.openModal(modal);
        }
    }

    openModal(modal) {
        $('body').css('overflow', 'hidden');

        this.baseModal.addClass('active');
        this.wrapper.html(modal);

        const event = new CustomEvent('modalOpened', { detail: { modalElement: $(modal).children().first() }})
        document.dispatchEvent(event);
    }
}

export function closeModal() {
    $('body').css('overflow', '');

    $('#modal-widget').removeClass('active');
    $('.modal__wrapper').html('');

    document.dispatchEvent(new CustomEvent('modalClosed'));
}