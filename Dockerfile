FROM php:8.1.13-fpm

WORKDIR /var/www

ARG user
ARG uid

RUN apt-get update && apt-get install -y -q \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    zlib1g-dev \
    supervisor \
    python3.9 \
    python3-pip \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev

RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user


RUN composer install --prefer-dist --no-progress --optimize-autoloader; \
    composer clear-cache

COPY --chown=$user:$user . /var/www

USER $user

CMD ["/usr/local/sbin/php-fpm"]
