FROM php:8.1-fpm-alpine

RUN apk add --no-cache nginx wget

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app
COPY ./src /app

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install --no-dev

RUN chown -R www-data: /app

CMD sh /app/docker/startup.sh

# Make the file executable, or use "chmod 777" instead of "chmod +x"
RUN chmod +x /app/migration.sh


# This will run the shell file at the time when container is up-and-running successfully (and NOT at the BUILD time)
# ENTRYPOINT ["/app/migration.sh"]