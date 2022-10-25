# Coding-Challenge

## About

build a simple web application to display Products with possibility to filter Products by categories  , sorting by Price
and Creating Product 

## Installation 
```bash
git clone https://github.com/DevSafa/Coding-Challenge.git
cd Coding-Challenge
cd environment/docker

# before running the script , change .env file to your configuration values
sh script.sh
```
### visit 
```bash
127.0.0.1:8000
```


### to test creation of product 
``` bash
php artisan test 
```

### to seed your databse with static categories
```bash
php artisan db:seed CategorySeeder
```
### to create a product from CLI 
```bash
 php artisan create:product
```


