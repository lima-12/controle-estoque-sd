FROM php:8.2-apache

# Instala extensões do PHP
RUN docker-php-ext-install pdo pdo_mysql

# Copia o código para o container
COPY . /var/www/html/

# Habilita o mod_rewrite do Apache (opcional)
RUN a2enmod rewrite

# Permissões
RUN chown -R www-data:www-data /var/www/html
