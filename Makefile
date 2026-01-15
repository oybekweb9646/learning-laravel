# =========================
# Project
# =========================
PROJECT_NAME=laravel_backend
COMPOSE_FILE=docker-compose.prod.yml

APP_SERVICE=php
APP_USER=1000:1000

# =========================
# Docker helpers
# =========================
exec = docker compose -p $(PROJECT_NAME) -f $(COMPOSE_FILE) exec -u $(APP_USER) $(APP_SERVICE)

exec-root = docker compose -p $(PROJECT_NAME) -f $(COMPOSE_FILE) exec $(APP_SERVICE)

# =========================
# Laravel
# =========================

artisan:
	$(exec) php artisan

migrate:
	$(exec) php artisan migrate --force

migrate-fresh:
	$(exec) php artisan migrate:fresh --seed --force

make-migration:
	@read -p "Migration name: " name; \
	$(exec) php artisan make:migration $$name

make-model:
	@read -p "Model name: " name; \
	$(exec) php artisan make:model $$name -m

make-controller:
	@read -p "Controller name: " name; \
	$(exec) php artisan make:controller $$name

make-seeder:
	@read -p "Seeder name: " name; \
	$(exec) php artisan make:seeder $$name

# =========================
# Cache / optimize
# =========================

cache-clear:
	$(exec) php artisan optimize:clear

optimize:
	$(exec) php artisan optimize

# =========================
# Composer
# =========================

composer-install:
	$(exec) composer install --no-dev --optimize-autoloader

composer-update:
	$(exec) composer update

# =========================
# Permissions
# =========================

fix-permissions:
	$(exec-root) chown -R 1000:1000 /app/storage /app/bootstrap/cache /app/database

# =========================
# Shell
# =========================

bash:
	$(exec) bash

root:
	$(exec-root) bash

# =========================
# Docker
# =========================

up:
	docker compose -p $(PROJECT_NAME) -f $(COMPOSE_FILE) up -d --build

down:
	docker compose -p $(PROJECT_NAME) -f $(COMPOSE_FILE) down

ps:
	docker compose -p $(PROJECT_NAME) -f $(COMPOSE_FILE) ps

logs:
	docker compose -p $(PROJECT_NAME) -f $(COMPOSE_FILE) logs -f
