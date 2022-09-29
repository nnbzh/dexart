FROM php:8.0-fpm-alpine

# Set working directory
WORKDIR /var/www/dexart

# Install Additional dependencies
RUN apk update && apk add --no-cache \
    bash \
    build-base shadow supervisor \
    libxml2-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    libmcrypt-dev \
    libltdl \
    pcsc-lite-dev \
    autoconf \
    php8-pdo \
    php8-pdo_mysql \
    php8-mysqli \
    php8-mbstring \
    php8-openssl \
    php8-json \
    php8-phar \
    php8-gd \
    php8-session

# Remove Cache
RUN rm -rf /var/cache/apk/*


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Use the default production configuration ($PHP_INI_DIR variable already set by the default image)
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
# Add UID '1000' to www-data
RUN usermod -u 1000 www-data

COPY . .

RUN composer install
RUN chown -R www-data:www-data .
