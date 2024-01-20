const loginButton = $('#login-button');
const overlay = $('#overlay');
const loginModal = $('#login-modal');

loginButton.on('click', () => {
    showLoginModal();
    showLoginForm();
})

function showLoginModal() {
    $(overlay).addClass('overlay--active');
    $(loginModal).addClass('modal--active');

    $('body').css('overflow', 'hidden');

    //Кнопка с закрытием окна
    $('.close-button').on('click', function () {
        hideModal();
    })

    $('.modal__wrapper').on('click', function (event) {
        if (event.target === this) {
            hideModal();
        }
    })
}

function showLoginForm() {
    $('#login-content').load('/user/default/login');
}

function hideModal() {
    $(overlay).removeClass('overlay--active');
    $(loginModal).removeClass('modal--active');

    $('body').css('overflow', 'auto');
}