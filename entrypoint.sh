#!/bin/bash

# Запуск команды artisan serve
php artisan serve --host=0.0.0.0 --port=9000 &

# Запуск команды artisan migrate
php artisan migrate -n

# генерация ключа для Laravel приложения
php artisan key:generate

# Удержание контейнера в рабочем состоянии
wait -n
