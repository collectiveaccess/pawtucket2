FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteractive

#Apache
ARG APACHE_VERSION=2.4.63
RUN apt -qq update && apt-get -qq install curl wget gnupg && apt-get -qq install wget vim libreadline-dev libssl-dev libpcre3-dev libexpat1-dev build-essential bison zlib1g-dev libxss1 libappindicator1 libindicator7 sudo tzdata unzip less

RUN wget https://ai.galib.uga.edu/files/httpd-$APACHE_VERSION-w-apr.tar.gz && tar xzf httpd-$APACHE_VERSION-w-apr.tar.gz && cd httpd-$APACHE_VERSION && ./configure  '--prefix=/app/apache2' '--with-apxs2=/app/apache2/bin/apxs' '--with-mysqli' '--with-pear' '--with-xsl' '--with-pspell' '--enable-ssl' '--with-gettext' '--with-gd' '--enable-mbstring' '--with-mcrypt' '--enable-soap' '--enable-sockets' '--with-libdir=/lib/i386-linux-gnu' '--with-jpeg-dir=/usr' '--with-png-dir=/usr' '--with-curl' '--with-pdo-mysql' '--enable-so' '--with-included-apr' && make -j$(nproc) && make install && cd ..&& rm -rf httpd-$APACHE_VERSION*

ENV PATH /app/apache2/bin:$PATH

RUN sed -i "s/\/snap\/bin/\/snap\/bin:\/app\/apache2\/bin/" /etc/sudoers

#PHP
ARG PHP_VERSION=8.2.24
RUN apt -qq update && apt-get -qq install libcurl4-gnutls-dev pkg-config libpng-dev libonig-dev libsqlite3-dev libxml2-dev libzip-dev libwebp-dev libjpeg-dev libmemcached-dev memcached && wget https://www.php.net/distributions/php-$PHP_VERSION.tar.gz && tar xzf php-$PHP_VERSION.tar.gz && cd php-$PHP_VERSION && './configure'  '--prefix=/usr/local' '--with-apxs2=/app/apache2/bin/apxs' '--with-mysqli' '--enable-mbstring' '--with-pdo-mysql' '--with-openssl' '--with-zlib' '--enable-gd' '--with-jpeg' '--with-webp' '--enable-opcache' '--with-curl' '--enable-exif' '--with-zip' '--enable-intl' '--enable-bcmath' && make -j$(nproc) && make install && cp php.ini-production /usr/local/lib/php.ini && cd .. && rm -rf php-$PHP_VERSION*

RUN apt -qq update && apt-get -qq install autoconf && wget https://pecl.php.net/get/memcached-3.1.5.tgz && tar xzf memcached-3.1.5.tgz && cd memcached-3.1.5 && phpize && ./configure && make && make install && echo "extension=memcached.so" >> /usr/local/lib/php.ini && cd .. && rm -rf memcached-3.1.5*

#Config changes for php
RUN sed -i "s/memory_limit = 128M/memory_limit = 1G/" /usr/local/lib/php.ini

#PHPRedis
RUN apt update && apt-get install -qq -y libzstd-dev && wget https://github.com/phpredis/phpredis/archive/refs/tags/5.3.4.tar.gz && tar xzf 5.3.4.tar.gz && cd phpredis-5.3.4 && phpize && ./configure --enable-redis-zstd && make -j$(nproc) && make install && echo "extension=redis.so" >> /usr/local/lib/php.ini &&  cd .. && rm -rf phpredis-5.3.4

#Composer
RUN curl --output /usr/local/bin/composer https://getcomposer.org/composer.phar     && chmod +x /usr/local/bin/composer

#GitLab runner
ARG LOCAL_UID=1000
RUN adduser --uid $LOCAL_UID --gecos 'gitlab-runner user' --disabled-password gitlab-runner

#Prepare docroot
RUN rm -rf /app/apache2/htdocs

#Copy startup script, setup file, and permissions script
ARG SERVERNAME=localhost:8080
COPY docker_templates/gitlab-runner /etc/sudoers.d/
COPY docker_templates/httpd.conf /app/apache2/conf/
RUN sed -i "s/localhost\:8080/$SERVERNAME/" /app/apache2/conf/httpd.conf

USER gitlab-runner

CMD ["bash", "-c", "sudo /app/apache2/bin/apachectl -D FOREGROUND"]
