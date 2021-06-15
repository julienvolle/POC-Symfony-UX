FROM php:7.4-apache

COPY site.conf /etc/apache2/sites-available/site.conf
COPY php.ini /usr/local/etc/php/conf.d/custom-php.ini

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && a2enmod rewrite \
    && a2dissite 000-default \
    && a2ensite site \
    && service apache2 restart

# Install Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Install NodeJS
RUN apt update -y \
    && apt install -y nodejs \
    && apt install -y npm

# Install PDO
RUN docker-php-ext-install pdo pdo_mysql

# Install OPcache
RUN docker-php-ext-install opcache

# Install INTL
RUN apt update -y \
    && apt install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Install cURL
RUN apt update -y \
    && apt install -y libcurl4-openssl-dev curl \
    && docker-php-ext-install curl

# Install Memcached
RUN apt update -y \
    && apt install -y libmemcached11 libmemcachedutil2 build-essential libmemcached-dev libz-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

# Install APCu
RUN pecl install apcu \
    && docker-php-ext-enable apcu

# Install xDebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install GD
RUN apt update -y \
    && apt install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN apt autoremove -y

WORKDIR /var/www/html

EXPOSE 80
