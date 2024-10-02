FROM php:8.2-apache

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN mkdir -p /cron && \
    mkdir -p /var/log/cron

RUN apt update && \
    apt upgrade -y && \ 
    apt install -y tzdata cron \
    libzip-dev zip \
    libpng-dev

RUN docker-php-ext-install mysqli && \
    docker-php-ext-install zip && \
    docker-php-ext-install gd

RUN composer require box/spout && \
    composer require phpoffice/phpspreadsheet && \
    composer require guzzlehttp/guzzle:^7.0

RUN mv /var/www/html/vendor /cron/vendor

COPY ./cron/cronjob /etc/cron.d/cron
COPY cron/*.php /cron/
COPY cron/cron.sh /cron/

RUN chmod +x /cron/cron.sh

RUN chmod 0644 /etc/cron.d/cron
RUN crontab /etc/cron.d/cron

RUN sed -i 's/^exec /printenv \> \/etc\/environment\n\nexec /' /usr/local/bin/apache2-foreground
RUN sed -i 's/^exec /service cron start\n\nexec /' /usr/local/bin/apache2-foreground
RUN sed -i 's/^exec /php \/cron\/main.php\n\nexec /' /usr/local/bin/apache2-foreground

COPY ./app /var/www/html

WORKDIR /var/www/html
