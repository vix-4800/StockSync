.PHONY: install optimize test composer_install npm_install setup_env post_install optimize_app optimize_filament run_tests

install: composer_install npm_install setup_env post_install
optimize: optimize_app optimize_filament
test: run_phpunit run_phpstan
codestyle: run_pint

composer_install:
	@echo "Installing Composer dependencies..."
	docker run --rm \
		-u $(shell id -u):$(shell id -g) \
		-v $(shell pwd):/var/www/html \
		-w /var/www/html \
		laravelsail/php82-composer:latest \
		composer install --ignore-platform-reqs

npm_install:
	@echo "Installing NPM dependencies..."
	./vendor/bin/sail npm install

setup_env:
	@if [ ! -f .env ]; then \
		cp .env.example .env; \
		./vendor/bin/sail php artisan key:generate; \
	else \
		echo ".env already exists"; \
	fi

post_install:
	./vendor/bin/sail php artisan migrate --force

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
	./vendor/bin/sail ./vendor/bin/pint
