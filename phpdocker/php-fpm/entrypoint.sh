#!/bin/bash

echo "Installing Composer packages"
php composer install

echo "run key Generate"
php artisan key:generate

echo "run Migrations"
php artisan migrate -n

echo 'permissions'
chmod -R 777 /application/storage/

#!/bin/bash
echo "run php fpm"
/usr/sbin/php-fpm8.3 -O
