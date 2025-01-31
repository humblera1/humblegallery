<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">HumbleGallery</h1>
    <br>
</p>

## Запуск в режиме разработки

Для запуска приложения выполните следующие шаги:

1. **Копирование `.env.dist`**

   Скопируйте файл `.env.dist` в корневой каталог проекта и переименуйте его в `.env`.

   ```bash
   cp .env.dist .env

2. **Запуск с `docker-compose`**
   
    Выполните команду для запуска контейнеров:
   
    ```bash
    docker-compose -f docker-compose.dev.yml up -d

3. **Инициализация**

    Выполните инициализацию приложения:

    ```bash
   ./init
   ```

4. **Запуск миграций**

    После инициализации выполните миграции:

    ```bash
    docker-compose exec app-dev php yii migrate

5. **Настройка портов для доступа к фронтенд и бэкенд-частям**

    Откройте файл .env и убедитесь, что переменные `FRONTEND_PORT` и `BACKEND_PORT` установлены на нужные значения. Эти порты будут использоваться для доступа к фронтенд и бэкенд-частям приложения в браузере.

    ```
    FRONTEND_PORT=8080
    BACKEND_PORT=8888
   ```

    После этого вы сможете получить доступ к фронтенд-части по адресу http://localhost:8080 и к бэкенд-части по адресу http://localhost:8888.

### **Настройка Xdebug**

Конфигурационный файл находится по адресу: `docker/php/conf.d/xdebug.ini`.
При запуске dev-контейнера значение `serverName` устанавливается в `app-dev`, убедитесь, что в конфигурации сервера в вашей среде оболочки вы задали соответствующие имя и порт.
 
### **Webpack**

Автоматически, при запуске `docker-compose` , включается режим наблюдения за файлами.
Так как директории хоста монтируются напрямую в контейнер в режиме разработки, webpack будет отслеживать изменения в файлах и пересобирать проект при необходимости.

## Запуск в режиме production

## Self-healing URLs

```php
    'container' => [
        'definitions' => [
            SelfHealingUrlHandlerInterface::class => CustomSelfHealingUrlHandlerTest::class,
        ],
    ],
```