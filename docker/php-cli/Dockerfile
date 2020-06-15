FROM php:7.4-apache

## INSTALL SUDO
#RUN apt-get install sudo -y
RUN apt-get update && \
    apt-get install vim git -y

COPY yyy-php.ini /usr/local/etc/php/conf.d/
COPY 000-default.conf /etc/apache2/sites-enabled/000-default.conf



# On désactive totalement xdebug ce qui permet de gros gain en perf (notamment sur le cache:clear)
#RUN sed -i 's#zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20131226/xdebug.so#;zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20131226/xdebug.so#g' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini