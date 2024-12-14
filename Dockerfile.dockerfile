# Use the official PHP image with Apache
FROM php:8.1-apache

# Enable Apache mod_rewrite for URL rewriting (if needed)
RUN a2enmod rewrite

# Copy your project files into the container
COPY . C:\xampp\htdocs\mangement\Home.php

# Expose port 80 for HTTP traffic
EXPOSE 80
