FROM ubuntu:20.04

ARG APACHE_VERSION=2.4.48
ARG PHP_VERSION=7.4.14

RUN apt update && apt-get install -qq -y curl wget gnupg && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && curl -sL https://deb.nodesource.com/setup_14.x | bash - && apt update && DEBIAN_FRONTEND=noninteractive apt-get install -qq -y wget vim libreadline-dev libssl-dev libpcre3-dev libexpat1-dev build-essential bison zlib1g-dev libxss1 libappindicator1 libindicator7 nodejs sudo tzdata unzip yarn less

RUN wget https://ai.galib.uga.edu/files/httpd-$APACHE_VERSION-w-apr.tar.gz && tar xzf httpd-$APACHE_VERSION-w-apr.tar.gz && cd httpd-$APACHE_VERSION && ./configure  '--prefix=/app/apache2' '--with-apxs2=/app/apache2/bin/apxs' '--with-mysqli' '--with-pear' '--with-xsl' '--with-pspell' '--enable-ssl' '--with-gettext' '--with-gd' '--enable-mbstring' '--with-mcrypt' '--enable-soap' '--enable-sockets' '--with-libdir=/lib/i386-linux-gnu' '--with-jpeg-dir=/usr' '--with-png-dir=/usr' '--with-curl' '--with-pdo-mysql' '--enable-so' '--with-included-apr' && make -j$(nproc) && make install && cd ..&& rm -rf httpd-$APACHE_VERSION*

ENV PATH /app/apache2/bin:$PATH

RUN sed -i "s/\/snap\/bin/\/snap\/bin:\/app\/apache2\/bin/" /etc/sudoers

RUN apt-get install -qq -y libcurl4-gnutls-dev pkg-config libpng-dev libonig-dev libsqlite3-dev libxml2-dev libmemcached-dev memcached && wget https://ai.galib.uga.edu/files/php-$PHP_VERSION.tar.gz && tar xzf php-$PHP_VERSION.tar.gz && cd php-$PHP_VERSION && './configure'  '--prefix=/usr/local' '--with-apxs2=/app/apache2/bin/apxs' '--with-mysqli' '--enable-mbstring' '--with-pdo-mysql' '--with-openssl' '--with-zlib' '--enable-gd' '--enable-opcache' '--with-curl' && make -j$(nproc) && make install && cp php.ini-production /usr/local/lib/php.ini && cd .. && rm -rf php-$PHP_VERSION*

RUN apt-get install -qq -y autoconf && wget https://pecl.php.net/get/memcached-3.1.5.tgz && tar xzf memcached-3.1.5.tgz && cd memcached-3.1.5 && phpize && ./configure && make && make install && echo "extension=memcached.so" >> /usr/local/lib/php.ini && cd .. && rm -rf memcached-3.1.5*

RUN sed -i "s/DirectoryIndex index.html/DirectoryIndex index.html index.php/" /app/apache2/conf/httpd.conf && sed -i "s/#AddType application\/x-gzip .tgz/AddType application\/x-httpd-php .php/" /app/apache2/conf/httpd.conf && sed -i "s/memory_limit = 128M/memory_limit = 1G/" /usr/local/lib/php.ini

RUN curl --output /usr/local/bin/composer https://getcomposer.org/composer.phar     && chmod +x /usr/local/bin/composer

RUN echo fs.inotify.max_user_watches=524288 | sudo tee -a /etc/sysctl.conf

RUN adduser --uid 997 --gecos 'gitlab-runner user' --disabled-password gitlab-runner

RUN rm -rf /app/apache2/htdocs

USER gitlab-runner

CMD ["/bin/bash"]
