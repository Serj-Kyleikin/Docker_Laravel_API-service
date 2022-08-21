#!/bin/bash

composer create-project --prefer-dist laravel/laravel

cd laravel

sudo chmod -R 777 storage/*
sudo chmod -R 777 bootstrap/cache

sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/g' .env
sed -i 's/DB_PASSWORD=/DB_PASSWORD=root/g' .env
sed -i 's/DB_DATABASE=laravel/DB_DATABASE=work/g' .env
sed -i 's/...protected..n/protected $n/g' app/Providers/RouteServiceProvider.php

cd ..
sudo cp -rpt laravel project/.

docker-compose up -d

echo "Done! Good luck.."