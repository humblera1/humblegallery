function initMasonry () {
    $('.content').masonry({
        columnWidth: '.paint-container',
        itemSelector: '.paint-container',
        transitionDuration: '1s',
        percentPosition: true
    })
}

function reloadMasonry () {
    let $content = $('.content');

    $content.masonry('reloadItems');
    $content.masonry();
}