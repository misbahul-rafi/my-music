FROM php:8.2-apache
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get update && apt-get install nodejs -y


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# RUN curl -sS https://getcomposer.org/installer | php -- --version=2.7.6 --install-dir=/usr/local/bin --filename=composer


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy vhost config
COPY ./00-default.conf /etc/apache2/sites-enabled/000-default.conf

# Enable apache module
RUN a2enmod rewrite

# Copy project
COPY . .

# Remove dependency folder
RUN if [ -d node_modules ]; then rm -Rf node_modules; fi
RUN if [ -d vendor ]; then rm -Rf vendor; fi

# Setup permission
RUN chown -R www-data:www-data /var/www
RUN chmod -R g+w /var/www

# Update dependency
RUN composer update --no-dev
RUN npm install

# Build javascript dependency
RUN npm run build

# Remove javascript dependency folder
RUN if [ -d node_modules ]; then rm -Rf node_modules; fi

# Storage link
RUN if [ -d public/storage ]; then rm -Rf public/storage; fi
RUN php artisan storage:link

# Migrate Database
#RUN php artisan migrate

# Setup permission for cache and storage
RUN chown -R www-data:www-data bootstrap/cache/ storage/
RUN chmod -R 775 bootstrap/cache/ storage/

# Set default user
USER www-data

# Expose port
EXPOSE 80