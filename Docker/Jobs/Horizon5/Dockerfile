FROM ghcr.io/my-project/my-project.com-app-image-dev:latest

STOPSIGNAL SIGTERM

COPY entrypoint.sh /usr/local
RUN chmod +x /usr/local/entrypoint.sh

USER www-data

HEALTHCHECK --start-period=2s CMD pgrep -f php\./app/artisan\.horizon | grep . || exit 1

ENTRYPOINT ["/usr/local/entrypoint.sh"]
