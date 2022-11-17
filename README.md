# Coding-Challenge

# About
build a simple web application to display Products with possibility to filter Products by category , sorting by Price and Creating Products


# Prerequisite
install docker-engine (docker cli - docker deamon - docker-compose ) in your machine

# Installation

```bash
git clone https://github.com/DevSafa/Coding-Challenge.git
cd Coding-Challenge
```

## Configuration
```bash
  #mandatory
    change (PATH_PROJECT) environment variable in : (environment/docker/.env)
      PATH_PROJECT=/home/safa/Desktop/Coding-Challenge/Projects/challenge
  #optional :
    #change environment variables in  : (environment/docker/.env)  AND (Projects/challenge/.env)
      DB_CONNECTION=mysql
      DB_HOST=mysql-db
      DB_PORT=3306
      DB_DATABASE=productsCategories
      DB_USERNAME=safa
      DB_PASSWORD=safa
    #change (user) and (uid) in : (environment/docker/docker-compose.yaml)
      args:
        user: safa
        uid:  1000
```
```bash 
cd environment/docker

#the script will automatically build images run containers and seed database with some data 
sh script.sh
```

# Run
```bash
#to run tests :  product creation using endpoint |  command line interface

docker-compose exec laravel-app ./vendor/bin/phpunit

#to create product from command line interface
#image url is a valid link to an image in the internet and it will be uploaded through command line

docker-compose exec laravel-app product:create  
```

# browser

```bash
  #application web
  127.0.0.1:8000
  
  #database interface phpmyadmin
    #server   :  #DB_HOST=mysql-db
    #username :  #DB_USERNAME=safa
    #password :  #DB_PASSWORD=safa
  127.0.0.1:8081
  
  #endpoints
    #show all categories
    127.0.0.1:8000/categories
  
    #show all products
    127.0.0.1:8000/products
  
    #show products of a specific category
    127.0.0.1/category/products/{id}
```
