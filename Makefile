.PHONY: build up down ps status logs shell restart pint larastan test install migrate post-install generate_key wait seed optimize_app optimize_filament storage_link

install: install_composer_dependencies install_npm_dependencies check_env
post-install: build up generate_key wait migrate seed octane storage_link
optimize: optimize_app optimize_filament

install_composer_dependencies:
	@echo "\nInstalling Composer Dependencies..."

	docker run --rm \
		-v $(shell pwd):/var/www/html \
		-w /var/www/html \
		composer:latest \
		composer install --ignore-platform-reqs --prefer-dist --no-ansi --no-interaction --no-progress --no-scripts

install_npm_dependencies:
	@echo "\nInstalling NPM Dependencies..."

	npm install

check_env:
	@echo "\nChecking Environment Variables..."

	@if [ ! -f .env ]; then \
		cp .env.example .env; \
	else \
		echo ".env already exists"; \
	fi

build:
	@echo "\nBuilding Containers..."
	docker compose build

up:
	@echo "\nStarting Containers..."
	docker compose up -d

down:
	@echo "\nStopping Containers..."
	docker compose down

ps:
	@echo "\nChecking Containers Status..."
	docker compose ps

logs:
	@echo "\nChecking Containers Logs..."
	docker compose logs -f

shell:
	@echo "\nOpening Shell..."
	docker compose exec -it php-fpm /bin/bash

restart:
	@echo "\nRestarting Containers..."
	docker compose restart

pint:
	@echo "\nRunning Pint..."
	docker compose exec php-fpm ./vendor/bin/pint

larastan:
	@echo "\nRunning PHPStan..."
	docker compose exec php-fpm ./vendor/bin/phpstan analyse --memory-limit=2G

octane:
	@echo "\nInstalling Octane..."
	php artisan octane:install

storage_link:
	@echo "\nLinking Storage..."
	docker compose exec php-fpm php artisan storage:link

test:
	@echo "\nRunning Tests..."
	docker compose exec php-fpm php artisan test

wait:
	@echo "\nWaiting for MySQL to start..."
	@sleep 10

migrate:
	@echo "\nRunning Migrations..."
	docker compose exec php-fpm php artisan migrate --force

generate_key:
	@echo "\nGenerating Application Key..."
	docker compose exec php-fpm php artisan key:generate

seed:
	@echo "\nSeeding Database..."
	docker compose exec php-fpm php artisan db:seed

optimize_app:
	@echo "\nOptimizing Application..."
	docker compose exec php-fpm php artisan optimize && \
	php artisan view:cache

optimize_filament:
	@echo "\nOptimizing Filament..."
	docker compose exec php-fpm php artisan icons:cache && \
	php artisan filament:cache-components
