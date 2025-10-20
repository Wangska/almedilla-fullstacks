#!/bin/bash

# Create necessary directories
mkdir -p /var/log /tmp/nginx

# Set proper permissions
chmod -R 755 ./public

# Copy nginx configuration
cp nginx-simple.conf /etc/nginx/nginx.conf

# Start nginx with PHP built-in server
cd public
php -S 0.0.0.0:9000 &
nginx -g 'daemon off;'
