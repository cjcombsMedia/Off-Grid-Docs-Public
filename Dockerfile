FROM php:8.3-apache

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Copy application files
COPY . /var/www/app

# POINT APACHE TO APP DIRECTORY --- #
RUN sed -ri -e 's!/var/www/html!/var/www/app!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!/var/www/app!g' /etc/apache2/conf-available/*.conf

RUN printf ' \n\
    <Directory /var/www/app>\n\
        Options FollowSymLinks\n\
        AllowOverride All\n\
        Order allow,deny\n\
        Allow from all\n\
    </Directory>\n\
    ' >> /etc/apache2/sites-available/000-default.conf

# Ensure the assets directory is served
RUN printf ' \n\
    Alias /app/assets /var/www/app/assets\n\
    <Directory /var/www/app/assets>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride None\n\
        Require all granted\n\
    </Directory>\n\
    ' >> /etc/apache2/sites-available/000-default.conf

# CHANGE DEFAULT PHP CONFIG ---------- #
RUN printf ' \n\
file_uploads = On\n\
memory_limit = 128M\n\
upload_max_filesize = 100M\n\
post_max_size = 100M\n\
max_execution_time = 600\n\
variables_order = EGPCS\n\
' > /usr/local/etc/php/conf.d/docker-custom.ini

RUN a2enmod rewrite
WORKDIR /var/www/app/

EXPOSE 80
