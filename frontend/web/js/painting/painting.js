let content = $('.content');
const form = $('#painting-form');
const filters = $('.filter');
const collectionModal = $('#collection-modal');

const heartWrappers = $('.action__wrapper_heart');
const collectWrappers = $('.action__wrapper_collect');

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

//Взаимодействия с картинами

function showCollectionModal() {
    overlay.addClass('overlay--active');
    collectionModal.addClass('modal--active');

    $('body').css('overflow', 'hidden');

    //Кнопка с закрытием окна
    $('.close-button').on('click', function () {
        hideModal();
    })

    $('.modal__wrapper').on('click', function (event) {
        if (event.target === this) {
            hideCollectionModal();
        }
    })
}

function hideCollectionModal() {
    $(overlay).removeClass('overlay--active');
    $(collectionModal).removeClass('modal--active');

    $('body').css('overflow', 'auto');
}

heartWrappers.on('click', function () {
    if (isGuest) {
        showLoginModal();
        return;
    }

    const heart = $(this).find('.action__icon');
    heart.toggleClass('action__icon_liked');

    makeLikeRequest($(this).data('painting-id'))
        .fail(() => heart.toggleClass('action__icon_liked'));
})

collectWrappers.on('click', function () {
    if (isGuest) {
        showLoginModal();
        return;
    }

    showCollectionModal();
});