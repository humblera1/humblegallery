import {onResponse, post, showErrorMessage} from "@utils";

new class ProfileViewManager {
    constructor() {
        if ($('.profile-info').length > 0) {
            this.form = $('#edit-form');

            this.imageContainer = $('.profile-info__image');
            this.fileInput = $('.file-input');

            this.previewActions = $('#preview-actions');
            this.deleteAction = $('#delete-action');

            this.init();
        }
    }

    init() {
        this.bindFormEvents();
        this.bindFileEvents();
        this.bindActionsEvent();
    }

    bindFormEvents() {
        this.form.on('beforeSubmit', (event) => {
            event.preventDefault();

            const form = $(event.currentTarget)[0];
            const formData = new FormData(form);

            post($(form).attr('action'), formData)
                .done((response) => {
                    onResponse(response);
                });

            return false;
        });
    }

    bindFileEvents() {
        this.fileInput.on('change', (event) => {
            const file = event.currentTarget.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    let img = this.imageContainer.find('img');

                    if (img.length) {
                        img.attr('src', e.target.result);
                    } else {
                        img = $('<img>', {src: e.target.result, alt: 'Cover'});
                        this.imageContainer.append(img);
                    }

                    this.previewActions.addClass('visible');
                }

                reader.readAsDataURL(file);
            }
        });
    }

    bindActionsEvent() {
        this.deleteAction.on('click', (event) => {
            $('#avatar-delete-input').val(1);

            this.imageContainer.find('img').remove();
            this.fileInput.val(''); // Clear the file input
            this.previewActions.removeClass('visible');
        });
    }
}()