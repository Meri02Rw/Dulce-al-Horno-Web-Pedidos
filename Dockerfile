FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

COPY . /var/www/html/

RUN echo "=== ARCHIVOS ===" && ls -R /var/www/html/

EXPOSE 80