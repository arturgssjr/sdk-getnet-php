FROM php:7.3

LABEL maintainer="Artur Júnior <arturgssjr@gmail.com>"

RUN apt-get update && apt-get install -y \
    vim \
    git

# Configuração XDebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo 'xdebug.remote_port=9000' >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.remote_enable=1' >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.remote_connect_back=1' >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

# Configuração OPcache
RUN docker-php-ext-install opcache

# Configuração Timezone
ARG TZ="UTC"
ENV TZ=${TZ}
RUN echo "################# Timezone: ${TZ}"
RUN echo "date.timezone=America/Sao_Paulo" > $PHP_INI_DIR/conf.d/date.timezone.ini

# Configuração Composer
RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

# Criar grupo e usuário 1000
RUN getent group 1000 || groupadd web -g 1000
RUN getent passwd 1000 || adduser --uid 1000 --gid 1000 --disabled-password --gecos "" web 
RUN usermod -a -G web www-data

WORKDIR /var/www