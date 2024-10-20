FROM php:8.1-apache

# instalar dependencias e extensoes php necessárias

RUN docker-php-ext-install pdo pdo_mysql

EXPOSE 80