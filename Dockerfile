FROM yiisoftware/yii2-php:7.4-fpm-nginx

# Создаем директории для хранения логов
RUN mkdir -p /var/log/nginx
RUN mkdir -p /app/runtime/nginx

# Перенаправляем логи на файлы внутри контейнера
RUN ln -sf /var/log/nginx/access.log /app/runtime/nginx/access.log && \
    ln -sf /var/log/nginx/error.log /app/runtime/nginx/error.log