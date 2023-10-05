#syntax=docker/dockerfile:1.4

# Versions
FROM php:8.2-fpm-alpine AS php_upstream
FROM mlocati/php-extension-installer:2 AS php_extension_installer_upstream
FROM composer/composer:2-bin AS composer_upstream


# The different stages of this Dockerfile are meant to be built into separate images
# https://docs.docker.com/develop/develop-images/multistage-build/#stop-at-a-specific-build-stage
# https://docs.docker.com/compose/compose-file/#target


# Base PHP image
FROM php_upstream AS php_base

WORKDIR /var/www

# persistent / runtime deps
# hadolint ignore=DL3018
RUN apk add --no-cache \
		acl \
		fcgi \
		file \
		gettext \
		git \
        curl \
	;

# Symfony-CLI
RUN apk add --no-cache bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add symfony-cli

# php extensions installer: https://github.com/mlocati/docker-php-extension-installer
COPY --from=php_extension_installer_upstream --link /usr/bin/install-php-extensions /usr/local/bin/

RUN set -eux; \
        install-php-extensions \
        gd \
        apcu \
        intl \
        opcache \
        zip \
        pgsql \
        pdo_pgsql \
    ;

RUN mkdir -p /var/run/php

#RUN chmod +x /usr/local/bin/docker-healthcheck

HEALTHCHECK --interval=10s --timeout=3s --retries=3 CMD ["docker-healthcheck"]

#RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

COPY --from=composer_upstream --link /composer /usr/bin/composer

RUN composer require symfony/orm-pack
RUN composer require symfony/test-pack
RUN composer require symfony/security-bundle

# Dev PHP image
FROM php_base AS php_dev

ENV APP_ENV=dev XDEBUG_MODE=off

RUN chown -R www-data:www-data /var/www

RUN set -eux; \
    install-php-extensions \
      xdebug \
    ;

WORKDIR /var/www

RUN composer require --dev symfony/maker-bundle
RUN composer require --dev symfony/debug-pack

#RUN php bin/console --env=test doctrine:database:create;
#RUN php bin/console --env=test doctrine:schema:create;

EXPOSE 9000

CMD ["php-fpm"]

## Prod PHP image
#FROM php_base AS php_prod
#
#ENV APP_ENV=prod
#
## prevent the reinstallation of vendors at every changes in the source code
#COPY --link composer.* symfony.* ./
#RUN set -eux; \
#	composer install --no-cache --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress
#
## copy sources
#COPY --link . ./
#RUN rm -Rf docker/
#
#RUN set -eux; \
#	mkdir -p var/cache var/log; \
#	composer dump-autoload --classmap-authoritative --no-dev; \
#	composer dump-env prod; \
#	composer run-script --no-dev post-install-cmd; \
#	chmod +x bin/console; sync;