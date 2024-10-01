DOCKER_COMPOSE=docker-compose
CONTAINER_NAME=misha_fpm

-include .env
export

.PHONY: init
init: up composer_install

.PHONY: up
up:
	$(DOCKER_COMPOSE) up -d

.PHONY: down
down:
	$(DOCKER_COMPOSE) down

.PHONY: restart
restart: down up

.PHONY: composer_install
composer_install:
	$(EXEC_INVESTING) composer install -n

.PHONY: exec
exec:
	docker exec -it $$CONTAINER_NAME bash
