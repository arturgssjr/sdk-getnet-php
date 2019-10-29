FROM php:latest

LABEL maintainer="Artur Júnior <arturgssjr@gmail.com>"

RUN apt-get update && \
    apt-get upgrade -y &&\
    apt-get install -y --no-install-recommends \
    vim \
    git \
    curl \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

# Configuração XDebug
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; then \
  if [ $(php -r "echo PHP_MAJOR_VERSION;") = "5" ]; then \
    pecl install xdebug-2.5.5; \
  else \
    pecl install xdebug; \
  fi && \
  docker-php-ext-enable xdebug \
;fi

COPY ./conf/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini
RUN sed -i "s|xdebug.remote_autostart=0|xdebug.remote_autostart=1|g" $PHP_INI_DIR/conf.d/xdebug.ini && \
    sed -i "s|xdebug.remote_enable=0|xdebug.remote_enable=1|g" $PHP_INI_DIR/conf.d/xdebug.ini && \
    sed -i "s|xdebug.cli_color=0|xdebug.cli_color=1|g" $PHP_INI_DIR/conf.d/xdebug.ini

# Configuração OPcache
ARG INSTALL_OPCACHE=false
RUN if [ ${INSTALL_OPCACHE} = true ]; then \
    docker-php-ext-install opcache \
;fi

COPY ./conf/opcache.ini $PHP_INI_DIR/conf.d/opcache.ini

# Configuração Composer
RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

# Criar grupo e usuário 1000
RUN getent group 1000 || groupadd web -g 1000
RUN getent passwd 1000 || adduser --uid 1000 --gid 1000 --disabled-password --gecos "" web 
RUN usermod -a -G web www-data

# Configuração php.ini
ARG APPLICATION_ENVIRONMENT="production"
ENV APPLICATION_ENVIRONMENT=${APPLICATION_ENVIRONMENT}
RUN mv "$PHP_INI_DIR/php.ini-${APPLICATION_ENVIRONMENT}" "$PHP_INI_DIR/php.ini"
ARG TZ="UTC"
RUN sed -i "s|;date.timezone =|date.timezone = ${TZ}|g" $PHP_INI_DIR/php.ini && \
    sed -i "s|max_execution_time = 30|max_execution_time = 60|g" $PHP_INI_DIR/php.ini && \
    sed -i "s|max_input_time = 60|max_input_time = 90|g" $PHP_INI_DIR/php.ini && \
    sed -i "s|memory_limit = 128M|memory_limit = 256M|g" $PHP_INI_DIR/php.ini

WORKDIR /var/www