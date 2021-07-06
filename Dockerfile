FROM php:7.3-apache
RUN a2enmod rewrite
RUN apache2ctl graceful
ADD . /var/www/html
RUN chmod 777 -R /var/www/html/
EXPOSE 80