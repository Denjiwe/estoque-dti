FROM php:8.2.10RC1-fpm-alpine3.18

COPY composer.lock composer.json /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Install dependencies for the operating system software
RUN apk upgrade -U && \
    apk add --no-cache \
    # build-essential \
    # libpng-dev \
    # libjpeg62-turbo-dev \
    # libfreetype6-dev \
    # locales \
    # zip \
    # jpegoptim optipng pngquant gifsicle \
    vim \
    # libzip-dev \
    # unzip \
    # git \
    # libonig-dev \
    # curl
    nginx \
    php-fpm \
    # php-pdo \
    # php-dom \
    # php-json \
    # php-openssl \
    # php-phar \
    # php-mysqli \
    # php-pdo_mysql \
    php-curl 

# # Clear cache
# RUN apk clean && rm -rf /var/lib/apt/lists/*

# Install extensions for php
RUN docker-php-ext-install pdo_mysql opcache

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents to the working directory
COPY . /var/www/html

# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/storage/framework/views \
        /var/www/html/bootstrap/cache

# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000
CMD ["php-fpm"]