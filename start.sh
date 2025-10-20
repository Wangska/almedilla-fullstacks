#!/bin/bash

# Create necessary directories
mkdir -p /var/log /var/lib/php/session /var/lib/php/wsdlcache /tmp/nginx

# Set proper permissions
chown -R nginx:nginx /var/lib/php ./public
chmod -R 755 /var/lib/php
chmod -R 755 ./public

# Copy nginx configuration
cp nginx.conf /etc/nginx/nginx.conf

# Copy PHP-FPM configuration
cp php-fpm.conf /etc/php-fpm.conf

# Start PHP-FPM in background
php-fpm -F &

# Start nginx in foreground
nginx -g 'daemon off;'
