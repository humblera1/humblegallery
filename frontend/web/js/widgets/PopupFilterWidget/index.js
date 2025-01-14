import * as styles from './styles.scss';

export default class PopupFilterWidget {
    constructor() {
        this.trigger = $('.filter-widget__badge');
        this.popup = $('.filter-widget__popup');
        this.form = $('#filter-widget-form');
        this.inputs = $('.filter-widget__input');

        this.init();
    }

    init() {
        this.initPopup();
        this.initInputs();
        this.initSubmit();
    }

    initPopup() {
        this.trigger.on('click', () => this.togglePopup());

        $(document).on('click', (event) => {
            if (!this.popup.is(event.target) && this.popup.has(event.target).length === 0 &&
                !this.trigger.is(event.target) && this.trigger.has(event.target).length === 0) {

                this.popup.removeClass('active');
            }
        });
    }

    initInputs() {
        this.inputs.on('click', (event) => {
            this.handleItemSelection(event);
        });
    }

    initSubmit() {
        this.form.off('submit').on('submit', (event) => this.handleFilterApplying(event));
    }

    /**
     * Данное событие используется для обновления той или иной части данных в представлении.
     * @param event
     */
    handleFilterApplying(event) {
        event.preventDefault();

        $(document).trigger('filters:applied', [$(event.currentTarget).serializeArray()]);
    }

    handleItemSelection(event) {
        const $input = $(event.currentTarget);
        const $item = $input.closest('.filter-widget__item');
        const $section = $input.closest('.filter-widget__section');

        if (!$section.data('multiple')) {
            $section.find('.filter-widget__item').removeClass('active');
        }

        $item.toggleClass('active');
    }

    togglePopup() {
        this.popup.toggleClass('active');
    }
}