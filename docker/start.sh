#!/bin/bash

cd /app && \
php composer.phar --no-interaction update && \
php -S 0.0.0.0:80 -t www && \
echo "Serving on 0.0.0.0:80"
