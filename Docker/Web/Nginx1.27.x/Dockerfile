FROM nginx:1.27.5-alpine3.21

COPY nginx.conf /etc/nginx/conf.d/default.conf

HEALTHCHECK --start-period=2s --timeout=3s --retries=50 CMD wget -O /dev/null -q -T 2 http://127.0.0.1/robots.txt || exit 1
