# Use an official PHP runtime as a parent image
FROM php:8.0

# Set the working directory in the container
WORKDIR /var/www/html

# Install the PostgreSQL client and server packages
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Expose port 80 for web server
EXPOSE 80

# Start the PHP web server
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]
