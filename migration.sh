#!/bin/bash
sudo apt install php-mysql
sudo apt-get install -y php-mysql
# Run Laravel migration (by force, since it would be a prod-environment)
php artisan migrate --force
php artisan db:seed

# Run Apache in "foreground" mode (the default mode that runs in Docker)
apache2-foreground