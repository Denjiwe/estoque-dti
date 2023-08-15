FROM php:8.1.12RC1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# ENV COMPOSER_ALLOW_SUPERUSER=1

# RUN composer install --prefer-dist --working-dir="/var/www/html/"

# RUN composer dump-autoload --working-dir="/var/www/html/"

# RUN php artisan optimize

# RUN php artisan route:clear

# RUN php artisan route:cache

# RUN php artisan config:clear

# RUN php artisan config:cache

# RUN php artisan view:clear

# RUN php artisan view:cache

CMD php artisan serve --host=0.0.0.0 --port=8000