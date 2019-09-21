FROM php:7.3-alpine

COPY . /usr/src/

WORKDIR /usr/src/api

RUN apk update && apk add \
        libzip-dev \
        coreutils \
        php7-ctype \
        php7-dom \
        php7-json \
        php7-intl \
        php7-mcrypt \
        php7-mbstring \
        php7-pdo \
        php7-pdo_mysql \
        php7-xml \
        php7-tokenizer \
        php7-simplexml \
        php7-xdebug \
        php7-zip \
        gcc \
        musl-dev \
        php7-dev \
        openssl-dev \
        pkgconfig

RUN docker-php-ext-install zip pdo pdo_mysql

RUN echo "$(curl -sS https://composer.github.io/installer.sig) -" > composer-setup.php.sig \
        && curl -sS https://getcomposer.org/installer | tee composer-setup.php | sha384sum -c composer-setup.php.sig \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer