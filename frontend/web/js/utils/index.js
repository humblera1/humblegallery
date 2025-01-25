import Toast from '@widgets/ToastWidget/index';
import urls from "@urls";

const LOGIN_URL = '/site/login';

export function onResponse(response) {
    if (response.message) {
        response.success ? showSuccessMessage(response.message) : showErrorMessage(response.message);
    }
}

export function onErrorResponse() {
    Toast.showErrorToast('Не удалось выполнить запрос');
}

export function showSuccessMessage(message) {
    Toast.showSuccessfulToast(message);
}

export function showErrorMessage(message) {
    Toast.showErrorToast(message);
}

export function get(url, data = {}) {
    return $.get({
        url, data,
    });
}

export function post(url, data = {}) {
    if (data instanceof FormData) {
        // Append CSRF token to FormData
        data.append(yii.getCsrfParam(), yii.getCsrfToken());

        return $.ajax({
            url: url,
            type: 'POST',
            data: data,
            contentType: false, // Important for FormData
            processData: false, // Important for FormData
        });
    }

    data[yii.getCsrfParam()] = yii.getCsrfToken();

    return $.post({
        url, data,
    });
}

export function put(url, data = {}) {
    data[yii.getCsrfParam()] = yii.getCsrfToken();

    return $.ajax(url, {
        'method': 'PUT',
        data,
    });
}

export function patch(url, data = {}) {
    data[yii.getCsrfParam()] = yii.getCsrfToken();

    return $.ajax(url, {
        'method': 'PATCH',
        data,
    });
}

export function requestDelete(url, data = {}) {
    data[yii.getCsrfParam()] = yii.getCsrfToken();

    return $.ajax(url, {
        'method': 'DELETE',
        data,
    });
}

export function redirectToLoginPage() {
    window.location.href = urls.auth.login;
}