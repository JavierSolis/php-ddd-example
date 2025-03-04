up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose restart

exec:
	docker compose exec php sh

test:
	docker compose exec php ./vendor/bin/phpunit

reset:
	docker compose down
	docker compose up -d
	
reset-all:
	docker compose down -v --rmi all
	docker compose up -d
	docker compose exec php composer install
	# Espera a que MySQL esté listo antes de continuar
	docker compose exec php sh -c 'until nc -z -v -w30 db 3306; do echo "Waiting for database..."; sleep 5; done'
	docker compose exec php php setup/create_schema.php
	docker compose exec php ./vendor/bin/phpunit

reset-vol:
	docker compose down -v
	docker compose up -d
	docker compose exec php composer install
	# Espera a que MySQL esté listo antes de continuar
	docker compose exec php sh -c 'until nc -z -v -w30 db 3306; do echo "Waiting for database..."; sleep 5; done'
	docker compose exec php php setup/create_schema.php
	docker compose exec php ./vendor/bin/phpunit

build:
	docker compose up -d
	docker compose exec php composer install
	# Espera a que MySQL esté listo antes de continuar
	docker compose exec php sh -c 'until nc -z -v -w30 db 3306; do echo "Waiting for database..."; sleep 5; done'
	docker compose exec php php setup/create_schema.php
	docker compose exec php ./vendor/bin/phpunit