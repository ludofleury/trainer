FROM nginx

COPY vhost.conf /etc/nginx/sites-enabled/default
RUN sed -e 's|include /etc/nginx/conf.d/\*.conf;|include /etc/nginx/sites-enabled/\*;|' -i /etc/nginx/nginx.conf

ENTRYPOINT ["nginx", "-g", "daemon off;"]
