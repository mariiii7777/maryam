# Use official PHP 8.2 CLI image
FROM php:8.2-cli

# Install required system dependencies
RUN apt-get update && apt-get install -y unzip git curl zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory inside container
WORKDIR /app

# Copy all project files into container
COPY . .

# Install PHP project dependencies without dev and skip post-install scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Expose the port used by PHP built-in server
EXPOSE 8000

# Default command to start the Symfony application using PHP server
CMD php -S 0.0.0.0:8000 -t public
