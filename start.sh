#!/bin/bash

# Create necessary directories
mkdir -p /var/log /var/lib/php/session /var/lib/php/wsdlcache /tmp/nginx

# Set proper permissions
chown -R nginx:nginx /var/lib/php /app/public
chmod -R 755 /var/lib/php
chmod -R 755 /app/public

# Copy nginx configuration
cp /app/nginx.conf /etc/nginx/nginx.conf

# Copy PHP-FPM configuration
cp /app/php-fpm.conf /etc/php-fpm.conf

# Start PHP-FPM in background
php-fpm -F &

# Start nginx in foreground
nginx -g 'daemon off;'
