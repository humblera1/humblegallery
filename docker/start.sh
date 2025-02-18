#!/bin/sh
# This script bootstraps the app-dev container
# Ensure that the Xdebug log file exists and has the proper permissions
mkdir -p /var/log/xdebug
chown www-data:www-data /var/log/xdebug
chmod 777 /var/log/xdebug

# Set Xdebug to use the new log file path
export XDEBUG_LOG=/var/log/xdebug/xdebug.log

# Create the log file and set the proper permissions
touch "$XDEBUG_LOG"
chown www-data:www-data "$XDEBUG_LOG"
chmod 666 "$XDEBUG_LOG"

# Ensure correct ownership and permissions for uploads directory
chown www-data:www-data /var/www/common/uploads && chmod 755 /var/www/common/uploads

# Install Composer dependencies if vendor directory does not exist,
# ensuring that vendor/autoload.php is available.
if [ ! -d vendor ]; then
  composer install --no-interaction --prefer-dist
fi

# Execute the official entrypoint to properly setup PHP-FPM (loads php.ini and configurations)
exec docker-php-entrypoint php-fpm --nodaemonize