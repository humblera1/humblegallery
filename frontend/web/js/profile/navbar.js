const ACTIVE_CLASS = 'navigation__li_active';
const URL = 'section';
navItems = $('.navigation__li');



navItems.each(function (index, item) {
    $(item).on('click', function (event) {
        navItems.removeClass(ACTIVE_CLASS);
        $(this).addClass(ACTIVE_CLASS);

        const sectionName = $(this).data('section-name');
        loadSectionContent(sectionName);
    })

    // if ($(item).find('a').attr('href') === window.location.pathname) {
    //     $(item).addClass('navigation__li_active');
    // }

})

function loadSectionContent (sectionName) {
    const url = createUrl(sectionName);
    $('.profile__content').load(url);
}

function createUrl (sectionName) {
    return URL + '/' + sectionName;
}
