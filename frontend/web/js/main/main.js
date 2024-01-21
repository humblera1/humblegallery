const loginButton = $('#login-button');
const overlay = $('#overlay');
const loginModal = $('#login-modal');
const loginContent = $('#login-content');

const actionLogin = $('#action-login');
const actionSignup = $('#action-signup');

([actionLogin, actionSignup]).forEach(function (action) {
    action.on('click', function () {
        action.data('action') === 'signup' ? showSignupForm() : showLoginForm();
    })
});

loginButton.on('click', () => {
    showLoginModal();
    showLoginForm();
})

function showLoginModal() {
    overlay.addClass('overlay--active');
    loginModal.addClass('modal--active');

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
    actionLogin.addClass('action-active');
    actionSignup.removeClass('action-active');
    loginContent.load('/user/login');
}

function showSignupForm() {
    actionSignup.addClass('action-active');
    actionLogin.removeClass('action-active');
    loginContent.load('/user/signup');
}

function hideModal() {
    $(overlay).removeClass('overlay--active');
    $(loginModal).removeClass('modal--active');

    $('body').css('overflow', 'auto');
}