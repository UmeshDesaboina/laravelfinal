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
    nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# ✅ IMPORTANT: Set Apache to serve Laravel public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

# Enable mod_rewrite
RUN a2enmod rewrite

# ✅ COPY FULL PROJECT FIRST (FIXES YOUR ERROR)
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install frontend dependencies & build assets
RUN npm install && npm run build

# Laravel optimizations
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
