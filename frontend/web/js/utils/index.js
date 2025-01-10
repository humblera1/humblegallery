const LOGIN_URL = '/site/login'

export function showSuccessMessage(message) {
    console.log('Success: ' + message);
}

export function showErrorMessage(message) {
    console.log('Error: ' + message);
}

export function post(url, data = {}) {
    data[yii.getCsrfParam()] = yii.getCsrfToken();

    return $.post({
        url, data,
    });
}

export function get(url, data = {}) {
    return $.get({
        url, data,
    });
}

export function redirectToLoginPage() {
    window.location.href = LOGIN_URL;
}