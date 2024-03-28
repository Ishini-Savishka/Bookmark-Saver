# Use the official PHP image as the base image
FROM php:8.0-apache

# Copy the application code into the container
COPY . /var/www/html/

# Expose port 80 to allow incoming HTTP traffic
EXPOSE 80
