# Coding-Challenge

## First method of  installation of laravel  : 
  using  Homestead vagrant box  :
  
  ```bash
  #Clone the repository
  git clone https://github.com/DevSafa/Coding-Challenge.git
  
  #overwrite your homestead.yaml
  bash init.sh 
    
  #create and initialize your vagrant box
  vagrant up 
  ```
  
  ## Usage
  ```bash
  #ssh to your vagrant box
  vagrant ssh 
  vagrant@homestead:~$ cd $ProjectPath
  vagrant@homestead:~$ composer install
  vagrant@homestead:~$ npm install 
  vagrant@homestead:~$ npm run watch-poll 
  ```
  ## browser 
  ```bash
  #to show categories - subcategories and products 
  127.0.0.1:8000
  ```
## Second one is by using Docker 
