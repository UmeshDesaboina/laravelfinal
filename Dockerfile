# FROM php:8.2-apache

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     libzip-dev \
#     zip \
#     unzip \
#     postgresql-client

# # Install PHP extensions
# RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Set working directory
# WORKDIR /var/www/html

# # Copy composer files first for better caching
# COPY composer.json composer.lock ./

# # Install dependencies
# RUN composer install --no-dev --optimize-autoloader --no-interaction

# # Copy application files
# COPY . .

# # Install Node.js and build assets
# RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
#     && apt-get install -y nodejs \
#     && npm install \
#     && npm run build

# # Create storage symlink
# RUN php artisan storage:link

# # Set permissions
# RUN chown -R www-data:www-data /var/www/html \
#     && chmod -R 755 /var/www/html/storage \
#     && chmod -R 755 /var/www/html/bootstrap/cache

# # Enable Apache mod_rewrite
# RUN a2enmod rewrite

# # Expose port
# EXPOSE 80

# # Start Apache
# CMD ["apache2-foreground"]

FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    libpq-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Set Apache document root to Laravel public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

# Enable mod_rewrite
RUN a2enmod rewrite

# Copy full project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install frontend dependencies & build assets
RUN npm install && npm run build

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 80

# Start Laravel properly (fixes your 500 error + DB issue)
CMD sh -c "php artisan config:clear && php artisan cache:clear && php artisan migrate --force && php artisan storage:link && apache2-foreground"
