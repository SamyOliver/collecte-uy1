# Utilisation de l'image PHP officielle avec Apache
FROM php:8.2-apache

# Installation de l'extension PDO pour MySQL (indispensable pour Aiven)
RUN docker-php-ext-install pdo pdo_mysql

# Activation du module rewrite d'Apache (essentiel pour la gestion des URL)
RUN a2enmod rewrite

# Copie de tous tes fichiers dans le serveur
COPY . /var/www/html/

# On donne les droits d'accès au serveur web pour éviter les erreurs 403
RUN chown -R www-data:www-data /var/www/html

# Le port interne sur lequel Apache écoute
EXPOSE 80

# Commande pour s'assurer qu'Apache reste actif au premier plan
CMD ["apache2-foreground"]