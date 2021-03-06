FROM php:8-apache

RUN apt update && apt install libapache2-mod-auth-openidc -y

COPY sso /var/www/html/sso
COPY web /var/www/html/web
COPY plex-sso-entrypoint /
COPY 000-default.conf /etc/apache2/sites-available/

ENTRYPOINT [ "/plex-sso-entrypoint" ]
CMD ["apache2-foreground"]

