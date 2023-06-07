### Инструкция по деплою приложения на локальной машине

>При условии установленных: php8.1, composer 2.5+, mysql server

1. Клонировать репозиторий
```
git clone git@github.com:Mezuno/laravel-todolist.git путь-к-проекту/
```
2. Скопировать .env.example в .env и настроить подключение к базе данных
3. Выполнить миграции
```
php artisan migrate --seed
```
(`--seed` опционально, заполняет тестовыми данными)

4. Выполнить установку зависимостей (--ignore-platform-reqs у composer при необходимости):
```
composer install
npm install
```
5. Поднять локальный сервер:
```
php artisan serve
npm run dev
```
