let content = $('.content');
const form = $('#painting-form');
const filters = $('.filter');

const makeRequest = () => $.post('apply-filters', form.serializeArray());

$(document).ready(function() {
    initMasonry();
})

filters.each((index, filter) => {
    filter.addEventListener('change', applyFilters);
    filter.addEventListener('change', markLabel);
})

function applyFilters () {
    makeRequest()
        .done(data => {
            reloadContent(data);
        })
        .done(() => reloadMasonry())
        .fail(error => console.log(error));
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


//Работа со стилизацией фильтров
function markLabel () {
    $(this).parent().toggleClass('filter--active');
}