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
shell: shell_sail

composer_install:
	@echo "Installing Composer dependencies..."
	docker run --rm \
		-v $(shell pwd):/var/www/html \
		-w /var/www/html \
		laravelsail/php82-composer:latest \
		composer install --ignore-platform-reqs --prefer-dist --no-ansi --no-interaction --no-progress --no-scripts

npm_install:
	@echo "Installing NPM dependencies..."
	./vendor/bin/sail npm install

setup_env:
	@if [ ! -f .env ]; then \
		cp .env.example .env; \
	else \
		echo ".env already exists"; \
	fi

start_sail:
	@echo "Starting Laravel Sail..."
	./vendor/bin/sail up -d

generate_key:
	@echo "Generating Application Key..."
	./vendor/bin/sail php artisan key:generate

post_install:
	./vendor/bin/sail php artisan migrate --force
	./vendor/bin/sail php artisan octane:install

optimize_app:
	@echo "Optimizing application..."
	./vendor/bin/sail php artisan optimize
	./vendor/bin/sail php artisan view:cache

optimize_filament:
	@echo "Optimizing Filament..."
	./vendor/bin/sail php artisan icons:cache
	./vendor/bin/sail php artisan filament:cache-components

run_phpunit:
	@echo "Running tests..."
	./vendor/bin/sail php artisan test

run_phpstan:
	@echo "Running PHPStan..."
	./vendor/bin/sail php ./vendor/bin/phpstan analyse --memory-limit=2G

run_pint:
	@echo "Running Pint..."
	./vendor/bin/pint

stop_sail:
	@echo "Stopping Laravel Sail..."
	./vendor/bin/sail down

sail_status:
	@echo "Checking Laravel Sail status..."
	./vendor/bin/sail ps

build_sail:
	@echo "Building Containers..."
	./vendor/bin/sail build

shell_sail:
	@echo "Starting Laravel Sail shell..."
	./vendor/bin/sail shell
