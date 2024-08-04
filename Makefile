.PHONY: install optimize test composer_install npm_install setup_env post_install optimize_app optimize_filament run_tests

install: composer_install build_sail setup_env start_sail generate_key npm_install post_install
optimize: optimize_app optimize_filament
test: run_phpunit run_phpstan
pint: run_pint
up: start_sail
start: up
down: stop_sail
stop: down
status: sail_status
restart: down up
build: build_sail

composer_install:
	@echo "Installing Composer Dependencies..."
	docker run --rm \
		-v $(shell pwd):/var/www/html \
		-w /var/www/html \
		laravelsail/php82-composer:latest \
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
	php artisan key:generate

post_install:
	php artisan migrate --force
	php artisan octane:install
	php artisan storage:link

optimize_app:
	@echo "Optimizing Application..."
	php artisan optimize
	php artisan view:cache

optimize_filament:
	@echo "Optimizing Filament..."
	php artisan icons:cache
	php artisan filament:cache-components

run_phpunit:
	@echo "Running Tests..."
	php artisan test

run_phpstan:
	@echo "Running PHPStan..."
	./vendor/bin/phpstan analyse --memory-limit=2G

run_pint:
	@echo "Running Pint..."
	./vendor/bin/pint

start_sail:
	@echo "Starting Containers..."
	docker compose up -d

stop_sail:
	@echo "Stopping Containers..."
	docker compose down

sail_status:
	@echo "Checking Containers Status..."
	docker compose ps

build_sail:
	@echo "Building Containers..."
	docker compose build
