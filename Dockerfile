# FROM composer:latest as build
# WORKDIR /app
# COPY . /app
# # RUN pecl install -o -f redis \
# # &&  rm -rf /tmp/pear \
# # &&  docker-php-ext-enable redis
# RUN apt-get install autoconf
# RUN pecl install redis \
#     && docker-php-ext-enable redis

# RUN composer install

FROM php:8.1-apache
RUN apt-get update \
    && apt-get install -y gnupg curl wget ca-certificates unzip lsb-release libssl-dev pkg-config supervisor \
    # && wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add - \
    # && echo "deb http://apt.postgresql.org/pub/repos/apt/ `lsb_release -cs`-pgdg main" | tee  /etc/apt/sources.list.d/pgdg.list \
    # && curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    # && apt-get install -y \
        # libicu-dev \
        # libpq-dev \
        # libzip-dev \
    && pecl install redis \
    && pecl install mongodb \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable mongodb \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
    # && chown -R www-data:www-data /var/www

WORKDIR /app
COPY . /app

# COPY laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf
# COPY laravel-worker.conf /etc/supervisor/supervisord.conf
# COPY --from=build /app /app
RUN composer install
COPY vhost.conf /etc/apache2/sites-available/000-default.conf
EXPOSE 80
RUN chown -R www-data:www-data /app
RUN a2enmod rewrite

# CMD nohup php artisan queue:work --daemon &

# RUN php artisan migrate

COPY supervisord.conf /etc/supervisor/supervisord.conf
CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]

# CMD supervisord -c /etc/supervisor/supervisord.conf

# RUN supervisorctl reread 
# RUN supervisorctl update 
# RUN service supervisor start 
# CMD ["supervisord", "start",  "laravel-worker:*"]
# CMD /usr/bin/supervisord -c /etc/supervisor/conf.d/laravel-worker.conf