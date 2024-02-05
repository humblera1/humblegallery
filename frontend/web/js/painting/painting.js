let content = $('.content');
const form = $('#painting-form');
const filters = $('.filter');

const $collectionModal = $('#collection-modal');
const $creationModal = $('#creation-modal');

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

//Логика работы с коллекциями
let $collectionModalContent = $('#collectionModalContent');
const makeRequestForCollections = (paintingId) => $.get('/collection/get-painting-collections?paintingId=' + paintingId);

initCollectionModal();

function initCollectionModal() {
    $collectionModalContent.load('/collection/get-modal-content');
}

function modalHasCollections() {
    return $('.collection-box').length;
}

function showCollectionModal() {
    prepareModal();

    if (modalHasCollections()) {
        const activePaintingId = $('#active-painting').data('painting-id');
        makeRequestForCollections(activePaintingId)
            .done((data) => {
                markCollections(data);
                $collectionModal.addClass('modal--active');
            })
    } else {
        $collectionModal.addClass('modal--active');
    }
}

function markCollections (data) {
    if (hasCollections) {
        const collectionsContainingPaintingIds = JSON.parse(data);

        $('.collection-item').each(function () {
            if (collectionsContainingPaintingIds.includes($(this).data('collection-id'))) {
                $(this).addClass('collection-item--marked');
            }
        })
    }
}

collectWrappers.on('click', function () {
    if (isGuest) {
        showLoginModal();
        return;
    }

    $(this).attr('id', 'active-painting');

    showCollectionModal();
});


// function showCollectionModal() {
//
//     collectionModal.addClass('modal--active');
//
//
//
//     //Кнопка с закрытием окна
//
// }
//
// function hideCollectionModal() {
//     $('#active-painting').removeAttr('id');
//
//     $(overlay).removeClass('overlay--active');
//     $(collectionModal).removeClass('modal--active');
//     unmarkCollections();
//
//     $('body').css('overflow', 'auto');
// }
//
// function initCollectionModal() {
//     // 1. Грузим содержимое модалки
//     collectionModalContent.load('/collection/get-modal-content', () => {
//         if ($('.collection-box')) {
//             //2а. Обработка коллекций initCollections();
//             const activePaintingId = $('#active-painting').data('painting-id');
//             makeRequestForCollections(activePaintingId)
//                 .done(data => markCollections(data))
//                 .done(() => bindCollectionActions())
//                 .done(() => showCollectionModal());
//         } else {
//             //2б. Обработка формы создания initCreationForm();
//             addFormHandlers()
//         }
//     });
// }
//
// const makeRequestForCollections = (paintingId) => $.get('/paintings/like', {paintingId: paintingId});
//
// collectWrappers.on('click', function () {
//     if (isGuest) {
//         showLoginModal();
//         return;
//     }
//
//     $(this).attr('id', 'active-painting');
//
//     initCollectionModal();
//
//
//     //Получаем id коллекций, содержащих данную картину
//     $.ajax(
//         {
//         'url': '/collection/get-painting-collections' + '?paintingId=' + $(this).data('painting-id'),
//         }
//     )
//         .done(data => markCollections(data))
//         .done(() => bindCollectionActions())
//         .done(() => showCollectionModal());
// });
//
// function bindCollectionActions() {
//     $('#new-collection').on('click', () => {
//         collectionModalContent.load('/collection/get-new-collection', () => addFormHandlers());
//     })
//
//     $('.collection-item__preview').on('click', function () {
//         const activePaintingId = $('#active-painting').data('painting-id');
//         const collectionId = $(this).parent().data('collection-id');
//
//         const url = 'collection/add' + '?paintingId=' + activePaintingId + '&collectionId=' + collectionId;
//
//         // collectionModalContent.load(url, () => hideCollectionModal());
//     })
// }
//
// function markCollections (data) {
//     //Проверить содержимое модального окна
//     if (true) {
//         const collectionsContainingPaintingIds = JSON.parse(data);
//         $('.collection-item').each(function () {
//             if (collectionsContainingPaintingIds.includes($(this).data('collection-id'))) {
//                 $(this).addClass('collection-item--marked');
//             }
//         })
//     }
// }
//
// function unmarkCollections () {
//     $('.collection-item').removeClass('collection-item--marked');
// }
//
//
// function addFormHandlers() {
//     $('#collection-form').on('beforeSubmit', function (event) {
//         const activePaintingId = $('#active-painting').data('painting-id');
//         const url = $(this).attr('action') + '?paintingId=' + activePaintingId;
//
//         const sendForm = $.ajax(
//             {
//                 type: $(this).attr('method'),
//                 url: url,
//                 data: $(this).serializeArray()
//             }
//         );
//
//         sendForm.done(function(data) {
//             collectionModalContent.html(data);
//         });
//
//         sendForm.fail(function () {
//             console.log('ошибка при создании коллекции');
//         });
//
//         return false;
//     })
// }