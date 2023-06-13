FROM php:7.4-fpm

# аргументы, определенные в docker-compose.yml
ARG user
ARG uid
ARG APP_ENV

RUN apt-get update \
    && apt-get install -y apt-transport-https gnupg2 libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev unzip git curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_mysql mbstring

# получение последней версии Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./docker-compose/php/ini /usr/local/etc/php
# создание системного пользователя для запуска команд Composer и Artisan
RUN groupadd -f -g 977 docker \
    && groupadd -f -g 1008 pastebin \
    && useradd -G www-data,root,docker -g pastebin -u $uid -d /home/$user $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user
# Устанавливаем рабочую директорию
WORKDIR /var/www

# Копируем composer.lock и composer.json
#COPY composer.lock composer.json /var/www/

USER $user

#EXPOSE 9000
