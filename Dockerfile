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
    && rm -rf /var/lib/apt/lists/*

# Configuração Timezone
ARG TZ="UTC"
RUN echo "date.timezone=${TZ}" > $PHP_INI_DIR/conf.d/date.timezone.ini

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
RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" $PHP_INI_DIR/conf.d/xdebug.ini && \
    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" $PHP_INI_DIR/conf.d/xdebug.ini && \
    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" $PHP_INI_DIR/conf.d/xdebug.ini

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

WORKDIR /var/www