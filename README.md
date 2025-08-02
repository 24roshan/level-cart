# Mini ECommerce Cart

## Overview
A session-based shopping cart with three hardcoded products.  
Built with Laravel 10 (preferred) and includes a plain PHP fallback for quick demo.  
All cart data is stored in session — no database required.

---

## Run Locally (PowerShell – Windows)

### Prerequisites
- **PHP 8.0+** installed  
- (Optional) [XAMPP](https://www.apachefriends.org/) for Windows PHP runtime  
- **Composer** (only for Laravel version)  

---

### 1️⃣ Clone the Repository
```powershell
git clone https://github.com/24roshan/laravel-cart.git
cd laravel-cart
2️⃣ Laravel Version (Preferred)
powershell
composer create-project laravel/laravel=10.* . --prefer-dist --no-interaction
php artisan key:generate
php artisan serve
➡ After running the last command, PowerShell will show:
Starting Laravel development server: http://127.0.0.1:8000
Open that URL in your browser.

3️⃣ Plain PHP Fallback (No Composer Needed)
powershell
& "C:\xampp\php\php.exe" -S localhost:8000
➡ Then open: http://localhost:8000/index.php in your browser.

4️⃣ Troubleshooting
If php is not recognized
Use the full path in PowerShell:

powershell
& "C:\xampp\php\php.exe" artisan serve
or
powershell
& "C:\xampp\php\php.exe" -S localhost:8000
If port 8000 is busy
Change the port:
powershell
php artisan serve --port=8080
or
powershell
& "C:\xampp\php\php.exe" -S localhost:8080
Features
3 hardcoded products (Laptop, Smartphone, Headphones)

Add to cart, update quantity, remove, clear cart

Checkout button clears cart with thank-you message

RESTful POST routes (Laravel version)

Blade views (Laravel) / Bootstrap styling (both versions)

Flash messages for success/failure
