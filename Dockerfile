FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    default-mysql-client \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy application files to the container
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Set environment variables (for development/testing only — don't use this in production)
ENV DB_HOST=192.185.48.158
ENV DB_USER=bisublar_k9
ENV DB_PASS=k9Registration@2025
ENV DB_NAME=bisublar_k9
