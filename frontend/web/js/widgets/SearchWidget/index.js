import * as styles from './styles.scss';

export default new class SearchWidget {
    constructor() {
        if ($('#search-widget').length > 0) {
            this.form = $('#search-widget-form');

            this.init();
        }
    }

    init() {
        this.form.off('submit').on('submit', (event) => this.handleSearchApplying(event));
    }

    handleSearchApplying(event) {
        event.preventDefault();

        $(document).trigger('search:applied', [$(event.currentTarget).serializeArray()]);
    }
}()