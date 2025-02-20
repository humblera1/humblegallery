FROM nginx:1.27.3-alpine

# Копируем статику
COPY ./frontend/web/images /var/www/frontend/web/images
COPY ./frontend/web/favicon.png /var/www/frontend/web/favicon.png
COPY ./backend/web/favicon.png /var/www/backend/web/favicon.png

# копируем скомпилированные стили админки
COPY ./backend/web/css/site.css /var/www/backend/web/css/site.css
COPY ./backend/web/css/admin.css /var/www/backend/web/css/admin.css
COPY ./backend/web/css/bootstrap/bootstrap.css /var/www/backend/web/css/bootstrap/bootstrap.css

# Копируем точки входа
COPY ./frontend/web/index.php /var/www/frontend/web/index.php
COPY ./backend/web/index.php /var/www/backend/web/index.php

# Копируем кастомный файл конфигурации Nginx
COPY ./docker/nginx/prod /etc/nginx/conf.d/

EXPOSE 80