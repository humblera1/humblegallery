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

//Логика добавления в коллекцию

//При загрузке страницы грузим содержимое модального окна
let collectionModalContent = $('#collectionModalContent');
loadCollectionModalContent();

function loadCollectionModalContent () {
    if (hasCollections) {
        collectionModalContent.load('/collection/get-user-collections');
    } else {
        collectionModalContent.load('/collection/get-new-collection', () => addFormHandlers());
    }
}

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
    $('#active-painting').removeAttr('id');

    $(overlay).removeClass('overlay--active');
    $(collectionModal).removeClass('modal--active');

    $('body').css('overflow', 'auto');
}

collectWrappers.on('click', function () {
    if (isGuest) {
        showLoginModal();
        return;
    }

    $(this).attr('id', 'active-painting');
    showCollectionModal();
});


function addFormHandlers() {
    $('#collection-form').on('beforeSubmit', function (event) {
        const activePaintingId = $('#active-painting').data('painting-id');
        const url = $(this).attr('action') + '?paintingId=' + activePaintingId;

        const sendForm = $.ajax(
            {
                type: $(this).attr('method'),
                url: url,
                data: $(this).serializeArray()
            }
        );

        sendForm.done(function(data) {
            collectionModalContent.html(data);
        });

        sendForm.fail(function () {
            console.log('ошибка при создании коллекции');
        });

        return false;
    })
}