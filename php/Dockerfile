FROM php:7.4-cli
COPY . /usr/src/myapp

# Configure the gd library
RUN apt-get update \
  && apt-get install -y \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libxslt1-dev \
    sendmail-bin \
    sendmail \
    sudo



RUN docker-php-ext-configure \
  gd --with-freetype --with-jpeg

# Install required PHP extensions

RUN docker-php-ext-install \
  dom \
  gd \
  intl \
  pdo_mysql \
  xsl \
  zip \
  soap \
  sockets \
  bcmath

ENV PHP_MEMORY_LIMIT 2G
ENV PHP_ENABLE_XDEBUG false

ENV DEBUG false
ENV UPDATE_UID_GID true
