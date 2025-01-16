import * as styles from './styles.scss';

export function init () {
    const $widget = $('#modal-widget');

    if ($widget.length === 0) {
        console.log("Can't find modal widget container");

        return;
    }

    $('.modal__overlay').on('click', closeModal);
    $('.modal').each((_idx, modal) => {
        const toggleButtonSelector = $(modal).data('toggle-button');

        // if the data-attribute is not specified, the window is controlled from js code
        if (!toggleButtonSelector) {
            return;
        }

        const $toggleButton = $(toggleButtonSelector);

        if (!$toggleButton.length) {
            console.warn(`No element found for selector: ${toggleButtonSelector}`);

            return;
        }

        $toggleButton.on('click', () => {
            toggleModal(modal);
        });
    })
}

export function openModal(content) {
    // Если мы получаем чистый контент (функция вызывается откуда-то из js кода),
    // его необходимо предварительно обернуть в специальный элемент
    if (!content.hasClass('.modal')) {
        content = $('<div class="modal"></div>').append(content);
    }

    $('body').css('overflow', 'hidden');

    $('#modal-widget').addClass('active');
    $('.modal__wrapper').html(content);

    const event = new CustomEvent('modalOpened', { detail: { modalElement: $(content).children().first() }})
    document.dispatchEvent(event);
}

export function closeModal() {
    $('body').css('overflow', '');

    $('#modal-widget').removeClass('active');
    $('.modal__wrapper').html('');

    document.dispatchEvent(new CustomEvent('modalClosed'));
}

export function toggleModal(modal) {
    if ($('#modal-widget').hasClass('active')) {
        closeModal();
    } else {
        openModal(modal);
    }
}