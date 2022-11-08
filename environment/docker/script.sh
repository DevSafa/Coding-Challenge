#! /bin/bash
docker-compose build laravel-app
docker-compose up -d 
sleep 10
docker-compose exec laravel-app composer install 