#!/bin/bash

git pull
composer2 install --no-dev --optimize-autoloader --ignore-platform-req=ext-redis
php bin/console asset-map:compile
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
php bin/websiteconsole cache:clear --no-warmup &&  php bin/adminconsole cache:clear --no-warmup
