#!/bin/bash

echo -e ${WARN_COLOR}
echo "===> Pulling and spinning up Docker containers"
echo -e ${NO_COLOR}

#cp .env.example .env

docker-compose pull
docker-compose build
docker-compose -f docker-compose.yml up -d
#sleep 5;

echo -e ${WARN_COLOR}
echo "===> Installing composer"
echo -e ${NO_COLOR}

docker exec funds_app_1 composer global require "fxp/composer-asset-plugin:^1.2.0"
docker exec funds_app_1 composer install -d /app

echo -e ${WARN_COLOR}
echo "===> Dump DB"
echo -e ${NO_COLOR}

docker exec -i funds_db_1 mysql -u root --password=root db < dump/funds_2018-02-13.sql
docker exec -i funds_app_1 php /app/yii migrate --interactive=0
    
echo -e ${WARN_COLOR}
echo "=== Done ==="
echo -e ${NO_COLOR}
