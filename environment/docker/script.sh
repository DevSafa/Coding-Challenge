#! /bin/bash
docker-compose build laravel-app
docker-compose up -d 
sleep 10
docker-compose exec laravel-app composer install
docker-compose exec laravel-app php artisan migrate
docker-compose exec laravel-app php artisan db:seed  