FROM php:8.1-cli-buster

# check package updates
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive

ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=$USER_UID

# install utils
RUN apt-get install -y \
    sudo \
    nano

# add vscode user
RUN groupadd --gid ${USER_GID} ${USERNAME} \
    && useradd -s /bin/bash --uid ${USER_UID} --gid ${USERNAME} -m ${USERNAME}

# enable sudoer
RUN echo $USERNAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/${USERNAME} \
    && chmod 0440 /etc/sudoers.d/${USERNAME}

# configure and install pgsql driver
RUN apt-get install -y --no-install-recommends libpq-dev \
    && docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql

# configure and install zip/unzip
RUN apt-get install -y --no-install-recommends libzip-dev zip unzip \
    && docker-php-ext-install zip

# install composer
RUN curl -sSL https://getcomposer.org/installer | php \
    && chmod +x composer.phar \
    && mv composer.phar /usr/local/bin/composer

# install symfony cli
RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list \
    && apt-get update \
    && apt-get install -y symfony-cli