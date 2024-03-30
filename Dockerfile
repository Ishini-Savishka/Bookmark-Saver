# Use an official PHP runtime as a parent image
FROM php:8.0

# Set the working directory in the container
WORKDIR /var/www/html

# Install mysqli extension
RUN apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html
# Expose port 3306 for MySQL

CMD ["php", "-S", "0.0.0.0:3306", "-t", "/var/www/html"]
