FROM php:8.2-cli

ARG DEV_USER_ID=1000
ARG DEV_GROUP_ID=1000

# Establece directorio de trabajo
WORKDIR /usr/asentamientos-mexico

# Instalación de bibliotecas y paquetes necesarios
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    libxslt-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    nano \
    build-essential  \
    poppler-utils \
    locales \
    zip \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    curl \
    vim \
    unzip \
    git \
    python3 \
    python3-pandas

ENV LANG=C.UTF-8

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalación de extensiones para PHP
RUN docker-php-ext-install zip xml mbstring curl pdo_mysql pcntl
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd

# Instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN groupadd -g ${DEV_GROUP_ID} dev
RUN useradd -u ${DEV_USER_ID} -ms /bin/bash -g dev dev

# Copia todos los archivos al directorio del trabajo
COPY --chown=dev:dev . /usr/asentamientos-mexico

USER dev
