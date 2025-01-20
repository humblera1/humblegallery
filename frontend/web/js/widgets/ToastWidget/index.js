import * as styles from './styles.scss';

export default new class ToastWidget {
    constructor() {
        const widget = $('#toast-widget');

        if (widget.length > 0) {
            this.container = widget.find('.toast__container');
            this.successfulToast = widget.find('.toast_success');
            this.errorToast = widget.find('.toast_error');

            this.init();
        } else {
            console.error('Widget element not found. You need to add a ToastWidget::widget() on the page');
        }
    }

    init() {
        //
    }

    showSuccessfulToast(message, duration = 3000) {
        this._showToast(this.successfulToast.clone(), message, duration);
    }

    showErrorToast(message, duration = 3000) {
        this._showToast(this.errorToast.clone(), message, duration);
    }

    _showToast(toast, message, duration) {
        toast.find('.toast__message').text(message);
        toast.find('.toast__close').on('click',() => this._closeToast(toast));

        this.container.prepend(toast);

        toast.fadeIn(300, () => {
            setTimeout(() => {
                this._closeToast(toast);
            }, duration);
        });
    }

    _closeToast(toast) {
        toast.fadeOut(500, () => {
            toast.remove();
        });
    }
}()