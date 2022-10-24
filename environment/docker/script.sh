#! /bin/bash
docker-compose down
docker-compose up -d 
sleep 10
docker-compose exec laravel-app php artisan migrate
docker-compose exec laravel-app php artisan db:seed