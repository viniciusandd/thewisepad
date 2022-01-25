FROM php:7.4-cli

RUN apt update

RUN apt install -y zip

RUN curl -sS https://getcomposer.org/installer | php \
    && chmod +x composer.phar \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/app

COPY . .

RUN composer install --dev