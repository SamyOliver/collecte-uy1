# Utilisation de l'image PHP officielle avec Apache
FROM php:8.2-apache

# Installation de l'extension PDO pour MySQL (indispensable pour Aiven)
RUN docker-php-ext-install pdo pdo_mysql

# Copie de tous tes fichiers (.php, assets, etc.) dans le serveur
COPY . /var/www/html/

# On donne les droits d'accès au serveur web
RUN chown -R www-data:www-data /var/www/html

# Le port par défaut utilisé par Render pour Docker
EXPOSE 80