let content = $('.content');
const form = $('#painting-form');
const filters = $('.filter');

const $collectionModal = $('#collection-modal');
const $creationModal = $('#creation-modal');

const heartWrappers = $('.action__wrapper_heart');
const $collectWrappers = $('.action__wrapper_collect');

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
let $cache = $('#cache');

//--------------------------------------------------------------------------------------------------------------requests

/**
 * Basic POST request
 * @returns {jqXHR}
 */
function postRequest (url, data) {
    return $.ajax({
        type: 'POST',
        url: url,
        data: data,
        headers: {
            'X-CSRF-TOKEN': yii.getCsrfToken()
        }
    });
}

/**
 * Request to add painting to collection
 *
 * @param paintingId
 * @param collectionId
 * @returns {jqXHR}
 */
function addPaintingToCollectionRequest (paintingId, collectionId) {
    return postRequest('/collection/add', {paintingId: paintingId, collectionId: collectionId})
}

/**
 * Request to create new collection and add painting to it
 * @returns {jqXHR}
 * @param data
 */
function createCollectionAndAddPainting (data) {
    return postRequest('/collection/create-and-add', data)
}

const makeRequestForCollections = (paintingId) => $.get('/collection/get-painting-collections?paintingId=' + paintingId);

initCollectionModal();

/**
 * Load content of modal window, adds event handlers to collection items
 */
function initCollectionModal() {
    $collectionModalContent.load('/collection/get-modal-content', function () {
        if ($(this).find('.collection-box').length) {
            addEventHandlersToCollections();
        }
    });
}

function addEventHandlersToCollections() {
    $('#new-collection').on('click', () => {
        loadCreationForm();
    })

    $('.collection-item__preview').on('click', function () {
        const $collectionItem = $(this).parent();
        const $activePainting = $('#active-painting');

        const activePaintingId = $activePainting.data('painting-id');
        const collectionId = $collectionItem.data('collection-id');

        const paintingTitle = $activePainting.data('painting-title');
        const collectionTitle = $collectionItem.data('collection-title');

        const isAddition = $(this).children(":first").css('display') === 'none';

        hideCollectionModal();

        addPaintingToCollectionRequest(activePaintingId, collectionId)
            .done(() => successRequestHandler(isAddition, paintingTitle, collectionTitle, $activePainting))
            .fail(() => failRequestHandler(isAddition, paintingTitle, collectionTitle));
    })
}

function loadCreationForm () {
    $cache.html($collectionModalContent.html());
    $collectionModalContent.load('/collection/get-new-collection', () => addFormHandlers());
}

function addFormHandlers() {
    $('#collection-form').on('beforeSubmit', function (event) {
        let formData = $(this).serializeArray();

        const $activePainting = $('#active-painting');

        const collectionTitle = formData.find(e => e.name === 'Collection[title]').value;
        const paintingTitle = $activePainting.data('painting-title');
        const paintingId =  $activePainting.data('painting-id');

        formData.push({name: 'paintingId', value: paintingId});

        createCollectionAndAddPainting(formData)
            .done(() => successRequestHandler(true, paintingTitle, collectionTitle, $activePainting))
            .fail(() => failRequestHandler(true, paintingTitle, collectionTitle));

        $cache.html('');

        return false;
    })
}

function updateIcon ($painting) {

    const collectionsIds = $painting.data('collections-ids');

    if (collectionsIds !== '') {
        if (typeof collectionsIds === 'number') {
            $collectionItems.each(function () {
                if (collectionsIds === $(this).data('collection-id')) {
                    $(this).addClass('collection-item--marked');
                }
            })

            return;
        }

        const collectionsIdsAsArray = collectionsIds.split(',');
        $collectionItems.each(function () {
            if (collectionsIdsAsArray.includes(String($(this).data('collection-id')))) {
                $(this).addClass('collection-item--marked');
            }
        })
    }
    console.log($painting);
    const $icon = $painting.find('i');
    const id = $painting.data('painting-id');

    makeRequestForCollections(id)
        .done(data => {
            const collectionsContainingPaintingIds = JSON.parse(data);
            if (collectionsContainingPaintingIds.includes(id)) {
                $icon.removeClass('fa-plus').addClass('fa-check');
            } else {
                $icon.removeClass('fa-check').addClass('fa-plus');
            }
        })
}

function hideCollectionModal () {
    unmarkCollections();
    $('#active-painting').removeAttr('id');

    if ($cache.html() !== '') {
        $collectionModalContent.html($cache.html());
        if ($collectionModalContent.find('.collection-box').length) {
            addEventHandlersToCollections();
        }
        $cache.html('');
    }
    hideModal();
}

/**
 * После запроса модалка закрывается моментально, её содержимое обновляется (в случае успеха), а пользователю показывается сообщение
 */
function successRequestHandler (isAddition, paintingTitle, collectionTitle, $painting) {
    initCollectionModal();
    updateIcon($painting);

    const successMessage = isAddition
        ? `Картина '${paintingTitle}' успешно добавлена в коллекцию '${collectionTitle}'`
        : `Картина '${paintingTitle}' успешно удалена из коллекции '${collectionTitle}'`;

    showMessage(successMessage);
}

function failRequestHandler (isAddition, paintingTitle, collectionTitle) {
    const failureMessage = isAddition
        ? `Не удалось добавить картину '${paintingTitle}' в коллекцию '${collectionTitle}'`
        : `Не удалось удалить картину '${paintingTitle}' из коллекции '${collectionTitle}'`;

    showMessage(failureMessage);
}

function showMessage (message) {
    console.log(message)
}

/**
 * Helper function, checks the content of modal window
 */
function modalHasCollections() {
    return $('.collection-box').length;
}

/**
 * Adds click event handlers to icon
 */
$collectWrappers.on('click', function () {
    if (isGuest) {
        showLoginModal();
        return;
    }

    $(this).attr('id', 'active-painting');
    showCollectionModal();
});

/**
 * Show modal window with collections.
 * If there are some collections, function checks which of them contains chosen painting, and marks them
 */
function showCollectionModal() {
    prepareCollectionModal();

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

function prepareCollectionModal() {
    overlay.addClass('overlay--active');
    $('body').css('overflow', 'hidden');

    $('.close-button').on('click', function () {
        hideCollectionModal();
    })

    $('.modal__wrapper').on('click', function (event) {
        if (event.target === this) {
            hideCollectionModal();
        }
    })
}

/**
 * Receives data from server, that contains ids of collections, containing chosen painting.
 * Collections with this ids will be marked by special class
 */
function markCollections (data) {
    const collectionsContainingPaintingIds = JSON.parse(data);

    $('.collection-item').each(function () {
        if (collectionsContainingPaintingIds.includes($(this).data('collection-id'))) {
            $(this).addClass('collection-item--marked');
        }
    })
}

function unmarkCollections () {
    $('.collection-item').removeClass('collection-item--marked');
}