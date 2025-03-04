up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose restart

exec:
	docker compose exec php sh

reset:
	docker compose build php
	docker compose up -d php