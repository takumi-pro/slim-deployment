.PHONY: up
up:
	docker-compose up -d

.PHONY: down
down:
	docker-compose down

.PHONY: connect-container
connect-container:
	docker exec -it postgres /bin/sh
