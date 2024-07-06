FROM php:8.2.17-fpm

# Установка необходимых пакетов и расширений PHP
RUN apt-get update && apt-get install -y \
    git \
    libsodium-dev \
    libzip-dev \
    libpq-dev \
    zip \
    libpng-dev \
    libjpeg-dev \
    curl \
    libicu-dev \
    postgresql-client

RUN docker-php-ext-install -j$(nproc) \
        bcmath \
        opcache \
        pcntl \
        sockets \
        zip \
        intl \
        pdo \
        pdo_pgsql

# Добавление пользователя
RUN useradd -m -s /bin/bash test_case

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && ln -s $(composer config --global home) /root/composer

# Установка временной зоны
RUN ln -snf /usr/share/zoneinfo/Europe/Moscow /etc/localtime && echo "Europe/Moscow" > /etc/timezone

# Установка рабочей директории
WORKDIR /src

# Копирование файлов приложения в контейнер
COPY . .

# Изменение владельца рабочей директории на нового пользователя
RUN chown -R test_case:test_case /src

# Переключение на пользователя
USER test_case

# Установка зависимостей приложения
RUN composer install

# Добавление прав на выполнение скрипта
RUN chmod +x ./entrypoint.sh

# Открытие порта 9000
EXPOSE 9000

# Запуск скрипта
CMD ["./entrypoint.sh"]
