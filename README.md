# StockSync

StockSync is a comprehensive solution for sellers who operate on multiple marketplaces, such as Ozon and Wildberries. This Laravel-based application allows you to seamlessly track and manage your orders, monitor your inventory, and streamline your sales operations across various platforms.

## Key Features

-   Order Tracking: Consolidate and monitor orders from Ozon and Wildberries in one unified interface.
-   Inventory Management: Keep track of your stock levels across all connected marketplaces, ensuring you never run out of products.
-   Sales Analytics: Gain insights into your sales performance with detailed reports and analytics.
-   Multi-Platform Integration: Easily integrate with additional marketplaces as your business grows.
-   User-Friendly Dashboard: Navigate through your data with an intuitive and easy-to-use interface.
-   Real-Time Updates: Stay up-to-date with real-time notifications and updates on your orders and inventory.
-   Customizable Settings: Tailor the application to fit your specific business needs and workflows.

## Installation

To get started, follow these steps:

-   Clone the repository:

    ```
    git clone https://github.com/vix-4800/StockSync.git
    ```

-   Navigate to the project directory:

    ```
    cd stocksync
    ```

-   Install the dependencies:

    ```
    composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs
    npm install --omit=dev
    ```

-   Set up your environment variables by copying the .env.example file:

    ```
    cp .env.example .env
    ```

-   Generate an application key:

    ```
    php artisan key:generate
    ```

-   Run the migrations:

    ```
    php artisan migrate --force
    ```

-   Start the development server:

    ```
    php artisan serve
    ```

Alternatively you can use Makefile

```
make install
```

## Optimization

You can optimize the application's performance significantly by running these commands:

```
php artisan optimize
php artisan view:cache
php artisan icons:cache
php artisan filament:cache-components
```

Or using the Makefile:

```
make optimize
```

## Running Tests

To run the tests, use the following command:

```
make test
```

Or without the Makefile:

```
php artisan test
./vendor/bin/phpstan analyse --memory-limit=2G
```

## License

This project is licensed under the MIT License.
