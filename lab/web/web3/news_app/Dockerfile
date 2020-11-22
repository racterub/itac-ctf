FROM ubuntu:18.04

ENV DEBIAN_FRONTEND noninteractive

WORKDIR /var/www/html

RUN apt-get update
RUN apt-get upgrade -y
RUN apt-get install nginx php-fpm supervisor -y
RUN apt-get install php-mysql -y


RUN ln -sf /dev/stdout /var/log/nginx/access.log \
 && ln -sf /dev/stderr /var/log/nginx/error.log

RUN sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.2/fpm/php.ini
RUN sed -i "s/allow_url_fopen = On/allow_url_fopen = Off/" /etc/php/7.2/fpm/php.ini

COPY default /etc/nginx/sites-available/default

#RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default 


COPY supervisord.conf /etc/supervisord.conf
CMD ["/usr/bin/supervisord", "-n"]
RUN service php7.2-fpm start
