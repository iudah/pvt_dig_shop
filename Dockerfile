FROM php:7.4-apache
RUN apt-get update && apt-get install -y git mariadb-server
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /app
RUN git clone https://github.com/iudah/pvt_dig_shop.git
RUN mv pvt_dig_shop/*   /var/www/html
RUN mariadb -e "ALTER USER 'root'@'localhost' IDENTIFIED VIA mysql_native_password;" 
RUN mariadb -e "ALTER USER 'root'@'localhost' IDENTIFIED VIA 'password';" 
RUN mariadb -e "source shop.sql" -u root -p password
 