# Mini ECommerce Cart (Laravel)

## Description
Minimal Laravel application that implements a session-based shopping cart with hardcoded products.

## Requirements
- PHP 8.0+
- Composer
- Laravel 10+

## Setup Instructions

1. Clone or unzip this repository:
```bash
cd laravel-cart
```

2. Install Laravel via Composer (this will create the framework files):
```bash
composer create-project laravel/laravel=10.* . --prefer-dist --no-interaction
```

3. Copy the provided custom files over (they are already in place if you unzipped this):
- `app/Http/Controllers/ProductController.php`
- `app/Http/Controllers/CartController.php`
- `routes/web.php`
- `resources/views/layout.blade.php`
- `resources/views/products.blade.php`
- `resources/views/cart.blade.php`

4. Ensure session driver is file (default) in `.env` and app key is set:
```bash
php artisan key:generate
```

5. Serve the app:
```bash
php artisan serve
```

6. Open `http://127.0.0.1:8000` in browser.

## Features
- List of 3 hardcoded products.
- Add to cart, update quantity, remove item, clear cart.
- Checkout button clears cart with thank-you flash message.
- All cart data stored via Laravel session.
- RESTful POST routes for modifications.
- Blade views, no external packages.
