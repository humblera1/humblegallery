<?php
return [
    'adminEmail' => env('ADMIN_EMAIL', 'admin@example.com'),
    'supportEmail' => env('SUPPORT_EMAIL', 'support@example.com'),
    'senderEmail' => env('SENDER_EMAIL', 'support@noreply@example.com.com'),
    'senderName' => env('SENDER_NAME', 'Example.com mailer'),

    'user.passwordResetTokenExpire' => 3600,
    'user.verificationTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'user.loginDuration' => 30 * 24 * 60 * 60,

    'artistsPerPage' => 10,
    'paintingsPerPage' => 15,
    'collectionsPerPage' => 12,

    'avatarsPath' => '@common/uploads/avatars/',
    'avatarsUrl' => '/uploads/avatars/',
    'collectionsPath' => '@common/uploads/collections/',
    'collectionsUrl' => '/uploads/collections/',

    'artistsPath' => '@common/uploads/artists/',
    'artistsThumbnailPath' => '@common/uploads/thumbnails/artists/',
    'artistsUrl' => '/uploads/artists/',
    'artistsThumbnailUrl' => '/uploads/thumbnails/artists/',

    'paintingsPath' => '@common/uploads/paintings/',
    'paintingsThumbnailPath' => '@common/uploads/thumbnails/paintings/',
    'paintingsUrl' => '/uploads/paintings/',
    'paintingsThumbnailUrl' => '/uploads/thumbnails/paintings/',

    'bsVersion' => '5.x',
];
