FROM php:8.2-apache

# Install ca-certificates and required system tools
RUN apt-get update && apt-get install -y ca-certificates curl git unzip && update-ca-certificates && rm -rf /var/lib/apt/lists/*

# Install official PHP extensions
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql gd zip bcmath mbstring exif

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Configure Apache DocumentRoot to point to Laravel /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set storage and cache permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Dynamically bind to Render's $PORT, clear cache, run migrations, and launch Apache
CMD sh -c "TARGET_PORT=\${PORT:-80}; sed -i \"s/Listen .*/Listen \$TARGET_PORT/\" /etc/apache2/ports.conf; sed -i \"s/<VirtualHost \*:.*/<VirtualHost *:\$TARGET_PORT>/\" /etc/apache2/sites-available/*.conf; php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan migrate --force; apache2-foreground"
