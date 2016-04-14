FROM nginx:latest

RUN apt-get update -y &&\
  apt-get install -y php5-fpm &&\
  apt-get install -y php5-curl

COPY php.ini /etc/php5/fpm/php.ini
COPY www.conf /etc/php5/fpm/pool.d/www.conf
COPY default /etc/nginx/conf.d/default.conf
COPY info.php /usr/share/nginx/html/info.php
COPY cacert.pem /root/cacert.pem
COPY run.sh /run.sh

RUN chmod +x run.sh

EXPOSE 80

CMD ./run.sh
