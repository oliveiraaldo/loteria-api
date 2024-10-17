# Use a imagem oficial do PHP 8.1 com CLI
FROM php:8.1-cli

# Atualize e instale dependências necessárias
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    sqlite3 \
    pkg-config \
    git \
    unzip \
    && docker-php-ext-configure pdo_sqlite --with-pdo-sqlite=/usr/local \
    && docker-php-ext-install pdo pdo_sqlite \
    && docker-php-ext-install zip
    
# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto para o contêiner
COPY . /var/www/html

# Permissão para o banco de dados
RUN chmod 777 /var/www/html/database/loteria.db

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependências PHP do projeto
RUN if [ -f "composer.json" ]; then composer install; fi

# Executar script para criar o banco de dados
RUN php database/create_db.php

# Expor a porta para acesso
EXPOSE 80

# Comando padrão para iniciar o servidor PHP
CMD php -S 0.0.0.0:80 -t public
