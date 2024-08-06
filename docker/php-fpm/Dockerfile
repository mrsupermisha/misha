FROM php:8.2.12-fpm-alpine

RUN apk add --no-cache \
    autoconf \
    bash \
    coreutils \
    gettext \
    php82-ctype \
    php82-curl \
    php82-dom \
    php82-gd \
    php82-iconv \
    php82-json \
    php82-intl \
    php82-fileinfo\
    php82-mbstring \
    php82-opcache \
    php82-openssl \
    php82-pdo \
    php82-pdo_pgsql \
    php82-pgsql \
    php82-xml \
    php82-xsl \
    php82-zlib \
    php82-phar \
    php82-tokenizer \
    php82-session \
    php82-simplexml \
    php82-zip \
    php82-xmlwriter \
    php82-sodium \
    php82-pecl-apcu \
    libzip-dev \
    zip \
    make \
    curl \
    g++ \
    git \
    openssh \
    postgresql-dev \
    tzdata \
    openrc \
    vim

ENV TZ=Europe/Moscow

RUN docker-php-ext-install pdo pdo_pgsql;
RUN docker-php-ext-install zip;

RUN apk add --no-cache linux-headers;
RUN pecl install xdebug;
RUN docker-php-ext-enable xdebug;

RUN mkdir -p /usr/src/php/ext/trader; \
	curl -fsSL https://pecl.php.net/get/trader --ipv4 | tar xvz -C "/usr/src/php/ext/trader" --strip 1; \
	docker-php-ext-install trader;

RUN apk add --no-cache rabbitmq-c-dev && \
    mkdir -p /usr/src/php/ext/amqp && \
    curl -fsSL https://pecl.php.net/get/amqp | tar xvz -C "/usr/src/php/ext/amqp" --strip 1 && \
    docker-php-ext-install amqp

# Enable php8-xdebug if $PHP_XDEBUG_MODE is not empty
ARG PHP_XDEBUG_MODE=off
ARG PHP_XDEBUG_CLIENT_PORT=5902
ARG PHP_XDEBUG_CLIENT_HOST=host.docker.internal
ARG PHP_IDE_CONFIG=host.docker.internal

COPY ./docker/php-fpm/conf.d/xdebug.ini  /etc/php82/conf.d/xdebug.ini.template
COPY ./docker/php-fpm/conf.d/xdebug.ini  /usr/local/etc/php/conf.d/xdebug.ini.template
COPY ./docker/php-fpm/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN if [[ "$PHP_XDEBUG_MODE" != "" ]]; then \
        apk add --no-cache php82-pecl-xdebug; \
        export PHP_XDEBUG_MODE=$PHP_XDEBUG_MODE; \
        export PHP_XDEBUG_CLIENT_PORT=$PHP_XDEBUG_CLIENT_PORT; \
        export PHP_XDEBUG_CLIENT_HOST=$PHP_XDEBUG_CLIENT_HOST; \
        envsubst < /etc/php82/conf.d/xdebug.ini.template > /etc/php82/conf.d/xdebug.ini; \
        envsubst < /usr/local/etc/php/conf.d/xdebug.ini.template > /usr/local/etc/php/conf.d/xdebug.ini; \
    fi

RUN rm -f /etc/php82/conf.d/xdebug.ini.template
RUN rm -f /usr/local/etc/php/conf.d/xdebug.ini.template

RUN curl -sS https://getcomposer.org/installer | tee composer-setup.php \
    && php composer-setup.php && rm composer-setup.php* \
    && chmod +x composer.phar && mv composer.phar /usr/bin/composer

ARG WORKING_DIR

CMD ["php-fpm", "-F"]

EXPOSE 9000
