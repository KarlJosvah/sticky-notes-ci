# Use an official PHP runtime as a parent image
FROM php:8.1-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libsqlite3-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_sqlite

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html/

# Use the PORT environment variable in Apache configuration
# Cloud Run injects the PORT environment variable at runtime.
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Create database directory and ensure it's writable
RUN mkdir -p /var/www/html/application/database \
    && chown -R www-data:www-data /var/www/html/application/database

# Set permissions for the web server
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 8080 (default for Cloud Run, but can be anything)
EXPOSE 8080

# Start Apache in the foreground
CMD ["apache2-foreground"]
