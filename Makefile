.PHONY: install optimize test composer_install npm_install setup_env post_install optimize_app optimize_filament run_tests

install: composer_install npm_install setup_env post_install
optimize: optimize_app optimize_filament
test: run_phpunit run_phpstan
codestyle: run_pint

composer_install:
	@echo "Installing Composer dependencies..."
	composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

npm_install:
	@echo "Installing NPM dependencies..."
	npm install --omit=dev

setup_env:
	@if [ ! -f .env ]; then \
		cp .env.example .env
		php artisan key:generate
	else \
		echo ".env already exists"
	fi

post_install:
	php artisan migrate --force

optimize_app:
	@echo "Optimizing application..."
	php artisan optimize
	php artisan view:cache

optimize_filament:
	@echo "Optimizing Filament..."
	php artisan icons:cache
	php artisan filament:cache-components

run_phpunit:
	@echo "Running tests..."
	php artisan test

run_phpstan:
	@echo "Running tests..."
	./vendor/bin/phpstan analyse --memory-limit=2G

run_pint:
	./vendor/bin/pint
