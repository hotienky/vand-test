FROM php:8.0-apache


#install all the system dependencies and enable PHP modules
RUN apt-get update && apt-get install -y \
      cron \
      libicu-dev \
      libpq-dev \
      libmcrypt-dev \
      gnupg2 \
      zip \
      zlib1g-dev \
      unzip \
      libfreetype6-dev \
      libjpeg62-turbo-dev \
      libpng-dev \
      libzip-dev \
      libmagickwand-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install \
      pdo_mysql \
      zip \
      gd \
      opcache

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

#set our application folder as an environment variable
ENV APP_HOME /var/www/html

#change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

#change the web_root to laravel /var/www/html/public folder
RUN sed -i -e "s/html/html\/public/g" /etc/apache2/sites-enabled/000-default.conf
RUN sed -i -e "s/CustomLog \${APACHE_LOG_DIR}\/access.log combined/CustomLog \/dev\/null combined/g" /etc/apache2/sites-enabled/000-default.conf

# enable apache module rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY composer.json composer.lock composer.phar ./

RUN php composer.phar clear-cache
#copy source files and run composer
COPY --chown=www-data:www-data . .

RUN php composer.phar install --no-dev

#change ownership of our applications
RUN mkdir -p storage/logs
RUN chown -R www-data:www-data storage public

COPY ./docker/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh && ln -s /usr/local/bin/docker-entrypoint.sh /
RUN echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]

