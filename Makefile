.PHONY: install optimize test composer_install npm_install setup_env post_install optimize_app optimize_filament run_tests

install: composer_install build_containers setup_env start_containers generate_key npm_install post_install
optimize: optimize_app optimize_filament
test: run_phpunit run_phpstan
pint: run_pint
up: start_containers
start: up
down: stop_containers
stop: down
status: containers_status
restart: down up
build: build_containers

composer_install:
	@echo "Installing Composer Dependencies..."
	docker run --rm \
		-v $(shell pwd):/var/www/html \
		-w /var/www/html \
		composer:latest \
		composer install --ignore-platform-reqs --prefer-dist --no-ansi --no-interaction --no-progress --no-scripts

npm_install:
	@echo "Installing NPM Dependencies..."
	npm install

setup_env:
	@if [ ! -f .env ]; then \
		cp .env.example .env; \
	else \
		echo ".env already exists"; \
	fi

generate_key:
	@echo "Generating Application Key..."
	docker compose exec php-fpm php artisan key:generate

post_install:
	docker compose exec php-fpm php artisan migrate --force && \
	php artisan octane:install && \
	php artisan storage:link

optimize_app:
	@echo "Optimizing Application..."
	docker compose exec php-fpm php artisan optimize && \
	php artisan view:cache

optimize_filament:
	@echo "Optimizing Filament..."
	docker compose exec php-fpm php artisan icons:cache && \
	php artisan filament:cache-components

run_phpunit:
	@echo "Running Tests..."
	docker compose exec php-fpm ./vendor/bin/phpunit

run_phpstan:
	@echo "Running PHPStan..."
	docker compose exec php-fpm ./vendor/bin/phpstan analyse --memory-limit=2G

run_pint:
	@echo "Running Pint..."
	docker compose exec php-fpm ./vendor/bin/pint

start_containers:
	@echo "Starting Containers..."
	docker compose up -d

stop_containers:
	@echo "Stopping Containers..."
	docker compose down

containers_status:
	@echo "Checking Containers Status..."
	docker compose ps

build_containers:
	@echo "Building Containers..."
	docker compose build
