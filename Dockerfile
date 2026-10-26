dockerfile<br>FROM php:8.3-apache<br>RUN docker-php-ext-install pdo_mysql<br>RUN echo 'date.timezone = ${TZ}' > /usr/local/etc/php/conf.d/zz-zona-horaria.ini<br>
