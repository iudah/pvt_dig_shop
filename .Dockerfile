FROM php:7.4-apache
RUN apt-get update && apt-get install -y git
WORKDIR /app
RUN git clone github.com/iudah/pvt_dig_shop.git
RUN mv pvt_dig_shop/*   /var/www/html
 