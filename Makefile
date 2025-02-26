build:
	docker-compose build

up:
	docker-compose up -d

test:
	docker-compose exec php vendor/bin/phpunit

migrate:
	docker-compose exec php vendor/bin/doctrine orm:schema-tool:update --force

down:
	docker-compose down
