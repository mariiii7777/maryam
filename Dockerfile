FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y unzip git curl zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy all files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port and set default command
EXPOSE 8000
CMD php -S 0.0.0.0:8000 -t public
