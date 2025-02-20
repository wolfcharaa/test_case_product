# Напишите админку для простейшего каталога товаров

1. Реализовать вывод списка товаров в виде таблицы с постраничником со следующими столбцами:
* Изображение
* SKU
* Название
* Кол-во на складе
* Тип товара
2. Форма создания нового товара.
3. Возможность редактировать товар.
4. Возможность удаления нескольких товаров (чекбоксы).
5. Возможность пользователю указать, какие столбцы ему нужны, а какие нет при просмотре таблицы (настраиваемая видимость столбцов).
6. Одно поле для поиска, с помощью которого будет происходить поиск товара по столбцам "SKU" и "Название".
7. Доступ в админку возможен только авторизованным пользователям.

## Технические требования:
* Dockerfile
* PHP 8.2+
* Ссылка на репозиторий

## Будет плюсом:
* Использование паттернов проектирования

___
# Установка проекта

- Достаточно будет выполнить только команду 
```bash
docker-compose up -d
```

> Зайти на проект можно будет по [адресу](http://127.0.0.1:8080/admin) 

- Пользователь `admin@admin.com` 
- Пароль  `admin`

> Зайти в контейнер можно командой
```bash
docker exec -it test /bin/bash
```
