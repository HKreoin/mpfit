## Задеплоенный сайт
http://user686175.web.cloud4box.ru/admin/login
mail: admin@mail.com
pass: secret

## Установка

Скопируй репозиторий с помощью git clone

```bash
cd mpfit
composer install
```
npm install не требуется
Сконфигурируй файл .env
```bash
cp .env.example .env
php artisan key:generate
```
Запусти миграции:
```bash
php artisan migrate
```
Запусти сиды:
```bash
php artisan db:seed
```

Создание пользователя-администратора
```bash
php artisan make:filament-user
```

Запуск локально на http://127.0.0.1:8000/admin/login
```bash
php artisan ser
```
