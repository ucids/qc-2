FROM php:8.1.1-cli
# COPY ./local /usr/src/dst_folder
# WORKDIR /usr/src/dst_folder
RUN docker-php-ext-install pdo pdo_mysql
RUN echo "short_open_tag=On" >> /usr/local/etc/php/php.ini-development && \
    echo "short_open_tag=On" >> /usr/local/etc/php/php.ini-production