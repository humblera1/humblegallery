let content = $('.content');
const form = $('#painting-form');
const filters = $('.filter');

const heartWrappers = $('.action__wrapper_heart');

const makeFilterRequest = () => $.post('/paintings/apply-filters', form.serializeArray());
const makeLikeRequest = (paintingId) => $.post('/paintings/like', {paintingId: paintingId});

$(document).ready(function() {
    initMasonry();
})

filters.each((index, filter) => {
    filter.addEventListener('change', applyFilters);
    filter.addEventListener('change', markLabel);
})

function applyFilters () {
    makeFilterRequest()
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

//Лайки на картины
heartWrappers.on('click', function () {
    if (isGuest) {
        showLoginModal();
        return;
    }

    const heart = $(this).find('.action__icon');
    heart.toggleClass('action__icon_liked');

    makeLikeRequest($(this).data('painting-id'))
        .done(flag => console.log(flag))
        .fail(error => console.log(error));
})