# Use an official PHP runtime as a parent image
FROM php:8.0

# Set the working directory in the container
WORKDIR /var/www/html

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html
# Expose port 3306 for MySQL
EXPOSE 3308


# Run the PHP built-in server when the container launches
CMD ["php", "-S", "0.0.0.0:{$PORT}", "-t", "."]
