FROM php:7.4-fpm-alpine3.16
#换源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories
#安装tadata
RUN apk add tzdata
#安装php-composer
RUN php -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');"; \
	php composer-setup.php; \
	php -r "unlink('composer-setup.php');"; \
	mv composer.phar /usr/local/bin/composer
#安装gd依赖
RUN apk add \
        freetype \
        freetype-dev \
        libpng \
        libpng-dev \
        libjpeg-turbo \
        libjpeg-turbo-dev 
#安装gd库
RUN  docker-php-ext-configure gd \
	--with-freetype=/usr/include/ \
	--with-jpeg=/usr/include/; \
	cd /usr/src/php/ext/gd; \
	docker-php-ext-install gd
	
#安装think-captcha
RUN docker-php-ext-install bcmath
RUN composer require topthink/think-captcha

#安装psql驱动
RUN apk add libpq-dev
RUN docker-php-ext-install pgsql pdo_pgsql pdo


RUN php-fpm &
ENTRYPOINT ["/usr/local/bin/php"]
CMD ["think","run"]

