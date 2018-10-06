#version 3.1
FROM php:7.1.2-apache
MAINTAINER bassel "adrianjm@stud.ntnu.no"
RUN apt update
RUN apt -y install tzdata
RUN docker-php-ext-install mysqli
RUN apt -y install curl git unzip
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
ADD . /var/www/html/
WORKDIR "/var/www/html/"
RUN composer require "twig/twig:^2.0"
EXPOSE 80
