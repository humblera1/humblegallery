let content = $('.content');
const form = $('#painting-form');
const filters = $('.filter');

const makeRequest = () => $.post('apply-filters', form.serializeArray());

$(document).ready(function() {
    initMasonry();
})

filters.each((index, filter) => {
    filter.addEventListener('change', applyFilters);
})

function applyFilters () {
    makeRequest()
        .done(data => {
            reloadContent(data);
            reloadMasonry();
        });
}

function reloadContent (data) {
    content.html(data);
}

function reloadMasonry () {
    content.masonry('reloadItems');
    content.masonry();
}

function initMasonry () {
    content.masonry({
        columnWidth: '.paint-container',
        itemSelector: '.paint-container',
        transitionDuration: '1s',
        percentPosition: true
    })
}