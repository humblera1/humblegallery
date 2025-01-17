import imagesLoaded from "imagesloaded";
import './masonry';

export default new class MasonryWidget {
    constructor() {
        this.widget = $('#masonry-widget');

        if (this.widget.length > 0) {
            this.init();
        }
    }

    init() {
        this.pjaxId = this.widget.data('pjax-id');

        this.initMasonry();
        this.bindEvents();
    }

    initMasonry() {
        $(document).on('DOMContentLoaded', () => {
            $(this.widget).masonry({
                columnWidth: '.painting-card',
                itemSelector: '.painting-card',
                transitionDuration: '1s',
                percentPosition: true
            });
        });

        // Дожидаемся загрузки контента в Pjax
        $(this.widget).on('pjax:success', () => {
            // todo: likes & collections
            imagesLoaded(this.widget[0], () => {
                this.widget.masonry('reloadItems');
                this.widget.masonry();
            });
        });
    }

    bindEvents() {
        $(document).on('masonry:reload', (event, data) => {
            this.reloadContent(data);
        });
    }

    reloadContent(data) {
        $.pjax.reload({
            container: `#${this.pjaxId}`,
            type: 'POST',
            data: data,
            push: false,
            replace: false
        });
    }
}()