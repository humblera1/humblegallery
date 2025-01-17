<?php
return [

    // Картины
    'paintings' => 'painting/default/index',
    'paintings/<slugHash:[a-zA-Z0-9\-]+-[a-zA-Z0-9]+>' => 'painting/default/view',
    'PATCH paintings/<id:\d+>/toggle-like' => 'painting/default/toggle-like',

    // Художники
    'artists' => 'artist/default/index',
    'artists/<slugHash:[a-zA-Z0-9\-]+-[a-zA-Z0-9]+>' => 'artist/default/view',

    // Коллекции
    'GET collections/create-form' => 'collection/default/create-form',
    'GET collections/<id:\d+>/edit-form' => 'collection/default/edit-form',
    'GET collections/with-painting-form/<paintingId:\d+>' => 'collection/default/with-painting-form',
    'GET collections/available-collections/<paintingId:\d+>' => 'collection/default/available-collections',

    // Routes for AJAX form data validation
    'POST collections/validate-form' => 'collection/default/validate-form',

    'POST collections' => 'collection/default/create',
    'POST collections/create-with-painting' => 'collection/default/create-with-painting',
    'POST collections/<id:\d+>/update' => 'collection/default/update',
    'POST collections/<id:\d+>/toggle-painting/<paintingId:\d+>' => 'collection/default/toggle-painting',
    'PATCH collections/<id:\d+>/restore' => 'collection/default/restore',
    'DELETE collections/<id:\d+>' => 'collection/default/delete',

    // Аутентификация
    'auth/<action:(signup|login|logout|request-password-reset|resend-verification-email|captcha)>' => 'auth/<action>',
    'auth/reset-password/<token:\w+>' => 'auth/reset-password',
    'auth/verify-email/<token:\w+>' => 'auth/verify-email',

    // Профиль пользователя
    'users/<username:[a-zA-Z0-9]+>' => 'user/default/view',
    'users/<username:[a-zA-Z0-9]+>/favorites' => 'user/default/favorites',
    'users/<username:[a-zA-Z0-9]+>/collections' => 'user/default/collections',
    'users/<username:[a-zA-Z0-9]+>/collections/<slugHash:[a-zA-Z0-9\-]+-[a-zA-Z0-9]+>' => 'user/default/collection-view',
    [
        'pattern' => 'users/<username:[a-zA-Z0-9]+>/settings',
        'route' => 'user/default/settings',
        'defaults' => [],
    ],

    'about' => 'site/about',
//    'paintings/<action>' => 'painting/default/<action>',
//    'collections/<action>' => 'collection/default/<action>',
    '' => 'site/index', //TODO:поправить маршрут

];