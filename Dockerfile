# Use the official PHP image with Apache
FROM php:8.1-apache

# Copy your project files into the container
COPY . /var/www/html/

# Expose port 80 to allow HTTP traffic
EXPOSE 80
