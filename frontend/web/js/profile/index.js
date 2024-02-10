const ACTIVE_CLASS = 'navigation__li_active';
const BASE_URL = '/profile';

const SECTION_FAVORITES = 'favorites';

const $navItems = $('.navigation__li');
const $sectionContent = $('.profile__section-content');

let pageUrl = window.location.pathname;
let pageUrlArray = pageUrl.split('/');

//унести в виджет
if (pageUrlArray.length === 3) {
    const sectionName = pageUrlArray.at(-1);

    $navItems.removeClass(ACTIVE_CLASS);
    const sectionElement = $('.navigation__li[data-section-name="' + sectionName + '"]');

    if (sectionElement) {
        sectionElement.addClass(ACTIVE_CLASS);
    }
}

$navItems.each(function (index, item) {
    $(item).on('click', function (event) {

        const sectionName = $(this).data('section-name');

        updatePageUrl(sectionName);

        $navItems.removeClass(ACTIVE_CLASS);
        $(this).addClass(ACTIVE_CLASS);

        loadSectionContent(sectionName);
    })
})

function loadSectionContent (sectionName) {
    const url = createSectionUrl(sectionName);
    $sectionContent.load(url, function () {
        if ($(this).find('#section').data('section-name') === SECTION_FAVORITES) {
            initMasonry();
            $("#favorite-pjax").on("pjax:end", function() {
                initMasonry();
            });
        }
    });
}


function createSectionUrl (sectionName) {
    return BASE_URL + '/' + sectionName;
}

function updatePageUrl(sectionName) {
    const pageUrl = createSectionUrl(sectionName);
    history.pushState(null, null, pageUrl);
}