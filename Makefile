up: docker-up websockets
down: docker-down
restart: docker-down docker-up websockets
init: docker-down-clear manager-clear docker-pull docker-build docker-up manager-init
test: manager-test
test-coverage: manager-test-coverage
test-unit: manager-test-unit
test-unit-coverage: manager-test-unit-coverage

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

manager-init: manager-composer-install manager-assets-install manager-oauth-keys  manager-migrations manager-fixtures manager-ready

manager-clear:
	docker run --rm -v ${PWD}/manager:/app --workdir=/app alpine rm -f .ready

manager-composer-install:
	docker-compose run --rm manager-php-cli composer install

manager-assets-install:
	docker-compose run --rm manager-node yarn install
	docker-compose run --rm manager-node npm rebuild node-sass

manager-oauth-keys:
	docker-compose run --rm manager-php-cli mkdir -p var/oauth
	docker-compose run --rm manager-php-cli openssl genrsa -out var/oauth/private.key 2048
	docker-compose run --rm manager-php-cli openssl rsa -in var/oauth/private.key -pubout -out var/oauth/public.key
	docker-compose run --rm manager-php-cli chmod 644 var/oauth/private.key var/oauth/public.key

manager-wait-db:
	until docker-compose exec -T mariadb pg_isready --timeout=0 --dbname=mysql ; do sleep 1 ; done

manager-migrations:
	docker-compose run --rm manager-php-cli php artisan migrate --no-interaction

manager-fixtures:
	docker-compose run --rm manager-php-cli php artisan db:seed --class=DatabaseSeeder --no-interaction

manager-ready:
	docker run --rm -v ${PWD}/manager:/app --workdir=/app alpine touch .ready

manager-assets-dev:
	docker-compose run --rm manager-node npm install && npm run dev

manager-npminstall:
	docker-compose run --rm manager-node npm install @fortawesome/fontawesome-free --save-dev  && npm run dev

manager-composer-add:
	docker-compose run --rm manager-php-cli composer require pusher/pusher-php-server "~3.0"

websockets:
    docker-compose exec manager-php-fpm php artisan websocket:serve
