# Makefile for Mini Task API

# Variables
DOCKER_COMPOSE = docker-compose
PHP_CONTAINER = php
DB_CONTAINER = db

# Default target
.PHONY: help
help: ## Show this help message
	@echo "Usage: make [target]"
	@echo ""
	@echo "Targets:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}'

.PHONY: setup
setup: build up install ## First-time setup: build, start, and install dependencies
	@echo "Setup complete! API is running at http://localhost:8000"

.PHONY: build
build: ## Build docker containers
	$(DOCKER_COMPOSE) build

.PHONY: up
up: ## Start containers in detached mode
	$(DOCKER_COMPOSE) up -d

.PHONY: down
down: ## Stop and remove containers
	$(DOCKER_COMPOSE) down

.PHONY: restart
restart: down up ## Restart all containers

.PHONY: install
install: ## Install PHP dependencies (Composer)
	$(DOCKER_COMPOSE) exec $(PHP_CONTAINER) composer install

.PHONY: autoload
autoload: ## Refresh Composer autoloader (Fixes "Class not found" errors)
	$(DOCKER_COMPOSE) exec $(PHP_CONTAINER) composer dump-autoload

.PHONY: logs
logs: ## Tail logs for all containers
	$(DOCKER_COMPOSE) logs -f

.PHONY: shell
shell: ## Enter the PHP container shell
	$(DOCKER_COMPOSE) exec $(PHP_CONTAINER) /bin/bash

.PHONY: db-shell
db-shell: ## Enter the MySQL database shell
	$(DOCKER_COMPOSE) exec $(DB_CONTAINER) mysql -uuser -puserpass tasks_db

.PHONY: clean
clean: ## Remove containers, networks, and volumes (Resets DB)
	$(DOCKER_COMPOSE) down -v

# Run all unit tests
test:
	docker-compose exec php ./vendor/bin/phpunit tests --colors=always