const LOGIN_URL = '/site/login'

export function onResponse(response) {
    if (response.success) {
        showSuccessMessage(response.message);
    } else {
        showErrorMessage(response.message);
    }
}

export function showSuccessMessage(message) {
    console.log('Success: ' + message);
}

export function showErrorMessage(message) {
    console.log('Error: ' + message);
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
    window.location.href = LOGIN_URL;
}