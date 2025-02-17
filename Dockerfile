FROM php:8.1-fpm

# Instala dependências necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configura o Laravel
WORKDIR /var/www
COPY . .
RUN composer update
RUN composer install \
    && composer require tymon/jwt-auth \
    && php artisan jwt:secret

# Define permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exposição da porta padrão do Laravel
EXPOSE 8000
CMD ["php", "artisan", "serve"]