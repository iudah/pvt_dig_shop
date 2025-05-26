FROM php:7.4-apache
RUN apt-get update && apt-get install -y git php-mysql mysql-server
WORKDIR /app
RUN git clone https://github.com/iudah/pvt_dig_shop.git
RUN mv pvt_dig_shop/*   /var/www/html
RUN mysql -e "source shop.sql" -u root -p 
RUN service mysql start
 