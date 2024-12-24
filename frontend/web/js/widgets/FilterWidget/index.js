import * as styles from './styles.scss';

export default class FilterManager {
    constructor() {
        this.items = $('.filter-item');
        this.init();
    }

    init() {
        this.items.on('click', (event) => this.handleClick(event));
    }

    handleClick(event) {
        const item = event.currentTarget
        const checkbox = item.querySelector('.filter-item__checkbox');
        const circle = item.querySelector('.filter-item__circle');

        $(item).toggleClass('filter-item_active');
        $(circle).toggle();
        checkbox.checked = !checkbox.checked;
    }
}