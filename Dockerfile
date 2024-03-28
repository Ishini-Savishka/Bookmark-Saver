# Use an official PHP runtime as a parent image
FROM php:8.0

# Set the working directory in the container
WORKDIR /var/www/html

# Install PostgreSQL extension
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Run Composer to install dependencies
RUN composer install --no-dev

# Specify the port number the container should expose
EXPOSE 8000

# Run the PHP built-in server when the container launches
CMD ["php", "-S", "0.0.0.0:8000", "-t", "."]
