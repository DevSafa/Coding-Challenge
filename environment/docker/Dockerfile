# base image 
FROM php:7.4-fpm
# defined in docker-compose.yml
# the user and uid arguments are used to create  and set up a User system  
ARG user
ARG uid
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip
RUN apt-get install -y nodejs npm
# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
# install Composer by copying the composer executable from its latest official image to application image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
# Set working directory - set the default working dir as /var/www
WORKDIR /var/www
# change to the newly created user.
USER $user


