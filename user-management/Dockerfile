FROM php:8.1-apache
RUN apt-get update --fix-missing
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions
RUN install-php-extensions intl zip pdo pdo_mysql
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && mv composer.phar /usr/local/bin/composer
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf
COPY ./user-management /var/www/
WORKDIR /var/www/public
RUN cd /var/www/public
EXPOSE 80