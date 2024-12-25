import * as styles from './styles.scss';

export default class FilterManager {
    constructor() {
        this.sections = $('.filter-section');
        this.items = $('.filter-item');
        // todo: избавиться от id
        this.reset = $('#reset-filter');
        this.open = $('#open-filter');
        this.init();
    }

    init() {
        this.items.on('click', (event) => this.handleClickOnItem(event));
        this.reset.on('click', (event) => this.handleReset(event));
        this.open.on('click', event => this.handleListOpening(event));

        // Не нужно, если при перезагрузке все фильтры сбрасываются (что является нормальным поведением)
        // this.sections.each((index, section) => {
        //     this.updateFilterCount($(section));
        // });
    }

    handleClickOnItem(event) {
        const $item = $(event.currentTarget);
        const $checkbox = $item.find('.filter-item__checkbox');
        const $circle = $item.find('.filter-item__circle');

        $item.toggleClass('filter-item_active');
        $circle.toggle();
        $checkbox.prop('checked', !$checkbox.prop('checked'));

        this.updateFilterCount($item.closest('.filter-section'));
    }

    handleListOpening(event) {
        const $item = $(event.currentTarget);
        const $list = $item.closest('.filter-section').find('.filter-section__list');

        $list.toggleClass('filter-section__list_opened');

        if ($list.hasClass('filter-section__list_opened')) {
            $item.text('скрыть');
        } else {
            $item.text('ещё...');
        }
    }

    handleReset(event) {
        const $section = $(event.currentTarget).closest('.filter-section');

        $section.find('.filter-item__checkbox').each((_index, checkbox) => {
            const $checkbox = $(checkbox);

            if ($checkbox.prop('checked')) {
                const $item = $checkbox.closest('.filter-item')
                const $circle = $item.find('.filter-item__circle');

                $item.toggleClass('filter-item_active');
                $circle.toggle();
                $checkbox.prop('checked', false);
            }
        });

        this.updateFilterCount($section);
    }

    updateFilterCount($section) {
        const count = $section.find('.filter-item__checkbox:checked').length;

        $section.find('.filter-section__badge span').text(count);
    }
}