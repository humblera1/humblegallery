import {onResponse, post, showErrorMessage} from "@utils";

new class ProfileSettingsManager {
    constructor() {
        if ($('.profile-settings').length > 0) {
            this.form = $('#settings-form');
            this.submitButton = $('#settings-submit');

            this.init();
        }
    }

    init() {
        this.submitButton.on('click', () => {
            post(this.form.attr('action'), this.form.serializeArray())
                .done((response) => onResponse(response))
                .fail(() => showErrorMessage('Не удалось выполнить запрос'));
        });
    }
}()