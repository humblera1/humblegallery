(function() {
    if ($('.about').length > 0) {

        const credit = $('#qa-credit');

        const threshold = 150;
        let devtoolsOpen = false;

        const detectDevTools = () => {
            const widthThreshold = window.outerWidth - window.innerWidth > threshold;
            const heightThreshold = window.outerHeight - window.innerHeight > threshold;
            if (widthThreshold || heightThreshold) {
                if (!devtoolsOpen) {
                    devtoolsOpen = true;
                    credit.remove();
                }
            } else {
                if (devtoolsOpen) {
                    devtoolsOpen = false;
                    insertElementAtSecondToLast(credit);
                }
            }
        };

        const insertElementAtSecondToLast = (element) => {
            const container = $('.about__credits');
            const children = container.children();
            const secondToLastIndex = children.length - 1;

            if (secondToLastIndex >= 0) {
                children.eq(secondToLastIndex).before(element);
            } else {
                container.append(element);
            }
        };

        window.addEventListener('resize', detectDevTools);
        detectDevTools();

        $(document).ready(function() {
            $('.about__preview').click(function() {
                $(this).next('.about__paragraph').slideToggle();
                $(this).find('.about__icon').toggleClass('rotate');
            });
        });
    }
})();