up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear hotel-clear docker-pull docker-build docker-up hotel-init
test: hotel-test
test-coverage: hotel-test-coverage
test-unit: hotel-test-unit
test-unit-coverage: hotel-test-unit-coverage

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

hotel-init: hotel-composer-install hotel-assets-install  hotel-wait-db hotel-migrations hotel-fixtures hotel-ready

hotel-clear:
	docker run --rm -v ${PWD}/app:/app --workdir=/app alpine rm -f .ready

hotel-composer-install:
	docker-compose run --rm hotel-php-fpm composer install

hotel-assets-install:
	docker-compose run --rm hotel-node yarn install
	docker-compose run --rm hotel-node npm rebuild node-sass

hotel-wait-db:
	until docker-compose exec -T hotel-postgres pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done

hotel-migrations:
	docker-compose run --rm hotel-php-fpm php bin/console doctrine:migrations:migrate --no-interaction

hotel-fixtures:
	docker-compose run --rm hotel-php-fpm php bin/console doctrine:fixtures:load --no-interaction

hotel-ready:
	docker run --rm -v ${PWD}/app:/app --workdir=/app alpine touch .ready

hotel-assets-dev:
	docker-compose run --rm hotel-node npm run dev

hotel-test:
	docker-compose run --rm hotel-php-fpm php bin/phpunit

hotel-test-coverage:
	docker-compose run --rm hotel-php-fpm php bin/phpunit --coverage-clover var/clover.xml --coverage-html var/coverage

hotel-test-unit:
	docker-compose run --rm hotel-php-fpm php bin/phpunit --testsuite=unit

hotel-test-unit-coverage:
	docker-compose run --rm hotel-php-fpm php bin/phpunit --testsuite=unit --coverage-clover var/clover.xml --coverage-html var/coverage