#!/bin/bash

# Reset
Color_Off='\033[0m'       # Text Reset
Yellow='\033[0;33m'       # Yellow

echo -e ${Yellow}
echo "===> Pulling and spinning up Docker containers"
echo -e ${Color_Off}

#cp .env.example .env

docker-compose pull
docker-compose build
docker-compose -f docker-compose.yml up -d
#sleep 5;

echo -e ${Yellow}
echo "===> Installing composer"
echo -e ${Color_Off}

docker exec funds_app_1 composer global require "fxp/composer-asset-plugin:^1.2.0"
docker exec funds_app_1 composer install -d /app

echo -e ${Yellow}
echo "===> Dump DB"
echo -e ${Color_Off}

docker exec -i funds_db_1 mysql -u root --password=root db < dump/funds_2018-02-17.sql
docker exec -i funds_app_1 php /app/yii migrate --interactive=0
    
echo -e ${Yellow}
echo "=== Done ==="
echo -e ${Color_Off}
