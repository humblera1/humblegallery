import * as styles from './styles.scss';

export default new class FlashWidget {
    constructor() {
        const $widget = $('#flash-message');

        if ($widget.length > 0) {
            this.modal = $widget.find('.flash-message');
            this.overlay = $widget.find('.flash-message__overlay');
            this.close = $widget.find('.flash-message__close');
            this.title = $widget.find('.flash-message__title');
            this.message = $widget.find('.flash-message__message');
            this.flashes = Object.entries(JSON.parse($('#flash-data').text())).map(([type, message]) => ({ type, message }));

            this.currentIndex = 0;

            this.titles = {
                success: 'Отлично!',
                error: 'Что-то пошло не так...',
            };

            this.init();
        }
    }

    init() {
        this.overlay.on('click', () => this.closeFlash());
        this.close.on('click', () => this.closeFlash());

        this.showNextFlash();
    }

    showNextFlash() {
        if (this.currentIndex < this.flashes.length) {
            const flash = this.flashes[this.currentIndex];
            const className = `flash-message_${flash.type}`;

            this.title.text(this.titles[flash.type]);
            this.message.text(flash.message);
            this.modal.show();
            this.modal.addClass(`active ${className}`);
        }
    }

    closeFlash() {
        this.modal.removeClass('active');
        this.modal.hide();
        this.currentIndex++;
        this.showNextFlash();
    }
}()