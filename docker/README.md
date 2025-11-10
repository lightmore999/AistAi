# Docker Setup для CRM Laravel

## Быстрый старт

1. Скопируйте `.env.example` в `.env` (если еще не сделано):
```bash
cp .env.example .env
```

2. **ВАЖНО:** Обновите настройки базы данных в `.env` для работы с Docker:
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=crm_laravel
DB_USERNAME=laravel
DB_PASSWORD=root
```

**Примечание:** `DB_HOST=db` - это имя сервиса из docker-compose.yml, не меняйте его на localhost!

3. Настройте Redis (если используется):
```
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

4. Запустите контейнеры:
```bash
docker-compose up -d
```

5. Установите зависимости:
```bash
docker-compose exec app composer install
```

6. Сгенерируйте ключ приложения:
```bash
docker-compose exec app php artisan key:generate
```

7. Запустите миграции:
```bash
docker-compose exec app php artisan migrate
```

8. Откройте в браузере: http://localhost:8000

## Решение проблем

### Конфликт портов с XAMPP

Если у вас запущен XAMPP MySQL на порту 3306, Docker MySQL будет использовать порт **3307** на вашей машине. Это нормально и не требует изменений в `.env` файле, так как внутри Docker контейнеров используется порт 3306.

### MySQL не запускается

1. Остановите XAMPP MySQL, если он запущен
2. Удалите старый volume: `docker-compose down -v`
3. Запустите заново: `docker-compose up -d`
4. Проверьте логи: `docker-compose logs db`

## Полезные команды

Остановить контейнеры:
```bash
docker-compose down
```

Просмотр логов:
```bash
docker-compose logs -f app
```

Выполнить команду artisan:
```bash
docker-compose exec app php artisan [команда]
```

Войти в контейнер:
```bash
docker-compose exec app bash
```

## Сервисы

- **app** - PHP 8.0 FPM приложение
- **nginx** - веб-сервер (порт 8000 на хосте)
- **db** - MySQL 8.0 (порт 3307 на хосте, 3306 внутри Docker)
- **redis** - Redis кэш (порт 6379)

