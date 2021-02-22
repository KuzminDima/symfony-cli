FROM php:7.4-fpm

# install required tools
# git for computing diffs
# wget for installation of other tools
# gnupg and g++ for gd extension
# locales for locale-gen command
# apt-utils so package configuartion does not get delayed
# unzip to ommit composer zip packages corruption
# dialog for apt-get to be
RUN apt-get update && apt-get install -y wget gnupg g++ locales unzip dialog apt-utils git && apt-get clean

# Install packages
RUN apt-get -yqq update \
    && apt-get install -y --no-install-recommends \
    nano \
    mc \
    vim \
    apt-utils \
    unzip \
    systemd \
    cron \
    htop \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    ;

# Install Composer
RUN curl -O "https://getcomposer.org/download/1.10.13/composer.phar"
RUN chmod a+x composer.phar
RUN mv composer.phar /usr/local/bin/composer
RUN echo $(composer --version)

# Install xdebugsud
# RUN pecl install xdebug; \
RUN pecl install  -o -f xdebug-2.9.8; \
    docker-php-ext-enable xdebug;

# Install php extensions.
RUN apt update && apt install -y --no-install-recommends \
        libfreetype6-dev \
        libxml2-dev \
        zlib1g-dev libicu-dev g++ \
        ;

# Install Redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis \
    ;

ADD ./docker/app/21-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
ADD ./docker/app/php.ini /usr/local/etc/php/conf.d/php.ini