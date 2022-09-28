# Default Dockerfile

ARG ALPINE_VERSION=3.12

FROM alpine:$ALPINE_VERSION

LABEL maintainer="MineManage Developers <group@stye.cn>" version="1.0" license="MIT" app.name="MineManage"

ARG ALPINE_VERSION=3.12

# trust this project public key to trust the packages.
ADD https://php.hernandev.com/key/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub

##
# ---------- building ----------
##
RUN set -ex \
    # change apk source repo
    && echo "https://php.hernandev.com/v$ALPINE_VERSION/php-7.4" >> /etc/apk/repositories \
    && echo "@php https://php.hernandev.com/v$ALPINE_VERSION/php-7.4" >> /etc/apk/repositories \
    && apk update \
    && apk add --no-cache \
    # Install base packages ('ca-certificates' will install 'nghttp2-libs')
    ca-certificates \
    curl \
    wget \
    tar \
    xz \
    libressl \
    tzdata \
    pcre \
    php7 \
    php7-bcmath \
    php7-curl \
    php7-ctype \
    php7-dom \
    php7-gd \
    php7-iconv \
    php7-json \
    php7-mbstring \
    php7-mysqlnd \
    php7-openssl \
    php7-pdo \
    php7-pdo_mysql \
    php7-pdo_sqlite \
    php7-phar \
    php7-posix \
    php7-redis \
    php7-sockets \
    php7-sodium \
    php7-sysvshm \
    php7-sysvmsg \
    php7-sysvsem \
    php7-zip \
    php7-zlib \
    php7-xml \
    php7-xmlreader \
    php7-pcntl \
    php7-opcache \
    && ln -sf /usr/bin/php7 /usr/bin/php \
    && apk del --purge *-dev \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man /usr/share/php7 \
    && php -v \
    && php -m \
    && echo -e "\033[42;37m Build Completed :).\033[0m\n"


##
# ---------- env settings ----------
##
ENV COMPOSER_VERSION=${COMPOSER_VERSION:-"2.3.10"} \
    #  install and remove building packages
    PHPIZE_DEPS="autoconf dpkg-dev dpkg file g++ gcc libc-dev make php7-dev php7-pear pkgconf re2c pcre-dev pcre2-dev zlib-dev libtool automake"

# update
RUN set -ex \
    && apk update \
    # for swoole extension libaio linux-headers
    && apk add --no-cache libstdc++ openssl git bash \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS php7-fileinfo php7-simplexml php7-xmlwriter libaio-dev openssl-dev curl-dev zlib-dev  c-ares-dev \
    # php extension:swoole
    && ln -s /usr/bin/pecl7 /usr/local/bin/pecl \
    && pecl channel-update pecl.php.net \
    && pecl install --configureoptions 'enable-sockets="no" enable-openssl="yes" enable-http2="yes" enable-mysqlnd="no" enable-swoole-json="yes" enable-swoole-curl="yes" enable-cares="no"' swoole \
    && echo "memory_limit=1G" > /etc/php7/conf.d/00_default.ini \
    && echo "opcache.enable_cli = 'On'" >> /etc/php7/conf.d/00_opcache.ini \
    && echo "extension=swoole.so" > /etc/php7/conf.d/50_swoole.ini \
    && echo "swoole.use_shortname = 'Off'" >> /etc/php7/conf.d/50_swoole.ini \
    # php extension:xlswriter
    && pecl install --configureoptions 'enable-reader="yes"' xlswriter \
    &&  echo "extension=xlswriter.so" >> /etc/php7/conf.d/50-xlswriter.ini \
    # install composer
    && wget -nv -O /usr/local/bin/composer https://github.com/composer/composer/releases/download/${COMPOSER_VERSION}/composer.phar \
    && chmod u+x /usr/local/bin/composer \
    # php info
    && php -v \
    && php -m \
    && php --ri swoole \
    && composer \
    # ---------- clear works ----------
    && apk del .build-deps \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man /usr/local/bin/php* \
    && echo -e "\033[42;37m Build Completed :).\033[0m\n"


#WORKDIR /www
#
## Composer Cache
# COPY ./composer.* /www/
# RUN composer install --no-dev --no-scripts
#
#COPY . /www
#RUN composer config -g repo.packagist composer https://mirrors.aliyun.com/composer && composer install --no-dev -o && php bin/hyperf.php && php bin/hyperf.php migrate
#
#EXPOSE 9501
#
#ENTRYPOINT ["php","/www/bin/hyperf.php","start"]