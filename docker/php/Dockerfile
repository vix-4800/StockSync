FROM php:8.2-fpm

LABEL Anton Vix <https://github.com/vix-4800>

RUN apt update && \
    apt install -y openssl zip unzip libzip-dev libicu-dev

RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql zip intl

RUN apt clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000
CMD ["php-fpm"]
