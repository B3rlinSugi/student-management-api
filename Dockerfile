FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/app

# Copy composer files first (cache layer)
COPY composer.json composer.lock ./

# Install PHP dependencies (no dev)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy the full Laravel application
COPY . .

# Set permissions for storage and cache
RUN chmod -R 775 storage bootstrap/cache

# Expose port (Railway sets $PORT dynamically)
EXPOSE 8000

# Start Laravel (uses $PORT from Railway env)
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
