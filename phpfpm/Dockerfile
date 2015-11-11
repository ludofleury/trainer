FROM debian:jessie

RUN apt-get update && apt-get install -y \
  php5-cli \
  php5-fpm \
  php5-intl \
  php5-curl \
  php5-mcrypt \
  php5-mysql \
  php5-json \
  php5-apcu

RUN sed -e 's/;daemonize = yes/daemonize = no/' -i /etc/php5/fpm/php-fpm.conf && \
  sed -i "s@listen = /var/run/php5-fpm.sock@listen = 9000@" /etc/php5/fpm/pool.d/www.conf

COPY symfony.ini /etc/php5/fpm/conf.d/
COPY symfony.ini /etc/php5/cli/conf.d/

EXPOSE 9000

ENTRYPOINT chmod 777 /var/www/application/app/cache && \
  chmod 777 /var/www/application/app/logs && \
  php5-fpm -F
